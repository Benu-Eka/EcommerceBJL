<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SaldoTransaction;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\SuratJalanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.checkout');
    }

    public function pay(Request $request)
{
    $request->validate([
        'nama_penerima' => 'required',
        'alamat' => 'required',
        'telepon' => 'required',
    ]);

    $pelanggan = Auth::guard('pelanggan')->user();
    $pelanggan->load('kategoriPelanggan');
    $cartItems = $pelanggan->cartItems()->with('barang')->get();

    if ($cartItems->isEmpty()) {
        return response()->json([
            'error' => 'Keranjang kosong'
        ], 400);
    }

    // Validasi stok sebelum checkout
    foreach ($cartItems as $item) {
        $stok = StokBarang::where('kode_barang', $item->kode_barang)->first();
        $stokTersedia = $stok ? (int) $stok->jumlah : 0;
        if ($item->jumlah > $stokTersedia) {
            return response()->json([
                'error' => 'Stok ' . ($item->barang->nama_barang ?? $item->kode_barang) . ' tidak mencukupi (tersedia: ' . $stokTersedia . ')'
            ], 400);
        }
    }

    // Diskon dinamis berdasarkan kategori pelanggan
    $diskonPersen = (float) ($pelanggan->kategoriPelanggan->jumlah_diskon ?? 0);

    $subtotal = $cartItems->sum(fn ($i) => $i->barang->harga_jual * $i->jumlah);
    $biayaPengiriman = 5000;
    $diskon = $subtotal * ($diskonPersen / 100);
    $totalBayar = (int) ($subtotal - $diskon + $biayaPengiriman); // 🔥 CAST INT

    $order_id = "ORD-" . now()->format('Ymd') . "-" . strtoupper(Str::random(6));

    $midtransOrderId = $order_id . '-' . time();

    $order = Order::create([
        'order_id' => $order_id,
        'pelanggan_id' => $pelanggan->pelanggan_id,
        'nama_penerima' => $request->nama_penerima,
        'alamat' => $request->alamat,
        'telepon' => $request->telepon,
        'total' => $totalBayar,
        'status' => 'pending',
        'midtrans_order_id' => $midtransOrderId,
    ]);

    foreach ($cartItems as $item) {
        OrderItem::create([
            'order_id'     => $order->order_id,
            'kode_barang'  => $item->kode_barang,
            'nama_barang'  => $item->barang->nama_barang,
            'harga_satuan' => $item->barang->harga_jual,
            'quantity'     => $item->jumlah,
        ]);
    }

    // KOSONGKAN KERANJANG SETELAH CHECKOUT BERHASIL
    $pelanggan->cartItems()->delete();

    // PROSES PEMBAYARAN SALDO
    if ($request->pembayaran === 'saldo') {
        if ($pelanggan->saldo < $totalBayar) {
            return response()->json(['error' => 'Saldo tidak mencukupi'], 400);
        }

        DB::transaction(function () use ($order, $pelanggan, $totalBayar, $biayaPengiriman, $diskon) {
            $saldoSebelum = (float) $pelanggan->saldo;
            $saldoSesudah = $saldoSebelum - $totalBayar;

            $pelanggan->saldo = $saldoSesudah;
            $pelanggan->save();

            SaldoTransaction::create([
                'pelanggan_id' => $pelanggan->pelanggan_id,
                'order_id' => $order->order_id,
                'tipe' => 'penggunaan',
                'jumlah' => $totalBayar,
                'saldo_sebelum' => $saldoSebelum,
                'saldo_sesudah' => $saldoSesudah,
                'keterangan' => 'Pembayaran pesanan ' . $order->order_id,
            ]);

            $order->status = 'dibayar';
            $order->save();

            // Kurangi stok barang
            foreach ($order->items as $item) {
                $stok = StokBarang::where('kode_barang', $item->kode_barang)->first();
                if ($stok) {
                    $stok->jumlah = max(0, $stok->jumlah - $item->quantity);
                    $stok->tanggal_keluar = now();
                    $stok->save();
                }
            }

            // Buat Surat Jalan
            $adminUser = \App\Models\User::first();
            $sj_id = "SJ-" . now()->format('Ymd') . "-" . strtoupper(Str::random(5));
            SuratJalan::create([
                'sj_id' => $sj_id,
                'user_id' => $adminUser ? ($adminUser->user_id ?? $adminUser->id) : 'SYSTEM',
                'pelanggan_id' => $order->pelanggan_id,
                'nama_penerima' => $order->nama_penerima,
                'tanggal_surat' => now(),
                'status' => 'Disetujui',
                'biaya_pengiriman' => $biayaPengiriman,
                'diskon_pelanggan' => $diskon,
                'subtotal' => $order->total
            ]);

            foreach ($order->items as $item) {
                SuratJalanDetail::create([
                    'detail_sj_id' => 'SJD-' . strtoupper(Str::random(6)),
                    'sj_id' => $sj_id,
                    'kode_barang' => $item->kode_barang,
                    'quantity' => $item->quantity,
                    'harga_satuan' => $item->harga_satuan,
                    'satuan' => $item->barang->satuan_jual ?? 'pcs'
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'type' => 'saldo',
            'order_id' => $order->order_id
        ]);
    }

    // PROSES PEMBAYARAN MIDTRANS
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    try {
        $params = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => $totalBayar, // HARUS INT & > 0
            ],
            'customer_details' => [
                'first_name' => $pelanggan->nama,
                'phone' => $pelanggan->telepon,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'success' => true,
            'snap_token' => $snapToken,
            'order_id' => $order_id
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}



public function callback(Request $request)
{
    Log::info("MIDTRANS CALLBACK", $request->all());

    $order = Order::where('midtrans_order_id', $request->order_id)
        ->orWhere('order_id', $request->order_id)
        ->with('items')
        ->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    $order->midtrans_response = json_encode($request->all());

    if ($request->transaction_status === 'settlement') {

        $order->status = 'dibayar';
        $order->save();

        // Kurangi stok barang
        foreach ($order->items as $item) {
            $stok = StokBarang::where('kode_barang', $item->kode_barang)->first();
            if ($stok) {
                $stok->jumlah = max(0, $stok->jumlah - $item->quantity);
                $stok->tanggal_keluar = now();
                $stok->save();
            }
        }

        // Hitung ulang diskon & ongkir untuk surat jalan
        $pelangganOrder = $order->pelanggan;
        $pelangganOrder->load('kategoriPelanggan');
        $diskonPersen = (float) ($pelangganOrder->kategoriPelanggan->jumlah_diskon ?? 0);
        $subtotalBarang = $order->items->sum(fn ($i) => $i->harga_satuan * $i->quantity);
        $diskonNominal = $subtotalBarang * ($diskonPersen / 100);
        $biayaPengiriman = 5000;

        $adminUser = \App\Models\User::first();
        $sj_id = "SJ-" . now()->format('Ymd') . "-" . strtoupper(Str::random(5));

        SuratJalan::create([
            'sj_id' => $sj_id,
            'user_id' => $adminUser ? ($adminUser->user_id ?? $adminUser->id) : 'SYSTEM',
            'pelanggan_id' => $order->pelanggan_id,
            'nama_penerima' => $order->nama_penerima,
            'tanggal_surat' => now(),
            'status' => 'Disetujui',
            'biaya_pengiriman' => $biayaPengiriman,
            'diskon_pelanggan' => $diskonNominal,
            'subtotal' => $order->total
        ]);

        foreach ($order->items as $item) {
            SuratJalanDetail::create([
                'detail_sj_id' => 'SJD-' . strtoupper(Str::random(6)),
                'sj_id' => $sj_id,
                'kode_barang' => $item->kode_barang,
                'quantity' => $item->quantity,
                'harga_satuan' => $item->harga_satuan,
                'satuan' => $item->barang->satuan_jual ?? 'pcs'
            ]);
        }

        return response()->json(['message' => 'Pembayaran sukses & surat jalan dibuat']);
    }

    if ($request->transaction_status === 'pending') {
        $order->status = 'pending';
        $order->save();
    }

    if (in_array($request->transaction_status, ['expire', 'cancel', 'deny'])) {
        $order->status = 'failed';
        $order->save();
    }

    return response()->json(['message' => 'Callback processed']);
}

public function success($order_id)
{
    $order = Order::where('order_id', $order_id)->firstOrFail();

    // Hanya update jika status masih pending
    if ($order->status === 'pending') {
        $order->status = 'dibayar';
        $order->updated_at = now();
        $order->save();
    }

    return redirect()->route('orders.pesanan', ['tab' => 'dibayar'])
                     ->with('success', 'Pembayaran berhasil! Surat jalan sedang diproses.');
}

public function pending()
{
    return view('orders.pending')->with('message', 'Pembayaran sedang diproses, mohon tunggu.');
}

public function failed()
{
    return view('orders.failed')->with('message', 'Pembayaran gagal atau dibatalkan.');
}

public function pesanan(Request $request)
{
    $userId = Auth::guard('pelanggan')->id();

    $orders = [
        'dikemas' => Order::where('pelanggan_id', $userId)
            ->where('status', 'dikemas')
            ->with('items.barang')
            ->latest()
            ->get(),

        'dibayar' => Order::where('pelanggan_id', $userId)
            ->where('status', 'dibayar')
            ->with('items.barang')
            ->latest()
            ->get(),

        'dikirim' => Order::where('pelanggan_id', $userId)
            ->where('status', 'dikirim')
            ->with('items.barang')
            ->latest()
            ->get(),

        'selesai' => Order::where('pelanggan_id', $userId)
            ->where('status', 'selesai')
            ->with('items.barang')
            ->latest()
            ->get(),

        'dibatalkan' => Order::where('pelanggan_id', $userId)
            ->where('status', 'batal')
            ->with('items.barang')
            ->latest()
            ->get(),
    ];

    $pesananBelumBayar = Order::where('pelanggan_id', $userId)
        ->where('status', 'pending')
        ->with('items.barang')
        ->latest()
        ->get();

    // Tab aktif dari query parameter (untuk navigasi dari submenu navbar)
    $activeTab = $request->query('tab', 'belum-bayar');

    return view('orders.pesanan', compact(
        'orders',
        'pesananBelumBayar',
        'activeTab'
    ));
}

protected function generateMidtransSnapToken($order)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isSanitized = true;
        Config::$isProduction = false; // set true jika production

        // Karena ini pembayaran ulang, perbarui token referensi ke midtrans agar terhindar dari Error 'sudah digunakan'
        $midtransOrderId = $order->order_id . '-' . time();
        $order->midtrans_order_id = $midtransOrderId;
        $order->save();

        // Detail transaksi
        $transaction_details = [
            'order_id' => $midtransOrderId,
            'gross_amount' => $order->total,
        ];

        // Detail pelanggan
        $customer_details = [
            'first_name' => $order->nama_penerima,
            'phone'      => $order->telepon,
            'address'    => $order->alamat
        ];

        // Params untuk Snap
        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        // Generate Snap Token
        return Snap::getSnapToken($params);
    }

    public function payPending(Request $request, $orderId)
    {
        try {
            $order = Order::where('order_id', $orderId)->firstOrFail();

            if($order->status !== 'pending'){
                return response()->json(['error' => 'Pesanan tidak bisa diproses, status bukan pending.'], 400);
            }

            $snapToken = $this->generateMidtransSnapToken($order);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $order->order_id
            ]);

        } catch (\Exception $e) {
            \Log::error('PayPending Error: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan server.'], 500);
        }
    }

public function show($order_id)
{
    $userId = Auth::guard('pelanggan')->id();

    $order = Order::where('order_id', $order_id)
        ->where('pelanggan_id', $userId)
        ->with('items.barang')
        ->firstOrFail();

    return view('orders.detail', compact('order'));
}


public function riwayat()
{
    $userId = Auth::guard('pelanggan')->id();

    // Hanya tampilkan pesanan yang sudah selesai
    $orders = Order::where('pelanggan_id', $userId)
        ->where('status', 'selesai')
        ->with('items.barang')
        ->orderBy('created_at', 'desc')
        ->get();

    // Bangun rekomendasi repeat order dari riwayat pembelian
    // Kumpulkan semua barang yang pernah dibeli, urutkan berdasarkan frekuensi
    $rekomendasiProduk = collect();
    foreach ($orders as $order) {
        foreach ($order->items as $item) {
            if ($item->barang) {
                $key = $item->kode_barang;
                if ($rekomendasiProduk->has($key)) {
                    $existing = $rekomendasiProduk->get($key);
                    $existing['total_qty'] += $item->quantity;
                    $existing['total_order'] += 1;
                    $rekomendasiProduk->put($key, $existing);
                } else {
                    $rekomendasiProduk->put($key, [
                        'barang' => $item->barang,
                        'nama_barang' => $item->nama_barang ?? $item->barang->nama_barang,
                        'total_qty' => $item->quantity,
                        'total_order' => 1,
                        'last_ordered' => $order->created_at,
                    ]);
                }
            }
        }
    }

    // Urutkan berdasarkan frekuensi pembelian (terbanyak dulu)
    $rekomendasiProduk = $rekomendasiProduk->sortByDesc('total_order')->values();

    return view('orders.riwayat', compact('orders', 'rekomendasiProduk'));
}

public function confirmReceived($orderId)
{
    $userId = Auth::guard('pelanggan')->id();

    $order = Order::where('order_id', $orderId)
        ->where('pelanggan_id', $userId)
        ->where('status', 'dikirim')
        ->firstOrFail();

    $order->status = 'selesai';
    $order->save();

    return redirect()->route('orders.pesanan', ['tab' => 'selesai'])
        ->with('success', 'Pesanan berhasil dikonfirmasi sebagai diterima!');
}

public function cancelOrder($orderId)
{
    $pelanggan = Auth::guard('pelanggan')->user();

    $order = Order::where('order_id', $orderId)
        ->where('pelanggan_id', $pelanggan->pelanggan_id)
        ->whereIn('status', ['pending', 'dibayar'])
        ->firstOrFail();

    // Jika pending, langsung batalkan saja tanpa perlu persetujuan admin karena belum ada dana masuk
    if ($order->status === 'pending') {
        $order->status = 'batal';
        $order->save();
        return redirect()->back()->with('success', 'Pesanan belum dibayar berhasil dibatalkan.');
    }

    // Jika sudah dibayar, ajukan pembatalan ke admin
    $order->cancel_requested = 1;
    $order->save();

    return redirect()->back()->with('success', 'Pengajuan pembatalan telah dikirim. Menunggu konfirmasi admin untuk memproses refund.');
}

public function saldoPage()
{
    $pelanggan = Auth::guard('pelanggan')->user();
    $transactions = SaldoTransaction::where('pelanggan_id', $pelanggan->pelanggan_id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('orders.saldo', compact('pelanggan', 'transactions'));
}


}
