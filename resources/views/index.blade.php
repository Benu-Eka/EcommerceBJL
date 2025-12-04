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
        <section class="mb-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Banner 1: Flash Sale (Dominan Dark Blue) --}}
                <div class="bg-blue-900 text-white p-8 rounded-xl shadow-lg relative overflow-hidden h-72 transform hover:scale-[1.02] transition duration-300">
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div>
                            <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block shadow-md">FLASH SALE</span>
                            <h3 class="text-3xl font-extrabold mb-3 leading-tight">Penjualan Terbaik Akhir Bulan!</h3>
                            <div class="flex space-x-3 text-center text-sm font-semibold">
                                <div class="bg-blue-800 p-2 rounded-lg min-w-[50px]"><span>00</span><div class="text-xs font-normal mt-1 text-gray-300">Hari</div></div>
                                <div class="bg-blue-800 p-2 rounded-lg min-w-[50px]"><span>02</span><div class="text-xs font-normal mt-1 text-gray-300">Jam</div></div>
                                <div class="bg-blue-800 p-2 rounded-lg min-w-[50px]"><span>18</span><div class="text-xs font-normal mt-1 text-gray-300">Menit</div></div>
                                <div class="bg-blue-800 p-2 rounded-lg min-w-[50px]"><span>46</span><div class="text-xs font-normal mt-1 text-gray-300">Detik</div></div>
                            </div>
                        </div>
                        <a href="/product" class="bg-white text-blue-900 font-bold py-2.5 px-6 rounded-full w-fit hover:bg-gray-100 transition duration-300 shadow-xl">
                            Belanja Sekarang →
                        </a>
                    </div>
                </div>

                {{-- Banner 2: Bahan Baku (High Contrast Black & Yellow) --}}
                <div class="bg-gray-900 text-white p-8 rounded-xl shadow-lg relative overflow-hidden h-72 transform hover:scale-[1.02] transition duration-300">
                    <div class="absolute inset-0 z-0 bg-opacity-30" style="background-image: url('{{ asset('images/bahan-baku-promo.jpg') }}'); background-size: cover; background-position: center; filter: grayscale(100%);"></div>
                    <div class="relative z-10 flex flex-col justify-end h-full">
                        <span class="bg-yellow-400 text-gray-900 text-xs font-bold px-3 py-1 rounded-full w-fit mb-3 shadow-md">HARGA DISTRIBUTOR</span>
                        <h3 class="text-3xl font-extrabold mb-1 leading-tight">Stok Bahan Baku Massal</h3>
                        <p class="text-lg mb-4 text-gray-300">Mulai dari <span class="text-yellow-400 font-extrabold">Rp 12.000/kg</span></p>
                        <a href="/product" class="bg-white text-black font-bold py-2.5 px-6 rounded-full w-fit hover:bg-gray-100 transition duration-300 shadow-xl">
                            Cek Stok →
                        </a>
                    </div>
                </div>

                {{-- Banner 3: Bumbu Bubuk (Dominan Red & Image Focus) --}}
                <div class="bg-red-700 text-white p-8 rounded-xl shadow-lg relative overflow-hidden h-72 transform hover:scale-[1.02] transition duration-300">
                    <div class="absolute right-0 bottom-0 z-0 w-full h-full opacity-60" 
                         style="background-image: url('{{ asset('images/rempah-promo.png') }}'); background-size: 70%; background-repeat: no-repeat; background-position: 120% bottom;">
                    </div>
                    <div class="relative z-10 flex flex-col justify-between h-full">
                        <div>
                            <span class="bg-white text-red-700 text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block shadow-md">GROSIR BUMBU</span>
                            <h3 class="text-3xl font-extrabold mb-1 leading-tight">Promo Stok Bumbu Bubuk</h3>
                            <p class="text-lg text-gray-200">Diskon hingga <span class="text-yellow-300 font-extrabold">44%</span></p>
                        </div>
                        <a href="/product" class="bg-white text-red-700 font-bold py-2.5 px-6 rounded-full w-fit hover:bg-gray-100 transition duration-300 shadow-xl">
                            Beli Sekarang →
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