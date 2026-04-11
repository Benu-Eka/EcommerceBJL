<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Barang;
use Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    /** =========================
     *  TAMPILKAN HALAMAN CHECKOUT
     *  =========================*/
    public function showCheckout()
    {
        
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('pelanggan.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $pelanggan->load('kategoriPelanggan');
        $cartItems = $pelanggan->cartItems()->with('barang')->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->barang->harga_jual * $item->jumlah;
        });

        // Diskon dinamis berdasarkan kategori pelanggan
        $kategoriNama = $pelanggan->kategoriPelanggan->kategori_pelanggan ?? '-';
        $diskonPersen = (float) ($pelanggan->kategoriPelanggan->jumlah_diskon ?? 0);

        $biayaPengiriman = 5000;
        $diskon = $subtotal * ($diskonPersen / 100);
        $totalBayar = $subtotal - $diskon + $biayaPengiriman;

        return view('orders.checkout', compact(
            'pelanggan',
            'cartItems',
            'subtotal',
            'diskon',
            'biayaPengiriman',
            'totalBayar',
            'kategoriNama',
            'diskonPersen'
        ));
    }


    /** =========================
     *  PROSES ORDER + MIDTRANS
     *  =========================*/
public function process(Request $request)
{
    $pelanggan = Auth::guard('pelanggan')->user();
    $pelanggan->load('kategoriPelanggan');
    $cartItems = $pelanggan->cartItems()->with('barang')->get();

    if ($cartItems->isEmpty()) {
        return response()->json(['error' => 'Keranjang kosong'], 400);
    }

    // Diskon dinamis berdasarkan kategori pelanggan
    $diskonPersen = (float) ($pelanggan->kategoriPelanggan->jumlah_diskon ?? 0);

    $subtotal = $cartItems->sum(fn($i) => $i->barang->harga_jual * $i->jumlah);
    $biayaPengiriman = 5000;
    $diskon = $subtotal * ($diskonPersen / 100);
    $totalBayar = $subtotal - $diskon + $biayaPengiriman;

    $order = Order::create([
        'pelanggan_id'   => $pelanggan->pelanggan_id,
        'nama_penerima'  => $request->nama_penerima,
        'alamat'         => $request->alamat,
        'status'         => 'pending',
        'total'          => $totalBayar
    ]);

    foreach ($cartItems as $item) {
        OrderItem::create([
            'order_id'      => $order->order_id,
            'kode_barang'   => $item->kode_barang,
            'quantity'      => $item->jumlah,
            'harga_satuan'  => $item->barang->harga_jual,
        ]);
    }

    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production', false);
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $midtransParams = [
        'transaction_details' => [
            'order_id'      => 'ORDER-' . $order->order_id . '-' . time(),
            'gross_amount' => (int) $totalBayar
        ],
        'customer_details' => [
            'first_name' => $pelanggan->nama_pelanggan,
            'email'      => $pelanggan->email,
            'phone'      => $pelanggan->telepon ?? '-'
        ]
    ];

    $snapToken = Snap::getSnapToken($midtransParams);

    $order->update([
        'midtrans_order_id' => $midtransParams['transaction_details']['order_id']
    ]);

    return response()->json([
        'snap_token'         => $snapToken,
        'order_id'           => $order->order_id,
        'midtrans_order_id'  => $order->midtrans_order_id
    ]);
}


    /** =========================
     *  CALLBACK MIDTRANS
     *  =========================*/
    public function callback(Request $request)
    {
        $data = json_decode($request->getContent());

        $order = Order::where('midtrans_order_id', $data->order_id)->first();
        if (!$order) return;

        if ($data->transaction_status == 'settlement') {

            $order->update(['status' => 'dibayar']);

            // Buat surat jalan otomatis
            \DB::table('surat_jalan')->insert([
                'order_id' => $order->order_id,
                'tanggal'  => now(),
                'status'   => 'Siap Dikirim'
            ]);
        }

        if (in_array($data->transaction_status, ['deny','cancel','expire'])) {
            $order->update(['status' => 'batal']);
        }
    }

}
