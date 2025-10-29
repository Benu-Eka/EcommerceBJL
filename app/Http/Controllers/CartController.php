<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // ambil user id (fallback ke 1 jika belum pakai auth)
        $userId = Auth::id() ?? 1;

        // ambil data cart beserta relasi barang
        $cartItems = Cart::with('barang')->where('user_id', $userId)->get();

        // hitung subtotal (jika barang atau harga null, gunakan safe fallback)
        $subtotal = $cartItems->sum(function($item) {
            $harga = $item->barang->harga_jual ?? 0;
            return $harga * ($item->jumlah ?? 0);
        });

        return view('chart.index', compact('cartItems', 'subtotal'));
    }

        public function add(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|exists:barangs,kode_barang',
            'jumlah' => 'nullable|integer|min:1',
        ]);

        $userId = Auth::id() ?? 1;
        $kodeBarang = $request->kode_barang;
        $jumlah = $request->jumlah ?? 1;

        // Cek apakah barang sudah ada di cart
        $cartItem = Cart::where('user_id', $userId)
                        ->where('kode_barang', $kodeBarang)
                        ->first();

        if ($cartItem) {
            // Jika sudah ada, tambahkan jumlahnya
            $cartItem->jumlah += $jumlah;
            $cartItem->save();
        } else {
            // Jika belum, tambahkan item baru
            Cart::create([
                'user_id' => $userId,
                'kode_barang' => $kodeBarang,
                'jumlah' => $jumlah,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

}
