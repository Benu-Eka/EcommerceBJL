<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\SuratJalan;
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

    $subtotal = $cartItems->sum(fn($i) => $i->barang->harga_jual * $i->jumlah);
    $biayaPengiriman = 5000;
    $diskon = $subtotal * 0.10;
    $totalBayar = $subtotal - $diskon + $biayaPengiriman;

    // 🔥 Generate kode order
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

    // Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');

    $params = [
        'transaction_details' => [
            'order_id' => $order_id,
            'gross_amount' => $totalBayar,
        ],
        'customer_details' => [
            'first_name' => $pelanggan->nama,
            'phone' => $pelanggan->telepon,
        ]
    ];

    $snapToken = Snap::getSnapToken($params);

    $order->update([
        'midtrans_order_id' => $order_id,
    ]);

    return response()->json([
        'success' => true,
        'snap_token' => $snapToken,
        'order_id' => $order_id
    ]);
}


public function callback(Request $request)
{
    Log::info("MIDTRANS CALLBACK", $request->all());

    $order = Order::where('order_id', $request->order_id)->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    $order->midtrans_response = json_encode($request->all());

    if ($request->transaction_status === 'settlement') {

        $order->status = 'dibayar';
        $order->save();

        // 🔥 Baru buat surat jalan di sini
        $sj_id = "SJ-" . now()->format('Ymd') . "-" . strtoupper(Str::random(5));

        $surat = SuratJalan::create([
            'sj_id' => $sj_id,
            'pelanggan_id' => $order->pelanggan_id,
            'tanggal_surat' => now(),
            'status' => 'Disetujui',
            'subtotal' => $order->total
        ]);

        // 🔥 Pindahkan cart ke surat_jalan_detail
        foreach ($order->pelanggan->cartItems as $item) {
            SuratJalanDetail::create([
                'detail_sj_id' => 'SJD-' . strtoupper(Str::random(6)),
                'sj_id' => $sj_id,
                'kode_barang' => $item->kode_barang,
                'quantity' => $item->jumlah,
                'harga_satuan' => $item->barang->harga_jual,
            ]);
        }

        // Hapus cart
        $order->pelanggan->cartItems()->delete();

        return response()->json(['message' => 'Pembayaran sukses & surat jalan dibuat!']);
    }

    // Pending
    if ($request->transaction_status == 'pending') {
        $order->status = 'pending';
        $order->save();
        return response()->json(['message' => 'Menunggu pembayaran']);
    }

    // Failed or Cancelled
    if (in_array($request->transaction_status, ['expire', 'cancel', 'deny'])) {
        $order->status = 'failed';
        $order->save();
        return response()->json(['message' => 'Pembayaran gagal']);
    }
}

    public function success()
{
    return view('orders.success')->with('message', 'Pembayaran berhasil! Surat jalan sedang diproses.');
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

    $pesananBelumBayar = Order::where('pelanggan_id', $userId)
                            ->where('status', 'pending')
                            ->get();

    $orderIds = $pesananBelumBayar->pluck('order_id');

    // Hitung jumlah item yang ada dalam semua order pending
    $countItemBelumBayar = OrderItem::whereIn('order_id', $orderIds)->count();

    return view('orders.pesanan', compact(
        'pesananBelumBayar',
        'countItemBelumBayar'
    ));
}

public function show($order_id)
{
    $userId = Auth::guard('pelanggan')->id();

    // Ambil order spesifik berdasarkan pelanggan dan order_id
    $order = Order::where('pelanggan_id', $userId)
                    ->where('order_id', $order_id)
                    ->with('items')
                    ->firstOrFail();

    return view('orders.detail', compact('order'));
}

public function riwayat()
{
    $user = Auth::guard('pelanggan')->user();

    $orders = Order::with('items.barang')
        ->where('pelanggan_id', $user->pelanggan_id)
        ->where('status', 'selesai')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('orders.riwayat', compact('orders'));
}

}
