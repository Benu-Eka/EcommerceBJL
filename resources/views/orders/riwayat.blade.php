@extends('layouts.app')

@section('title', 'Riwayat Pembelian')

@section('content')
<div class="min-h-screen bg-[#f9fafb]">
    <x-navbar />

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-16">

        <div class="mb-8">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-500 hover:text-red-700 font-medium transition-colors duration-200 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-black text-gray-900 mt-3 tracking-tight">Riwayat Pembelian</h1>
            <p class="text-sm text-gray-400 mt-1">Semua riwayat transaksi Anda</p>
        </div>

        {{-- Daftar Riwayat --}}
        <div class="space-y-4">

            @forelse ($orders as $order)
                @php
                    $firstItem = $order->items->first();
                    $image = null;
                    if ($firstItem && $firstItem->barang && $firstItem->barang->foto_produk) {
                        $image = $firstItem->barang->foto_produk;
                    }

                    // Status color mapping
                    $statusColors = [
                        'pending'  => 'bg-yellow-50 text-yellow-700',
                        'dibayar'  => 'bg-blue-50 text-blue-700',
                        'dikemas'  => 'bg-indigo-50 text-indigo-700',
                        'dikirim'  => 'bg-purple-50 text-purple-700',
                        'selesai'  => 'bg-green-50 text-green-700',
                        'batal'    => 'bg-red-50 text-red-700',
                        'failed'   => 'bg-red-50 text-red-700',
                    ];

                    $statusLabels = [
                        'pending'  => 'Menunggu Pembayaran',
                        'dibayar'  => 'Sudah Dibayar',
                        'dikemas'  => 'Sedang Dikemas',
                        'dikirim'  => 'Sedang Dikirim',
                        'selesai'  => 'Selesai',
                        'batal'    => 'Dibatalkan',
                        'failed'   => 'Gagal',
                    ];

                    $colorClass = $statusColors[$order->status] ?? 'bg-gray-50 text-gray-700';
                    $statusLabel = $statusLabels[$order->status] ?? ucfirst($order->status);
                @endphp

                <a href="{{ route('orders.show', $order->order_id) }}" 
                   class="flex items-center justify-between bg-white border border-gray-100 rounded-2xl shadow-sm p-5 hover:shadow-md hover:border-gray-200 transition-all duration-200 group">

                    {{-- Kiri: Gambar + Info --}}
                    <div class="flex items-center space-x-4 min-w-0">
                        {{-- Gambar produk pertama --}}
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                            @if($image)
                                <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover" alt="Produk">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0">
                            <h2 class="font-bold text-gray-900 text-sm truncate group-hover:text-red-700 transition-colors">
                                {{ $firstItem->nama_barang ?? 'Produk' }}
                                @if($order->items->count() > 1)
                                    <span class="text-gray-400 font-normal">+ {{ $order->items->count() - 1 }} lainnya</span>
                                @endif
                            </h2>
                            
                            <p class="text-xs text-gray-400 mt-1">
                                {{ $order->order_id }} · {{ $order->created_at->format('d M Y, H:i') }}
                            </p>

                            <span class="inline-block mt-2 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $colorClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>

                    {{-- Kanan: Total + Arrow --}}
                    <div class="text-right flex-shrink-0 ml-4 flex items-center gap-3">
                        <div>
                            <p class="font-black text-gray-900 text-sm">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-1">
                                {{ $order->items->count() }} item
                            </p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            @empty
                <div class="text-center py-24 bg-white rounded-[3rem] border border-dashed border-gray-200">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-black text-gray-900">Belum Ada Riwayat</h2>
                    <p class="text-gray-400 text-sm mt-2">Riwayat pembelian Anda akan muncul di sini.</p>
                    <a href="{{ route('product') }}" class="inline-block mt-6 text-red-600 font-bold border-b-2 border-red-600 pb-1 hover:text-red-800 transition">Belanja Sekarang</a>
                </div>
            @endforelse

        </div>
    </main>

    <x-footer />
</div>
@endsection
