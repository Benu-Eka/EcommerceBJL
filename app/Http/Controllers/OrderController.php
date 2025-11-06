<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function checkout()
    {
        // Ambil data dari session cart (jika ada)
        $cart = Session::get('cart', []);

        // Perhitungan total
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $handling = 5000; // biaya penanganan tetap
        $discount = 0; // bisa dikembangkan nanti
        $total = $subtotal + $handling - $discount;

        return view('orders.checkout', compact('cart', 'subtotal', 'handling', 'discount', 'total'));
    }
}
