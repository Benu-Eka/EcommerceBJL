@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="bg-gray-50 min-h-screen">
    {{-- Asumsi: x-navbar dan x-footer sudah memiliki styling yang baik --}}
    <x-navbar />

    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">
        {{-- Tombol Kembali --}}
        <a href="{{ route('orders.pesanan') }}" 
           class="text-gray-600 hover:text-blue-700 flex items-center mb-6 font-medium transition duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Pesanan
        </a>

        {{-- Container Utama Detail Pesanan --}}
        <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg border border-gray-200">
            
            {{-- Header Detail & Status --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-4 border-b border-gray-200 mb-4">
                <h2 class="text-2xl font-bold text-gray-800">
                    Detail Pesanan
                    <span class="text-base text-gray-500 font-normal block sm:inline-block">({{ $order->order_id }})</span>
                </h2>

                {{-- Status Badge Dinamis --}}
                <span class="text-sm font-bold px-3 py-1 rounded-full mt-2 sm:mt-0 whitespace-nowrap
                    @php
                        $status = strtolower($order->status ?? 'pending');
                        if ($status === 'belum_bayar') {
                            echo 'text-yellow-700 bg-yellow-100 border border-yellow-200';
                        } elseif (in_array($status, ['dikirim', 'diproses'])) {
                            echo 'text-blue-700 bg-blue-100 border border-blue-200';
                        } elseif ($status === 'selesai') {
                            echo 'text-green-700 bg-green-100 border border-green-200';
                        } elseif (in_array($status, ['dibatalkan', 'gagal'])) {
                            echo 'text-red-700 bg-red-100 border border-red-200';
                        } else {
                            echo 'text-gray-700 bg-gray-100 border border-gray-200';
                        }
                    @endphp
                ">
                    Status: {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>
            
            {{-- Bagian Informasi Tambahan (Opsional: Alamat, Waktu) --}}
            {{-- Anda bisa menambahkan bagian ini di sini --}}

            {{-- Produk yang Dibeli --}}
            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200 mt-6">
                <h3 class="font-bold text-xl text-gray-700 mb-4 border-b pb-2">Daftar Produk</h3>

                {{-- Loop Item Produk --}}
                @forelse($order->items as $item)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-b-0">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item->nama_barang ?? $item->name }}</p>
                            <p class="text-sm text-gray-500 mt-0.5">Jumlah: <span class="font-medium">{{ $item->quantity ?? $item->qty }}</span></p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-700">Rp{{ number_format($item->harga_satuan ?? $item->price, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">Subtotal: Rp{{ number_format(($item->harga_satuan ?? $item->price) * ($item->quantity ?? $item->qty), 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Tidak ada item dalam pesanan ini.</p>
                @endforelse

                {{-- Total Keseluruhan --}}
                <div class="flex justify-between font-extrabold text-xl mt-5 pt-3 border-t border-gray-300">
                    <span class="text-gray-800">TOTAL BAYAR</span>
                    <span class="text-blue-600">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
            
            {{-- Tombol Aksi (Tambahkan logika pembayaran/lacak di sini) --}}
            <div class="mt-6 flex justify-end">
                @if(strtolower($order->status ?? '') === 'belum_bayar')
                    <button class="bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-700 transition shadow-md">
                        Lakukan Pembayaran
                    </button>
                @elseif(strtolower($order->status ?? '') === 'dikirim')
                    <button class="bg-green-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-green-700 transition shadow-md">
                        Lacak Pengiriman
                    </button>
                @endif
            </div>

        </div>
    </div>

    <x-footer />
</div>
@endsection