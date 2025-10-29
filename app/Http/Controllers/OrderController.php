<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Contoh data dummy
        $orders = [
            'belum_bayar' => [
                [
                    'id' => 1,
                    'nama' => 'Minyak Goreng Refill 2L',
                    'jumlah' => 2,
                    'total' => 76000,
                    'status' => 'Belum Bayar',
                    'gambar' => 'minyak-goreng.png',
                ],
            ],
            'dikemas' => [
                [
                    'id' => 2,
                    'nama' => 'Tepung Terigu Segitiga 1kg',
                    'jumlah' => 10,
                    'total' => 125000,
                    'status' => 'Dikemas',
                    'gambar' => 'tepung-terigu.jpg',
                ],
            ],
            'dikirim' => [],
            'selesai' => [],
            'dibatalkan' => [],
        ];

        // Kirim data ke view
        return view('orders.pesanan', compact('orders'));
    }
}
