@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-white font-inter">
        <x-navbar />

        <main class="container mx-auto px-4 sm:px-6 lg:px-8 pt-4">

            <div class="flex flex-col lg:flex-row gap-4 mb-10">

                <div class="w-full lg:w-2/3 relative h-[280px] md:h-[350px] overflow-hidden rounded-lg shadow-xl"
                    id="main-carousel">

                    <div id="slides-container" class="flex transition-transform duration-500 ease-in-out h-full">

                        <div class="w-full flex-shrink-0 bg-gray-100 flex items-end p-6 relative"
                            style="background-image: url('{{ asset('build/assets/images/tabura-logo.jpg') }}'); background-size: cover; background-position: center;">
                            <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-black/60 rounded-lg"></div>
                            <div class="relative z-10 text-white max-w-lg space-y-3">
                                <span
                                    class="inline-block text-sm font-semibold bg-white/10 px-2 py-1 rounded text-white/90">
                                    DISKON SPESIAL HARI INI
                                </span>
                                <h2 class="text-3xl md:text-4xl font-extrabold mb-0">
                                    Bumbu Bubuk & Rempah Berkualitas Pilihan
                                </h2>
                                <p class="text-sm text-white/80">
                                    Lengkapi kebutuhan dapur dan usaha Anda dengan produk terbaik dari kami.
                                </p>
                                <a href="/product"
                                    class="inline-flex items-center gap-2 bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-6 rounded-full shadow-md transition transform hover:-translate-y-0.5">
                                    BELANJA SEKARANG →
                                </a>

                            </div>
                        </div>

                        <div class="w-full flex-shrink-0 bg-gray-100 flex items-end p-6 relative"
                            style="background-image: url('{{ asset('build/assets/images/tim.png') }}'); background-size: cover; background-position: center;">
                            <div class="absolute inset-0 bg-gradient-to-b from-indigo-900/20 to-indigo-900/60 rounded-lg">
                            </div>
                            <div class="relative z-10 text-white max-w-lg space-y-3">
                                <span
                                    class="inline-block text-sm font-semibold bg-white/10 px-2 py-1 rounded text-yellow-300">
                                    DISTRIBUSI CEPAT & TERPERCAYA
                                </span>
                                <h2 class="text-3xl md:text-4xl font-extrabold mb-0">
                                    Tim Profesional Siap Melayani Kebutuhan Anda
                                </h2>
                                <p class="text-sm text-white/80">
                                    Didukung tim berpengalaman untuk memastikan pesanan sampai tepat waktu.
                                </p>
                                <a href="/product"
                                    class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-semibold py-2 px-6 rounded-full shadow transition transform hover:-translate-y-0.5">
                                    LIHAT PRODUK →
                                </a>
                            </div>
                        </div>

                        <div class="w-full flex-shrink-0 bg-gray-100 flex items-end p-6 relative"
                            style="background-image: url('{{ asset('build/assets/images/cs.png') }}'); background-size: 80% ; background-position:  center;">
                            <div class="absolute inset-0 bg-gradient-to-b from-indigo-900/20 to-indigo-900/60 rounded-lg">
                            </div>
                            <div class="relative z-10 text-white max-w-lg space-y-3">
                                <span
                                    class="inline-block text-sm font-semibold bg-white/10 px-2 py-1 rounded text-yellow-300">
                                    PELAYANAN TERBAIK UNTUK ANDA
                                </span>
                                <h2 class="text-3xl md:text-4xl font-extrabold mb-0">
                                    Layanan Cepat, Ramah, dan Responsif
                                </h2>
                                <p class="text-sm text-white/80">
                                    Tim customer service kami siap membantu setiap kebutuhan dan pertanyaan Anda.
                                </p>
                                <a href="/product"
                                    class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-semibold py-2 px-6 rounded-full shadow transition transform hover:-translate-y-0.5">
                                    HUBUNGI KAMI →
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-20 flex space-x-2"
                        id="carousel-indicators"></div>
                </div>

                <div class="w-full lg:w-1/3 flex flex-col gap-4">
                    <div
                        class="bg-white flex-1 p-4 flex items-center justify-between rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1 h-1/2 border-l-6 border-yellow-400">
                        <div class="max-w-[60%]">
                            <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-1">Mie Instan Termurah</h4>
                            <p class="text-sm text-gray-600 mb-3">Beli 1 Dus lebih hemat!</p>
                            <a href="/product" class="text-sm text-yellow-700 font-semibold hover:underline">Beli Sekarang
                                →</a>
                        </div>
                        <img src="{{ asset('build/assets/images/mie-instan.jpg') }}"
                            onerror="this.onerror=null;this.src='https://placehold.co/120x120/FFF/333?text=Mie';"
                            class="w-28 h-28 object-cover rounded-md">
                    </div>

                    <div
                        class="bg-white flex-1 p-4 flex items-center justify-between rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1 h-1/2 border-l-6 border-emerald-400">
                        <div class="max-w-[60%]">
                            <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-1">Promo Khusus Tepung</h4>
                            <p class="text-sm text-gray-600 mb-3">Diskon besar untuk stok bahan baku.</p>
                            <a href="/product" class="text-sm text-emerald-700 font-semibold hover:underline">Lihat Promo
                                →</a>
                        </div>
                        <img src="{{ asset('build/assets/images/tepung.jpg') }}"
                            onerror="this.onerror=null;this.src='https://placehold.co/120x120/FFF/333?text=Tepung';"
                            class="w-28 h-28 object-cover rounded-md">
                    </div>
                </div>
            </div>

            <section class="mb-10">
                <div class="flex justify-between items-center mb-5">
                    <div>
                        <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                            Kategori Produk
                        </h2>
                        <div class="w-12 h-1 bg-red-600 rounded mt-1"></div>
                    </div>

                    <a href="/product" class="text-sm text-green-600 hover:text-green-700 font-medium">
                        Lihat Semua →
                    </a>
                </div>

                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">

                    @foreach ($kategoris as $kategori)
                        <a href="{{ route('product', ['kategori' => $kategori->id]) }}"
                            class="flex flex-col items-center p-3 bg-white rounded-lg border border-gray-100 hover:shadow-md hover:-translate-y-1 transition duration-200">
                            <!-- ICON -->
                            <div class="w-12 h-12 flex items-center justify-center rounded-full mb-2 text-xl bg-red-50">
                                @php
                                    $nama = strtolower($kategori->nama_kategori_barang);
                                @endphp

                                @if(str_contains($nama, 'mie'))
                                    🍜
                                @elseif(str_contains($nama, 'minum'))
                                    🥤
                                @elseif(str_contains($nama, 'bumbu') || str_contains($nama, 'rempah'))
                                    🌶️
                                @elseif(str_contains($nama, 'tepung'))
                                    🌾
                                @elseif(str_contains($nama, 'gula'))
                                    🍬
                                @elseif(str_contains($nama, 'beras'))
                                    🍚
                                @else
                                    🛒
                                @endif
                            </div>

                            <!-- TEXT -->
                            <span class="text-xs text-center font-medium text-gray-700 leading-tight">
                                {{ $kategori->nama_kategori_barang }}
                            </span>

                        </a>
                    @endforeach

                </div>
            </section>

            <hr class="border-gray-200 my-6">

            {{-- REKOMENDASI UNTUK ANDA --}}
            @if($recommendations->isNotEmpty())
                <section class="mb-12">

                    <!-- HEADER -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-gray-900 flex items-center gap-2">
                                @auth('pelanggan')
                                    <span class="flex items-center gap-2 text-red-600">
                                        <i class="fa-solid fa-sparkles text-sm"></i>
                                        Rekomendasi Untuk Anda
                                    </span>
                                @else
                                    <span class="flex items-center gap-2 text-red-600">
                                        <i class="fa-solid fa-star text-sm"></i>
                                        Pilihan Terbaik Kami
                                    </span>
                                @endauth
                            </h2>
                            <div class="w-12 h-[3px] bg-gradient-to-r from-red-600 to-red-400 rounded-full mt-2"></div>
                        </div>

                        <!-- OPTIONAL BUTTON -->
                        <a href="/product"
                            class="text-sm font-medium text-gray-500 hover:text-red-600 transition flex items-center gap-1">
                            Lihat Semua
                            <span class="transition group-hover:translate-x-1">→</span>
                        </a>
                    </div>

                    <!-- PRODUCT GRID -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-5">

                        @foreach ($recommendations as $product)
                            <div
                                class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">

                                <!-- PRODUCT CARD COMPONENT -->
                                <x-product-card :kodeBarang="$product->kode_barang" :name="$product->nama_barang"
                                    :price="number_format($product->harga_jual, 0, ',', '.')" :oldPrice="$product->harga_beli
                            ? number_format($product->harga_beli, 0, ',', '.')
                            : null" :discount="$product->diskon
                            ? 'Diskon ' . $product->diskon . '%'
                            : null" :image="$product->foto_produk"
                                    :productLink="route('product.detail', $product->kode_barang)" :totalTerjual="null" />

                            </div>
                        @endforeach

                    </div>
                </section>

                <hr class="border-gray-200 my-10">
            @endif
            <!-- 
                                                                                                    <section class="mb-12">
                                                                                                        <div class="flex justify-between items-center mb-4">
                                                                                                            <div>
                                                                                                                <h2 class="text-xl md:text-2xl font-semibold text-gray-800">Produk Terlaris Minggu Ini</h2>
                                                                                                                <span class="block mt-2 h-1 w-16 bg-red-700 rounded"></span>
                                                                                                            </div>
                                                                                                            <a href="/product" class="text-green-500 hover:text-green-600 font-medium flex items-center">
                                                                                                                Lihat Semua →
                                                                                                            </a>
                                                                                                        </div>
                                                                                                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 xl:grid-cols-5 gap-4">
                                                                                                            <div class="group transform transition hover:-translate-y-2">
                                                                                                                <x-product-card name="Garam Premium" price="5.000" oldPrice="8.000" discount="Diskon 30%" image="garam.jpg" />
                                                                                                            </div>
                                                                                                            <div class="group transform transition hover:-translate-y-2">
                                                                                                                <x-product-card name="Gula Pasir Kristal 1kg" price="17.000" image="gula-pasir.jpg" />
                                                                                                            </div>
                                                                                                            <div class="group transform transition hover:-translate-y-2">
                                                                                                                <x-product-card name="Minyak Goreng 2L" price="34.900" image="minyak-goreng.png" />
                                                                                                            </div>
                                                                                                            <div class="group transform transition hover:-translate-y-2">
                                                                                                                <x-product-card name="Kecap Manis Botol 600ml" price="23.500" image="kecap-manis.png" />
                                                                                                            </div>
                                                                                                            <div class="group transform transition hover:-translate-y-2">
                                                                                                                <x-product-card name="Tepung Terigu Serbaguna" price="12.500" image="tepung-terigu.jpg" />
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </section> -->
            <section class="mb-12">

                <!-- HEADER -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900">
                            Produk Terlaris Minggu Ini
                        </h2>
                        <div class="w-12 h-[3px] bg-gradient-to-r from-red-600 to-red-400 rounded-full mt-2"></div>
                    </div>

                    <a href="{{ route('product', ['sort' => 'terlaris']) }}"
                        class="text-sm text-gray-500 hover:text-red-600 font-medium transition">
                        Lihat Semua →
                    </a>
                </div>

                <!-- GRID PRODUK (MAX 2 BARIS) -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-5">

                    @forelse ($products->take(10) as $product)
                            <div
                                class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">

                                <!-- BADGE TERLARIS -->
                                <div class="absolute z-10 m-2">
                                    <span class="bg-red-600 text-white text-[10px] px-2 py-1 rounded-full shadow">
                                        Terlaris
                                    </span>
                                </div>

                                <!-- PRODUCT CARD -->
                                <x-product-card :kodeBarang="$product->kode_barang" :name="$product->nama_barang"
                                    :price="number_format($product->harga_jual, 0, ',', '.')" :oldPrice="$product->harga_beli
                        ? number_format($product->harga_beli, 0, ',', '.')
                        : null" :discount="$product->diskon
                        ? 'Diskon ' . $product->diskon . '%'
                        : null" :image="$product->foto_produk"
                                    :productLink="route('product.detail', $product->kode_barang)"
                                    :totalTerjual="$product->total_terjual" />

                            </div>
                    @empty
                        <p class="text-gray-500 col-span-full text-center py-10">
                            Produk terlaris belum tersedia.
                        </p>
                    @endforelse

                </div>

            </section>

            {{-- BANNER PENAWARAN KHUSUS (Thematic) - RE-STYLED --}}
            {{-- SECTION: KATEGORI STRATEGIS (Terlaris, Terbaru, Stok Hampir Habis) --}}
            <section class="mb-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- 1. TERLARIS -->
                    <div
                        class="group bg-gradient-to-br from-red-50 to-white border border-red-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">

                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl bg-red-100 text-red-600 text-xl shadow-sm">
                                🔥
                            </div>
                            <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-1 rounded-full">
                                Trending
                            </span>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Produk Terlaris
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Produk paling diminati dan banyak dibeli pelanggan.
                            </p>
                        </div>

                        <a href="/product?sort=terlaris"
                            class="mt-5 inline-flex items-center justify-between text-sm font-semibold text-red-600 hover:text-red-700 transition">
                            Lihat Produk
                            <span class="group-hover:translate-x-1 transition">→</span>
                        </a>
                    </div>


                    <!-- 2. TERBARU -->
                    <div
                        class="group bg-gradient-to-br from-red-50 via-white to-red-50 border border-red-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">

                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl bg-red-100 text-red-600 text-xl shadow-sm">
                                ✨
                            </div>
                            <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-1 rounded-full">
                                Baru
                            </span>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Produk Terbaru
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Stok terbaru dengan kualitas terbaik langsung dari gudang.
                            </p>
                        </div>

                        <a href="/product?sort=terbaru"
                            class="mt-5 inline-flex items-center justify-between text-sm font-semibold text-red-600 hover:text-red-700 transition">
                            Cek Sekarang
                            <span class="group-hover:translate-x-1 transition">→</span>
                        </a>
                    </div>


                    <!-- 3. STOK MENIPIS -->
                    <div
                        class="group bg-gradient-to-br from-rose-50 to-red-50 border border-rose-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">

                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl bg-rose-100 text-red-600 text-xl shadow-sm">
                                ⏳
                            </div>
                            <span
                                class="text-xs font-semibold text-red-600 bg-rose-100 px-2 py-1 rounded-full animate-pulse">
                                Hampir Habis
                            </span>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Stok Menipis
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Segera pesan sebelum kehabisan stok.
                            </p>
                        </div>

                        <a href="/product?filter=low_stock"
                            class="mt-5 inline-flex items-center justify-between text-sm font-semibold text-red-600 hover:text-red-700 transition">
                            Borong Sekarang
                            <span class="group-hover:translate-x-1 transition">→</span>
                        </a>
                    </div>

                </div>
            </section>

        </main>

        <x-footer />
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const slidesContainer = document.getElementById('slides-container');
            const indicatorsContainer = document.getElementById('carousel-indicators');
            const slides = slidesContainer.children;
            const totalSlides = slides.length;
            let currentSlide = 0;
            let slideInterval;

            for (let i = 0; i < totalSlides; i++) {
                const indicator = document.createElement('button');
                // Indikator default
                indicator.classList.add('w-2.5', 'h-2.5', 'rounded-full', 'bg-white', 'bg-opacity-50', 'hover:bg-opacity-100', 'transition', 'duration-300');
                if (i === 0) {
                    // Indikator aktif (pill shape)
                    indicator.classList.add('!bg-opacity-100', 'w-6');
                }
                indicator.dataset.index = i;
                indicator.addEventListener('click', () => {
                    goToSlide(i);
                    resetInterval();
                });
                indicatorsContainer.appendChild(indicator);
            }

            const indicators = indicatorsContainer.children;

            function goToSlide(index) {
                currentSlide = index;
                const offset = -index * 100;
                slidesContainer.style.transform = `translateX(${offset}%)`;
                updateIndicators();
            }

            function updateIndicators() {
                Array.from(indicators).forEach((indicator, i) => {
                    // Reset
                    indicator.classList.remove('!bg-opacity-100', 'w-6');
                    indicator.classList.add('bg-opacity-50', 'w-2.5');

                    // Activate
                    if (i === currentSlide) {
                        indicator.classList.add('!bg-opacity-100', 'w-6');
                    }
                });
            }

            function startInterval() {
                slideInterval = setInterval(() => {
                    currentSlide = (currentSlide + 1) % totalSlides;
                    goToSlide(currentSlide);
                }, 5000);
            }

            function resetInterval() {
                clearInterval(slideInterval);
                startInterval();
            }

            startInterval();
        });
    </script>
@endsection

@push('styles')
    <style>
        .custom-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .custom-scrollbar::-webkit-scrollbar {
            display: none;
        }

        #slides-container>div {
            height: 100%;
        }

        #slides-container {
            transition-property: transform;
        }
    </style>
@endpush