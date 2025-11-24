@extends('layouts.app')

@section('title', $product->nama_barang . ' - Detail Produk')

@section('content')
<div class="min-h-screen bg-gray-50">
    <x-navbar />

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="/product" class="inline-flex items-center text-gray-600 hover:text-red-700 font-medium transition">
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
                <p class="text-2xl font-extrabold text-red-700 mb-4" id="product-price">
                    Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                </p>

                {{--- Pilihan Variasi Produk ---}}
                @if(isset($product->variations) && $product->variations->count() > 0)
                <div class="mb-4">
                    <label for="product_variation" class="block text-sm font-semibold text-gray-700 mb-1">Pilih Variasi:</label>
                    <select id="product_variation" name="variation_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md shadow-sm">
                        <option value="" selected disabled>-- Pilih Jenis Item --</option>
                        @foreach($product->variations as $variation)
                            <option 
                                value="{{ $variation->id }}"
                                data-price="{{ number_format($variation->harga, 0, ',', '.') }}"
                                data-stok="{{ $variation->stok }}"
                                {{ $variation->stok <= 0 ? 'disabled' : '' }}
                            >
                                {{ $variation->nama_variasi }} 
                                (Rp {{ number_format($variation->harga, 0, ',', '.') }})
                                @if($variation->stok <= 0) (Habis) @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                {{--- Info Tambahan ---}}
                <div class="grid grid-cols-2 gap-2 text-sm text-gray-700 mb-6 border-b pb-4">

                    {{-- Stok --}}
                    {{-- @php
                        $stokAkhir = $product->stok->jumlah_stok ?? 0;
                    @endphp
                    <div>
                        <span class="font-semibold">Stok:</span> 
                        <span class="font-bold {{ $stokAkhir > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $stokAkhir }} {{ $product->satuan_terkecil }}
                        </span>
                    </div> --}}
                    
                     {{-- Jumlah barang per karton --}}
                    <div>
                        <span class="font-semibold">Stok :</span> 
                        {{ $product->jml_barang_per_karton ?? 0 }} {{ $product->satuan_terkecil }}
                    </div>

                    {{-- Satuan dari DB: satuan_terkecil --}}
                    <div>
                        <span class="font-semibold">Satuan Jual:</span> 
                        {{ $product->satuan_jual ?? '-' }}
                    </div>

                    {{-- Kategori dari FK kategori_barang --}}
                    <div>
                        <span class="font-semibold">Kategori Barang:</span> 
                        {{ $product->kategori->nama_kategori ?? 'Tidak ada' }}
                    </div>

                    {{-- Tipe Harga (tipe_harga_barang) --}}
                    <div>
                        <span class="font-semibold">Tipe Harga Barang:</span> 
                        {{ strtoupper($product->tipe_harga_barang) }}
                    </div>



                </div>

                {{-- Deskripsi Produk --}}
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Deskripsi Produk</h2>
                    @if($product->keterangan)
                        <p class="text-gray-600 leading-relaxed whitespace-pre-wrap">
                            {{ $product->keterangan }}
                        </p>
                    @else
                        <p class="text-gray-500 italic text-sm">Tidak ada deskripsi tersedia untuk produk ini.</p>
                    @endif
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-wrap gap-3">
                    {{-- Tambah ke Keranjang --}}
            <form action="{{ route('cart.add') }}" method="POST" class="mt-2" onClick="event.stopPropagation();">
                @csrf
                <input type="hidden" name="kode_barang" value="{{ $product->kode_barang }}">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Tambah ke Keranjang
                </button>
            </form>
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

    {{-- Script JavaScript untuk menangani pilihan variasi --}}
    @if(isset($product->variations) && $product->variations->count() > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.getElementById('product_variation');
            const priceElement = document.getElementById('product-price');
            const stockStatusElement = document.getElementById('stock-status');
            const variationIdInput = document.getElementById('selected_variation_id');
            const addToCartBtn = document.getElementById('add-to-cart-btn');

            // Simpan harga & status stok default (tanpa variasi)
            const defaultPrice = priceElement.textContent;
            const defaultStockText = stockStatusElement.textContent;
            const defaultStockClass = stockStatusElement.className;

            // Pastikan tombol nonaktif jika ada variasi yang harus dipilih
            addToCartBtn.disabled = true;
            addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');

            // Fungsi untuk mengupdate UI berdasarkan variasi yang dipilih
            function updateProductDetails(selectedOption) {
                if (selectedOption && selectedOption.value) {
                    const price = selectedOption.getAttribute('data-price');
                    const stock = parseInt(selectedOption.getAttribute('data-stok'));
                    const variationId = selectedOption.value;

                    // 1. Update Harga
                    priceElement.textContent = `Rp ${price}`;

                    // 2. Update Status Stok
                    stockStatusElement.textContent = stock > 0 ? 'Tersedia' : 'Habis';
                    stockStatusElement.className = stock > 0 ? 'font-bold text-green-600' : 'font-bold text-red-600';

                    // 3. Update Input tersembunyi dan Tombol Keranjang
                    variationIdInput.value = variationId;

                    if (stock > 0) {
                        addToCartBtn.disabled = false;
                        addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        addToCartBtn.disabled = true;
                        addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                } else {
                    // Reset ke kondisi default/belum dipilih
                    priceElement.textContent = defaultPrice;
                    stockStatusElement.textContent = defaultStockText;
                    stockStatusElement.className = defaultStockClass;
                    variationIdInput.value = '';
                    addToCartBtn.disabled = true;
                    addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            selectElement.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                updateProductDetails(selectedOption);
            });
        });
    </script>
    @endif
</div>
@endsection