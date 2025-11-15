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

    $cartItems = $pelanggan->cartItems()->with('barang')->get();

    return view('orders.checkout', compact('cartItems'));
}

        // Ambil isi keranjang
        $cartItems = $pelanggan->cartItems()->with('barang')->get();
        $subtotal = $cartItems->sum(function ($item) {
            return $item->barang->harga_jual * $item->jumlah;
        });

        return view('orders.checkout', compact('pelanggan', 'cartItems', 'subtotal'));
    }

    /** =========================
     *  PROSES ORDER + MIDTRANS
     *  =========================*/
    public function process(Request $request)
    {
        $pelanggan = Auth::user();

        // Hitung total
        $cartItems = $pelanggan->cartItems()->with('barang')->get();
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang masih kosong');
        }

        $subtotal = $cartItems->sum(function ($i) {
            return $i->barang->harga_jual * $i->jumlah;
        });

        // Simpan ORDER
        $order = Order::create([
            'pelanggan_id' => $pelanggan->pelanggan_id,
            'nama_penerima' => $request->nama_penerima,
            'alamat' => $request->alamat,
            'status' => 'pending',
            'total' => $subtotal
        ]);

        // Simpan ITEM ORDER
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'kode_barang' => $item->kode_barang,
                'quantity' => $item->jumlah,
                'harga_satuan' => $item->barang->harga_jual,
            ]);
        }

        // Midtrans Init
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $midtransParams = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->order_id . '-' . time(),
                'gross_amount' => $order->total
            ],
            'customer_details' => [
                'first_name' => $pelanggan->nama_pelanggan,
                'email'      => $pelanggan->email,
                'phone'      => $pelanggan->telepon ?? '-'
            ]
        ];

        $snapToken = Snap::getSnapToken($midtransParams);

        // Simpan ID midtrans ke order
        $order->update([
            'midtrans_order_id' => $midtransParams['transaction_details']['order_id']
        ]);

        return response()->json([
            'snap_token' => $snapToken,
            'order_id'   => $order->order_id
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

            // Otomatis buat surat jalan
            // -------------------------
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
