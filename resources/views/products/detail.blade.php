@extends('layouts.app')

@section('title', $product->nama_barang . ' - Detail Produk')

@section('content')
<div class="min-h-screen bg-gray-50">
    <x-navbar />

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-red-700 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Produk
            </a>
        </div>

        {{-- Bagian Utama --}}
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 flex flex-col md:flex-row gap-8">
            
            {{-- Gambar Produk --}}
            <div class="w-full md:w-1/2 flex justify-center items-center">
                <img src="{{ asset($product->foto_produk ?? 'images/no-image.png') }}" 
                     alt="{{ $product->nama_barang }}" 
                     class="w-full max-w-sm h-auto rounded-lg shadow-md object-cover border">
            </div>

            {{-- Detail Produk --}}
            <div class="w-full md:w-1/2">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->nama_barang }}</h1>
                <p class="text-gray-500 text-sm mb-4">Kode Barang: {{ $product->kode_barang }}</p>
                <p class="text-2xl font-extrabold text-red-700 mb-4">
                    Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                </p>

                {{-- Info Tambahan --}}
                <div class="grid grid-cols-2 gap-2 text-sm text-gray-700 mb-4">
                    <div><span class="font-semibold">Kategori:</span> {{ $product->kategori->nama_kategori ?? 'Umum' }}</div>
                    <div><span class="font-semibold">Stok:</span> {{ $product->stok ?? 0 }}</div>
                    <div><span class="font-semibold">Satuan:</span> {{ $product->satuan ?? '-' }}</div>
                    <div><span class="font-semibold">Tipe Harga:</span> {{ $product->tipe_harga_barang ?? '-' }}</div>
                </div>

                {{-- Deskripsi --}}
                @if($product->keterangan)
                    <p class="text-gray-600 leading-relaxed mb-6">{{ $product->keterangan }}</p>
                @endif

                {{-- Tombol Aksi --}}
                <div class="flex flex-wrap gap-3">
                    {{-- Tambah ke Keranjang --}}
                    <form action="{{ route('cart.add', $product->kode_barang) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                            + Tambah ke Keranjang
                        </button>
                    </form>

                    {{-- Tambah ke Favorit --}}
                    {{-- <form action="{{ route('favorite.toggle', $product->kode_barang) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 font-semibold px-5 py-2 rounded-lg shadow transition">
                            ❤️ Simpan ke Favorit
                        </button>
                    </form> --}}
                </div>
            </div>
        </div>

        {{-- Produk Terkait --}}
        @if($related->count() > 0)
        <section class="mt-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Produk Terkait</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($related as $item)
                    <x-product-card 
                        :name="$item->nama_barang" 
                        :price="number_format($item->harga_jual, 0, ',', '.')" 
                        :image="$item->foto_produk"
                        :product-link="route('product.detail', $item->kode_barang)"
                    />
                @endforeach
            </div>
        </section>
        @endif

    </main>

    <x-footer />
</div>
@endsection
