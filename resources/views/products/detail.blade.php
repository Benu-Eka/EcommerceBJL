@extends('layouts.app')

@section('title', $product->nama_barang . ' - Detail Produk')

@section('content')
<div class="min-h-screen bg-gray-50">
    <x-navbar />

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- 🔙 Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('product') }}"
               class="inline-flex items-center text-gray-600 hover:text-red-700 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Produk
            </a>
        </div>

        {{-- 🧱 Container Utama --}}
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 flex flex-col md:flex-row gap-8">

            {{-- 🖼️ GAMBAR PRODUK --}}
            <div class="w-full md:w-1/2 flex justify-center items-center">
                @php
                    use Illuminate\Support\Str;
                    $image = $product->foto_produk;
                @endphp

                @if($image && Str::startsWith($image, ['http', 'https', 'data:', '/storage', 'storage', 'build']))
                    <img src="{{ Str::startsWith($image, ['storage', 'build']) ? asset($image) : $image }}"
                         alt="{{ $product->nama_barang }}"
                         class="w-full max-w-sm h-auto rounded-lg shadow-md object-contain border">
                @elseif($image)
                    <img src="{{ asset('images/foto_produk/' . basename($image)) }}"
                         alt="{{ $product->nama_barang }}"
                         class="w-full max-w-sm h-auto rounded-lg shadow-md object-contain border">
                @else
                    <img src="https://placehold.co/400x400?text=No+Image"
                         alt="No Image"
                         class="w-full max-w-sm h-auto rounded-lg shadow-md object-contain border">
                @endif
            </div>

            {{-- 📦 DETAIL PRODUK --}}
            <div class="w-full md:w-1/2">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    {{ $product->nama_barang }}
                </h1>

                <p class="text-gray-500 text-sm mb-4">
                    Kode Barang: {{ $product->kode_barang }}
                </p>

                <p class="text-2xl font-extrabold text-green-600 mb-4">
                    Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                </p>

                {{-- ℹ️ Info Singkat --}}
                <div class="grid grid-cols-2 gap-3 text-sm text-gray-700 mb-6 border-b pb-4">
                    <div>
                        <span class="font-semibold">Kategori:</span>
                        {{ $product->kategori->nama_kategori ?? '-' }}
                    </div>
                    <div>
                        <span class="font-semibold">Satuan:</span>
                        {{ $product->satuan_jual ?? '-' }}
                    </div>
                    <div>
                        <span class="font-semibold">Stok Tersedia:</span>
                        {{ $product->stok->jumlah ?? 0 }} Karton
                    </div>
                </div>

                {{-- 📝 DESKRIPSI --}}
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">
                        Deskripsi Produk
                    </h2>

                    @if($product->keterangan)
                        <p class="text-gray-600 leading-relaxed whitespace-pre-wrap">
                            {{ $product->keterangan }}
                        </p>
                    @else
                        <p class="text-gray-400 italic text-sm">
                            Tidak ada deskripsi untuk produk ini.
                        </p>
                    @endif
                </div>

                {{-- 🛒 AKSI --}}
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kode_barang" value="{{ $product->kode_barang }}">

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3
                               rounded-lg shadow transition">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>

        {{-- 🔗 PRODUK TERKAIT --}}
        @if($related->count())
        <section class="mt-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                Produk Terkait
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($related as $item)
                    <x-product-card
                        :kodeBarang="$item->kode_barang"
                        :name="$item->nama_barang"
                        :price="number_format($item->harga_jual, 0, ',', '.')"
                        :image="$item->foto_produk"
                        :productLink="route('product.detail', $item->kode_barang)"
                    />
                @endforeach
            </div>
        </section>
        @endif

    </main>

    <x-footer />
</div>
@endsection
