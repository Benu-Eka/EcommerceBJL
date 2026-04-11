<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SaldoTransaction;
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

    // Diskon dinamis berdasarkan kategori pelanggan
    $diskonPersen = (float) ($pelanggan->kategoriPelanggan->jumlah_diskon ?? 0);

    $subtotal = $cartItems->sum(fn ($i) => $i->barang->harga_jual * $i->jumlah);
    $biayaPengiriman = 5000;
    $diskon = $subtotal * ($diskonPersen / 100);
    $totalBayar = (int) ($subtotal - $diskon + $biayaPengiriman); // 🔥 CAST INT

    $order_id = "ORD-" . now()->format('Ymd') . "-" . strtoupper(Str::random(6));

    $order = Order::create([
        'order_id' => $order_id,
        'pelanggan_id' => $pelanggan->pelanggan_id,
        'nama_penerima' => $request->nama_penerima,
        'alamat' => $request->alamat,
        'telepon' => $request->telepon,
        'total' => $totalBayar,
        'status' => 'pending',
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

        DB::transaction(function () use ($order, $pelanggan, $totalBayar) {
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

            // Buat Surat Jalan
            $sj_id = "SJ-" . now()->format('Ymd') . "-" . strtoupper(Str::random(5));
            SuratJalan::create([
                'sj_id' => $sj_id,
                'user_id' => \App\Models\User::first()->user_id ?? '', // Ambil admin pertama
                'pelanggan_id' => $order->pelanggan_id,
                'tanggal_surat' => now(),
                'status' => 'Disetujui',
                'biaya_pengiriman' => 0, // HARUS ADA
                'diskon_pelanggan' => 0, // HARUS ADA
                'subtotal' => $order->total
            ]);

            foreach ($order->items as $item) {
                SuratJalanDetail::create([
                    'detail_sj_id' => 'SJD-' . strtoupper(Str::random(6)),
                    'sj_id' => $sj_id,
                    'kode_barang' => $item->kode_barang,
                    'quantity' => $item->quantity,
                    'harga_satuan' => $item->harga_satuan,
                    'satuan' => 'pcs' // HARUS ADA
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
                'order_id' => $order_id,
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

    $order = Order::where('order_id', $request->order_id)
        ->with('items')
        ->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    $order->midtrans_response = json_encode($request->all());

    if ($request->transaction_status === 'settlement') {

        $order->status = 'dibayar';
        $order->save();

        $sj_id = "SJ-" . now()->format('Ymd') . "-" . strtoupper(Str::random(5));

        SuratJalan::create([
            'sj_id' => $sj_id,
            'user_id' => \App\Models\User::first()->user_id ?? '', // Ambil admin pertama
            'pelanggan_id' => $order->pelanggan_id,
            'tanggal_surat' => now(),
            'status' => 'Disetujui',
            'biaya_pengiriman' => 0, // HARUS ADA
            'diskon_pelanggan' => 0, // HARUS ADA
            'subtotal' => $order->total
        ]);

        foreach ($order->items as $item) {
            SuratJalanDetail::create([
                'detail_sj_id' => 'SJD-' . strtoupper(Str::random(6)),
                'sj_id' => $sj_id,
                'kode_barang' => $item->kode_barang,
                'quantity' => $item->quantity,
                'harga_satuan' => $item->harga_satuan,
                'satuan' => 'pcs' // HARUS ADA
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

        // Detail transaksi
        $transaction_details = [
            'order_id' => $order->order_id,
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
