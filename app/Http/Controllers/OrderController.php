<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\SuratJalanDetail;
use Illuminate\Support\Facades\Auth;
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
    $cartItems = $pelanggan->cartItems()->with('barang')->get();

    if ($cartItems->isEmpty()) {
        return response()->json([
            'error' => 'Keranjang kosong'
        ], 400);
    }

    $subtotal = $cartItems->sum(fn ($i) => $i->barang->harga_jual * $i->jumlah);
    $biayaPengiriman = 5000;
    $diskon = $subtotal * 0.10;
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
            'pelanggan_id' => $order->pelanggan_id,
            'tanggal_surat' => now(),
            'status' => 'Disetujui',
            'subtotal' => $order->total
        ]);

        foreach ($order->items as $item) {
            SuratJalanDetail::create([
                'detail_sj_id' => 'SJD-' . strtoupper(Str::random(6)),
                'sj_id' => $sj_id,
                'kode_barang' => $item->kode_barang,
                'quantity' => $item->quantity,
                'harga_satuan' => $item->harga_satuan,
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

    return redirect()->route('orders.show', $order_id)
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

public function pesanan()
{
    $userId = Auth::guard('pelanggan')->id();

    $orders = [
        'dikemas' => Order::where('pelanggan_id', $userId)
            ->where('status', 'dikemas')
            ->latest()
            ->get(),

        'dibayar' => Order::where('pelanggan_id', $userId)
            ->where('status', 'dibayar')
            ->latest()
            ->get(),

        'dikirim' => Order::where('pelanggan_id', $userId)
            ->where('status', 'dikirim')
            ->latest()
            ->get(),

        'selesai' => Order::where('pelanggan_id', $userId)
            ->where('status', 'selesai')
            ->latest()
            ->get(),

        'dibatalkan' => Order::where('pelanggan_id', $userId)
            ->where('status', 'batal')
            ->latest()
            ->get(),
    ];

    $pesananBelumBayar = Order::where('pelanggan_id', $userId)
        ->where('status', 'pending')
        ->latest()
        ->get();

    return view('orders.pesanan', compact(
        'orders',
        'pesananBelumBayar'
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

    $orders = Order::where('pelanggan_id', $userId)
        ->with('items.barang')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('orders.riwayat', compact('orders'));
}


}
