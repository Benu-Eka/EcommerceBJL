@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white font-inter">
    <x-navbar />

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 pt-4">

        <div class="flex flex-col lg:flex-row gap-4 mb-10">

            <div class="w-full lg:w-2/3 relative h-[280px] md:h-[350px] overflow-hidden rounded-lg shadow-xl" id="main-carousel">

                <div id="slides-container" class="flex transition-transform duration-500 ease-in-out h-full">
                    
                    <div class="w-full flex-shrink-0 bg-gray-100 flex items-end p-6 relative"
                        style="background-image: url('{{ asset('build/assets/images/tabura.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="absolute inset-0 bg-black opacity-40 rounded-lg"></div>
                        <div class="relative z-10 text-white max-w-lg">
                            <span class="text-sm font-semibold mb-1 block">DISKON HINGGA 30%</span>
                            <h2 class="text-3xl md:text-4xl font-extrabold mb-3">Stok Bumbu Bubuk dan Rempah Pilihan</h2>
                            <a href="/product"
                                class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-full transition duration-300">
                                BELANJA SEKARANG →
                            </a>
                        </div>
                    </div>

                    <div class="w-full flex-shrink-0 bg-gray-100 flex items-end p-6 relative"
                        style="background-image: url('{{ asset('build/assets/images/sembako.jpg') }}'); background-size: cover; background-position: center;">
                        <div class="absolute inset-0 bg-indigo-900 opacity-40 rounded-lg"></div>
                        <div class="relative z-10 text-white max-w-lg">
                            <span class="text-sm font-semibold mb-1 block text-yellow-300">STOK AMAN HARGA MURAH</span>
                            <h2 class="text-3xl md:text-4xl font-extrabold mb-3">Kebutuhan Sembako untuk Grosir & Ritel</h2>
                            <a href="/product"
                                class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-semibold py-2 px-6 rounded-full transition duration-300">
                                CEK SEMUA PRODUK →
                            </a>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-20 flex space-x-2" id="carousel-indicators"></div>
            </div>

            <div class="w-full lg:w-1/3 flex flex-col gap-4">
                <div class="bg-yellow-100 flex-1 p-4 flex items-center justify-between rounded-lg shadow-sm h-1/2">
                    <div class="max-w-[60%]">
                        <h4 class="text-xl font-bold text-gray-800 mb-1">Mie Instan Termurah</h4>
                        <p class="text-sm text-gray-600 mb-3">Beli 1 Dus lebih hemat!</p>
                        <a href="/product" class="text-sm text-yellow-700 font-semibold hover:underline">Beli Sekarang →</a>
                    </div>
                    <img src="{{ asset('build/assets/images/mie-instan.jpg') }}"
                        onerror="this.onerror=null;this.src='https://placehold.co/100x100/FFF/333?text=Mie';"
                        class="w-1/3 h-auto object-contain">
                </div>

                <div class="bg-green-100 flex-1 p-4 flex items-center justify-between rounded-lg shadow-sm h-1/2">
                    <div class="max-w-[60%]">
                        <h4 class="text-xl font-bold text-gray-800 mb-1">Promo Khusus Tepung</h4>
                        <p class="text-sm text-gray-600 mb-3">Diskon besar untuk stok bahan baku.</p>
                        <a href="/product" class="text-sm text-green-700 font-semibold hover:underline">Lihat Promo →</a>
                    </div>
                    <img src="{{ asset('build/assets/images/tepung-terigu.jpg') }}"
                        onerror="this.onerror=null;this.src='https://placehold.co/100x100/FFF/333?text=Tepung';"
                        class="w-1/3 h-auto object-contain">
                </div>
            </div>
        </div>

        <section class="mb-12">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl md:text-2xl font-semibold text-gray-800">Kategori Produk</h2>
                <a href="/product" class="text-green-500 hover:text-green-600 font-medium flex items-center">
                    Lihat Semua →
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 xl:grid-cols-10 gap-4 overflow-x-auto pb-4 custom-scrollbar">
                @foreach ($kategoris as $kategori)
                    <a href="#" class="flex flex-col items-center p-3 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 transition duration-300 min-w-[100px] w-full">
                        {{-- Placeholder Logo/Ikon --}}
                        <div class="w-10 h-10 mb-2 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                {{-- Ikon Sederhana (Contoh: Trolley/Keranjang) --}}
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <span class="text-xs text-center font-medium text-gray-700"> {{ $kategori->nama_kategori_barang }} </span>
                    </a>
                @endforeach
            </div>
        </section>

        <hr class="border-gray-200 my-8">

        <section class="mb-12">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl md:text-2xl font-semibold text-gray-800">Produk Terlaris Minggu Ini</h2>
                <a href="/product" class="text-green-500 hover:text-green-600 font-medium flex items-center">
                    Lihat Semua →
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 xl:grid-cols-5 gap-4">
                <x-product-card name="Garam Premium" price="5.000" oldPrice="8.000" discount="Diskon 30%" image="garam.jpg" />
                <x-product-card name="Gula Pasir Kristal 1kg" price="17.000" image="gula-pasir.jpg" />
                <x-product-card name="Minyak Goreng 2L" price="34.900" image="minyak-goreng.png" />
                <x-product-card name="Kecap Manis Botol 600ml" price="23.500" image="kecap-manis.png" />
                <x-product-card name="Tepung Terigu Serbaguna" price="12.500" image="tepung-terigu.jpg" />
            </div>
        </section>

        {{-- BANNER PENAWARAN KHUSUS (Thematic) - RE-STYLED --}}
        {{-- SECTION: KATEGORI STRATEGIS (Terlaris, Terbaru, Stok Hampir Habis) --}}
<section class="mb-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- 1. PRODUK TERLARIS BULAN INI --}}
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 to-blue-900 p-8 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl h-80 flex flex-col justify-between">
            {{-- Background Decor --}}
            <div class="absolute -right-6 -top-6 text-white/10 transition-transform duration-500 group-hover:scale-110 group-hover:rotate-12">
                <i class="fa-solid fa-fire-flame-curved text-9xl"></i>
            </div>

            <div class="relative z-10">
                <span class="inline-block rounded-full bg-blue-500/20 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-blue-300 shadow-sm outline outline-1 outline-blue-400/30">
                    Trending
                </span>
                <h3 class="mt-4 text-3xl font-extrabold leading-tight text-white">Produk Terlaris <br> Bulan Ini</h3>
                <p class="mt-2 text-sm text-slate-300 leading-relaxed">Produk yang paling banyak dibeli dan dipercaya oleh pelanggan setia kami.</p>
            </div>

            <div class="relative z-10">
                <a href="/product?sort=terlaris" class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-bold text-blue-900 transition-colors hover:bg-blue-50">
                    Lihat Koleksi
                    <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>

        {{-- 2. PRODUK TERBARU --}}
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 to-teal-700 p-8 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl h-80 flex flex-col justify-between">
            {{-- Background Decor --}}
            <div class="absolute -right-6 -top-6 text-white/10 transition-transform duration-500 group-hover:scale-110 group-hover:-rotate-12">
                <i class="fa-solid fa-sparkles text-9xl"></i>
            </div>

            <div class="relative z-10">
                <span class="inline-block rounded-full bg-emerald-400/20 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-emerald-200 shadow-sm outline outline-1 outline-emerald-300/30">
                    Fresh Stock
                </span>
                <h3 class="mt-4 text-3xl font-extrabold leading-tight text-white">Koleksi Produk <br> Terbaru</h3>
                <p class="mt-2 text-sm text-emerald-50/80 leading-relaxed">Update stok bumbu dan sembako segar yang baru saja tiba di gudang kami.</p>
            </div>

            <div class="relative z-10">
                <a href="/product?sort=terbaru" class="inline-flex items-center gap-2 rounded-xl bg-emerald-950 px-6 py-3 text-sm font-bold text-white transition-colors hover:bg-emerald-900 border border-emerald-500/50">
                    Cek Produk Baru
                    <i class="fa-solid fa-leaf text-xs transition-transform group-hover:rotate-12"></i>
                </a>
            </div>
        </div>

        {{-- 3. STOK HAMPIR HABIS --}}
        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-700 to-orange-600 p-8 shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl h-80 flex flex-col justify-between">
            {{-- Background Decor --}}
            <div class="absolute -right-6 -top-6 text-white/10 transition-transform duration-500 group-hover:scale-110">
                <i class="fa-solid fa-hourglass-half text-9xl"></i>
            </div>

            <div class="relative z-10">
                <span class="inline-block animate-pulse rounded-full bg-white/20 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-white shadow-sm outline outline-1 outline-white/40">
                    Cepat Kehabisan
                </span>
                <h3 class="mt-4 text-3xl font-extrabold leading-tight text-white">Stok Produk <br> Hampir Habis</h3>
                <p class="mt-2 text-sm text-rose-50 leading-relaxed">Segera amankan pesanan Anda! Item ini sedang dalam permintaan tinggi.</p>
            </div>

            <div class="relative z-10">
                <a href="/product?filter=low_stock" class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-bold text-rose-700 transition-all hover:bg-rose-50 shadow-lg shadow-black/10">
                    Borong Sekarang
                    <i class="fa-solid fa-cart-shopping text-xs"></i>
                </a>
            </div>
        </div>

    </div>
</section>

    </main>

    <x-footer />
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
#slides-container > div {
    height: 100%;
}
#slides-container {
    transition-property: transform;
}
</style>
@endpush