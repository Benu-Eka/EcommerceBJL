@extends('layouts.app')

@section('title', 'Riwayat Pembelian')

@section('content')
<div class="min-h-screen bg-white font-inter">
    <x-navbar />

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-12">

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

            @forelse ($orders as $order)
                <div class="flex items-center justify-between bg-white border rounded-xl shadow-sm p-4 hover:shadow-md transition">

                    {{-- Kiri --}}
                    <div class="flex items-center space-x-4">
                        {{-- Gambar produk pertama --}}
                        @php
                            $firstItem = $order->items->first();
                            $image = $firstItem && $firstItem->barang->gambar
                                ? asset('storage/' . $firstItem->barang->gambar)
                                : 'https://via.placeholder.com/80x80?text=Produk';
                        @endphp

                        <img src="{{ $image }}" class="w-16 h-16 rounded-lg object-cover">

                        <div>
                            <h2 class="font-semibold text-gray-800">
                                {{ $order->items->first()->nama_barang ?? 'Produk' }}
                                @if($order->items->count() > 1)
                                    + {{ $order->items->count() - 1 }} lainnya
                                @endif
                            </h2>
                            
                            <p class="text-sm text-gray-500">
                                Tanggal: {{ $order->created_at->format('d M Y') }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Status:
                                <span class="font-medium text-green-600">Selesai</span>
                            </p>
                        </div>
                    </div>

                    {{-- Kanan --}}
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </p>

                        <a href="{{ route('orders.show', $order->order_id) }}"
                            class="mt-2 block text-sm text-red-600 font-medium hover:text-red-800">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Belum ada riwayat pembelian selesai.</p>
            @endforelse

        </div>
    </main>

    <x-footer />
</div>
@endsection
