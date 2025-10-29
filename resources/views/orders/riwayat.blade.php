@extends('layouts.app')

@section('title', 'Riwayat Pembelian')

@section('content')
<div class="min-h-screen bg-white font-inter">
    <x-navbar />

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-12">
        {{-- Tombol kembali dan judul --}}
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-red-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-3">Riwayat Pembelian</h1>
        </div>

        {{-- Daftar Riwayat --}}
        <div class="space-y-4">
            @php
                $orders = [
                    [
                        'id' => 'INV-001',
                        'status' => 'Selesai',
                        'tanggal' => '2025-10-15',
                        'total' => 'Rp250.000',
                        'produk' => 'Bumbu Dapur Lengkap 1kg',
                        'gambar' => 'https://via.placeholder.com/80x80?text=Produk'
                    ],
                    [
                        'id' => 'INV-002',
                        'status' => 'Dikirim',
                        'tanggal' => '2025-10-18',
                        'total' => 'Rp180.000',
                        'produk' => 'Cabai Bubuk 500gr',
                        'gambar' => 'https://via.placeholder.com/80x80?text=Produk'
                    ],
                    [
                        'id' => 'INV-003',
                        'status' => 'Dibatalkan',
                        'tanggal' => '2025-10-20',
                        'total' => 'Rp100.000',
                        'produk' => 'Kecap Manis Premium 1L',
                        'gambar' => 'https://via.placeholder.com/80x80?text=Produk'
                    ]
                ];
            @endphp

            @foreach ($orders as $order)
                <div class="flex items-center justify-between bg-white border rounded-xl shadow-sm p-4 hover:shadow-md transition">
                    <div class="flex items-center space-x-4">
                        <img src="{{ $order['gambar'] }}" alt="Produk" class="w-16 h-16 rounded-lg object-cover">
                        <div>
                            <h2 class="font-semibold text-gray-800">{{ $order['produk'] }}</h2>
                            <p class="text-sm text-gray-500">Tanggal: {{ $order['tanggal'] }}</p>
                            <p class="text-sm text-gray-500">Status: 
                                <span class="@if($order['status'] == 'Selesai') text-green-600 
                                              @elseif($order['status'] == 'Dikirim') text-blue-600 
                                              @elseif($order['status'] == 'Dibatalkan') text-red-600 
                                              @else text-gray-600 @endif font-medium">
                                    {{ $order['status'] }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">{{ $order['total'] }}</p>
                        <button class="mt-2 text-sm text-red-600 font-medium hover:text-red-800">Lihat Detail</button>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <x-footer />
</div>
@endsection
