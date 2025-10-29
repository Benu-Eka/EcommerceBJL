@extends('layouts.app')

@section('title', 'Barang Favorit')

@section('content')
<x-navbar/>
<div class="min-h-screen bg-gray-50 py-10 px-4">
        {{-- Header halaman dengan tombol back --}}
         <div class="mb-2 ml-20 ">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center text-gray-600 hover:text-red-700 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-3">Produk Favorit</h1>
        </div>

    <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow p-6">

        @php
            $favorit = [
                [
                    'id' => 1,
                    'nama' => 'Beras Pandan Wangi 5 Kg',
                    'kategori' => 'Sembako',
                    'harga' => 68000,
                    'stok' => 'Tersedia',
                    'gambar' => 'https://source.unsplash.com/100x100/?rice',
                ],
                [
                    'id' => 2,
                    'nama' => 'Gula Pasir Putih 1 Kg',
                    'kategori' => 'Sembako',
                    'harga' => 14500,
                    'stok' => 'Tersedia',
                    'gambar' => 'https://source.unsplash.com/100x100/?sugar',
                ],
                [
                    'id' => 3,
                    'nama' => 'Cabai Merah Kering 250 gr',
                    'kategori' => 'Bumbu Dapur',
                    'harga' => 25000,
                    'stok' => 'Stok Terbatas',
                    'gambar' => 'https://source.unsplash.com/100x100/?chili',
                ],
                [
                    'id' => 4,
                    'nama' => 'Minyak Goreng Sawit 1 Liter',
                    'kategori' => 'Sembako',
                    'harga' => 18000,
                    'stok' => 'Tersedia',
                    'gambar' => 'https://source.unsplash.com/100x100/?cooking-oil',
                ],
            ];
        @endphp

        {{-- Daftar Barang Favorit --}}
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach ($favorit as $item)
                <div class="border rounded-xl p-3 hover:shadow-lg transition bg-gray-50 relative">
                    {{-- Tombol hapus favorit --}}
                    <button class="absolute top-2 right-2 text-gray-400 hover:text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 3.172a4 4 0 015.656 0L10 4.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    {{-- Gambar Produk --}}
                    <img src="{{ $item['gambar'] }}" alt="{{ $item['nama'] }}" 
                         class="w-full h-28 object-cover rounded-lg mb-3">

                    {{-- Nama & kategori --}}
                    <div>
                        <p class="font-semibold text-gray-800 hover:text-green-600 transition text-sm leading-tight">
                            {{ $item['nama'] }}
                        </p>
                        <p class="text-xs text-gray-500">{{ $item['kategori'] }}</p>
                        <p class="text-xs mt-1 {{ $item['stok'] == 'Tersedia' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ $item['stok'] }}
                        </p>
                    </div>

                    {{-- Harga & Tombol --}}
                    <div class="mt-3 flex justify-between items-center">
                        <span class="font-semibold text-gray-800 text-sm">
                            Rp. {{ number_format($item['harga'], 0, ',', '.') }}
                        </span>
                        <button
                            class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1.5 rounded-md transition">
                            + Keranjang
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Jika kosong --}}
        @if (empty($favorit))
            <div class="text-center py-20 text-gray-500">
                <p>Belum ada barang yang difavoritkan</p>
                <a href="{{ route('produk.index') }}" class="text-green-600 hover:underline">
                    Lihat Produk
                </a>
            </div>
        @endif
    </div>
</div>
<x-footer/>
@endsection
