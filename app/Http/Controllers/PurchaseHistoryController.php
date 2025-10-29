<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PurchaseHistoryController extends Controller
{
    /**
     * Tampilkan daftar riwayat pembelian
     */
    public function index()
    {
        $userId = auth()->id();

        $orders = Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.history', compact('orders'));
    }

    /**
     * Tampilkan detail salah satu pesanan
     */
    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        return view('orders.detail', compact('order'));
    }
}
