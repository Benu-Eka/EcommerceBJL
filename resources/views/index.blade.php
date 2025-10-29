@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white font-inter">
    <x-navbar />

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 pt-4">

        <!-- SLIDER UTAMA DAN IKLAN SAMPING -->
        <div class="flex flex-col lg:flex-row gap-4 mb-10">

            <!-- Banner Kiri (Carousel Slider) -->
            <div class="w-full lg:w-2/3 relative h-[280px] md:h-[350px] overflow-hidden rounded-lg shadow-xl" id="main-carousel">

                <!-- Slide Container -->
                <div id="slides-container" class="flex transition-transform duration-500 ease-in-out h-full">
                    <!-- SLIDE 1 -->
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

                    <!-- SLIDE 2 -->
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

                <!-- Indikator Navigasi -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-20 flex space-x-2" id="carousel-indicators"></div>
            </div>

            <!-- Iklan Samping -->
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

        <!-- KATEGORI TERPOPULER -->
        <section class="mb-12">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl md:text-2xl font-semibold text-gray-800">Kategori Terpopuler</h2>
                <a href="/product" class="text-green-500 hover:text-green-600 font-medium flex items-center">
                    Lihat Semua →
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 xl:grid-cols-10 gap-4 overflow-x-auto pb-4 custom-scrollbar">
                @foreach ($kategoris as $kategori)
                    <a href="#" class="flex flex-col items-center p-3 rounded-lg border transition duration-300 min-w-[100px] w-full">

                        <span class="text-xs text-center font-medium"> {{ $kategori->nama_kategori_barang }} </span>
                    </a>
                @endforeach
            </div>
        </section>

        <hr class="border-gray-200 my-8">

        <!-- PRODUK TERLARIS -->
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
            </div><br>
            <br>

             {{-- BANNER PENAWARAN KHUSUS (Thematic) --}}
            <section class="mb-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                  <div class="bg-blue-900 text-white p-6 rounded-lg shadow-md relative overflow-hidden h-72">
                        <div class="absolute inset-0 z-0" style="background-image: url('{{ asset('images/sembako-bg-dark.jpg') }}'); background-size: cover; background-position: center; opacity: 0.3;"></div>
                        <div class="relative z-10 flex flex-col justify-between h-full">
                            <div>
                                <span class="bg-white text-blue-900 text-xs font-bold px-2 py-1 rounded-full mb-2 inline-block">PENJUALAN TERBAIK</span>
                                <h3 class="text-3xl font-bold mb-2">Flash Sale Akhir Bulan</h3>
                                <div class="flex space-x-2 text-center text-sm font-semibold" id="countdown-timer">

                                    <div class="bg-blue-800 p-2 rounded-lg"><span>00</span><div class="text-xs font-normal mt-1">Hari</div></div>
                                    <div class="bg-blue-800 p-2 rounded-lg"><span>02</span><div class="text-xs font-normal mt-1">Jam</div></div>
                                    <div class="bg-blue-800 p-2 rounded-lg"><span>18</span><div class="text-xs font-normal mt-1">Menit</div></div>
                                    <div class="bg-blue-800 p-2 rounded-lg"><span>46</span><div class="text-xs font-normal mt-1">Detik</div></div>
                                </div>
                            </div>
                            <a href="/product" class="bg-white text-blue-900 font-semibold py-2 px-4 rounded-full w-fit hover:bg-gray-100 transition duration-300">
                                Belanja Sekarang →
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-900 text-white p-6 rounded-lg shadow-md relative overflow-hidden h-72">
                        <div class="absolute inset-0 z-0" style="background-image: url('{{ asset('images/bahan-baku-promo.jpg') }}'); background-size: cover; background-position: center; opacity: 0.3;"></div>
                        <div class="relative z-10 flex flex-col justify-end h-full">
                            <span class="bg-yellow-400 text-gray-900 text-xs font-bold px-2 py-1 rounded-full w-fit mb-2">HARGA DISTRIBUTOR</span>
                            <h3 class="text-3xl font-bold mb-1">Stok Bahan Baku Massal</h3>
                            <p class="text-sm mb-4">Mulai dari <span class="text-yellow-400 font-bold">Rp 12.000/kg</span></p>
                            <a href="/product" class="bg-white text-black font-semibold py-2 px-4 rounded-full w-fit hover:bg-gray-100 transition duration-300">
                                Cek Stok →
                            </a>
                        </div>
                    </div>

                    <div class="bg-red-700 text-white p-6 rounded-lg shadow-md relative overflow-hidden h-72">
                        <div class="absolute right-0 bottom-0 z-0 w-3/4 h-3/4" style="background-image: url('{{ asset('images/rempah-promo.png') }}'); background-size: contain; background-repeat: no-repeat; background-position: right bottom;"></div>
                        <div class="relative z-10 flex flex-col justify-between h-full">
                            <div>
                                <span class="bg-white text-red-700 text-xs font-bold px-2 py-1 rounded-full mb-2 inline-block">GROSIR BUMBU</span>
                                <h3 class="text-3xl font-bold mb-1">Promo Stok Bumbu Bubuk</h3>
                                <p class="text-sm">Diskon hingga <span class="text-yellow-300 font-bold">44%</span></p>
                            </div>
                            <a href="/product" class="bg-white text-red-700 font-semibold py-2 px-4 rounded-full w-fit hover:bg-gray-100 transition duration-300">
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
        indicator.classList.add('w-2.5', 'h-2.5', 'rounded-full', 'bg-white', 'bg-opacity-50', 'hover:bg-opacity-100', 'transition', 'duration-300');
        if (i === 0) {
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
            indicator.classList.remove('!bg-opacity-100', 'w-6');
            indicator.classList.add('bg-opacity-50', 'w-2.5');
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
