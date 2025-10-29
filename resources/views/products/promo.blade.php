@extends('layouts.app')

@section('title', 'Penawaran Promo Spesial')

@section('content')
<div class="min-h-screen bg-white">
    <x-navbar />

    <section class="bg-yellow-50 py-10 px-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Penawaran Voucher Spesial</h2>
        <p class="text-gray-600 mb-8">Gunakan voucher berikut untuk mendapatkan potongan tambahan di checkout!</p>

        <div class="flex flex-wrap justify-center gap-6">
            <div class="bg-white border-2 border-yellow-400 rounded-lg px-6 py-5 shadow hover:shadow-xl hover:-translate-y-1 transform transition duration-300 w-64">
                <p class="font-bold text-yellow-600 text-xl mb-1">HEMAT20</p>
                <p class="text-gray-600 text-sm mb-4">Diskon 20% untuk pembelian min. Rp 50.000</p>
                <button onclick="claimVoucher('HEMAT20')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded-lg transition duration-300">Klaim Voucher</button>
            </div>

            <div class="bg-white border-2 border-green-400 rounded-lg px-6 py-5 shadow hover:shadow-xl hover:-translate-y-1 transform transition duration-300 w-64">
                <p class="font-bold text-green-600 text-xl mb-1">ONGKIRFREE</p>
                <p class="text-gray-600 text-sm mb-4">Gratis ongkir hingga Rp 10.000</p>
                <button onclick="claimVoucher('ONGKIRFREE')" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-lg transition duration-300">Klaim Voucher</button>
            </div>

            <div class="bg-white border-2 border-red-400 rounded-lg px-6 py-5 shadow hover:shadow-xl hover:-translate-y-1 transform transition duration-300 w-64">
                <p class="font-bold text-red-600 text-xl mb-1">FLASH30</p>
                <p class="text-gray-600 text-sm mb-4">Diskon 30% produk Flash Sale</p>
                <button onclick="claimVoucher('FLASH30')" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-lg transition duration-300">Klaim Voucher</button>
            </div>
        </div>
    </section>

     <section class="relative bg-gradient-to-b from-red-600 to-orange-500 text-white py-12 px-6 text-center overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[url('/images/pattern.svg')] bg-cover bg-center"></div>
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-3">FLASH SALE TERBATAS</h1>
            <p class="text-lg md:text-xl mb-6">Dapatkan harga super murah sebelum waktu habis!</p>
            <div class="flex justify-center space-x-4">
                <div class="bg-white text-red-600 rounded-lg px-4 py-2 shadow">
                    <span id="days" class="font-bold text-2xl">00</span> Hari
                </div>
                <div class="bg-white text-red-600 rounded-lg px-4 py-2 shadow">
                    <span id="hours" class="font-bold text-2xl">00</span> Jam
                </div>
                <div class="bg-white text-red-600 rounded-lg px-4 py-2 shadow">
                    <span id="minutes" class="font-bold text-2xl">00</span> Menit
                </div>
                <div class="bg-white text-red-600 rounded-lg px-4 py-2 shadow">
                    <span id="seconds" class="font-bold text-2xl">00</span> Detik
                </div>
            </div>
        </div>
    </section>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Produk Flash Sale Hari Ini</h2>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @php
                $flashsales = [
                    ['name' => 'Minyak Goreng 2L', 'price' => 34900, 'discount' => 40, 'image' => 'minyak-goreng.png', 'stock' => 15],
                    ['name' => 'Kopi Bubuk 250gr', 'price' => 19900, 'discount' => 35, 'image' => 'kopi-bubuk.png', 'stock' => 8],
                    ['name' => 'Mie Instan (Dus)', 'price' => 115000, 'discount' => 45, 'image' => 'mie-instan.jpg', 'stock' => 12],
                    ['name' => 'Tepung Terigu 1kg', 'price' => 12500, 'discount' => 30, 'image' => 'tepung-terigu.jpg', 'stock' => 20],
                ];
            @endphp

            @foreach ($flashsales as $product)
                @php
                    $discountedPrice = $product['price'] - ($product['price'] * $product['discount'] / 100);
                @endphp
                <div class="border rounded-lg shadow hover:shadow-2xl hover:-translate-y-1 transform transition duration-300 relative overflow-hidden">
                    <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md">-{{ $product['discount'] }}%</span>
                    <img src="{{ asset('images/' . $product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-36 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-1">{{ $product['name'] }}</h3>
                        <p class="text-sm text-gray-500 line-through">Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                        <p class="text-lg font-bold text-red-600 mb-2">Rp {{ number_format($discountedPrice, 0, ',', '.') }}</p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                            <div class="bg-gradient-to-r from-orange-500 to-red-600 h-2 rounded-full" style="width: {{ max(5, ($product['stock'] / 20) * 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mb-3">Sisa stok: {{ $product['stock'] }}</p>
                        <button class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition duration-300">Tambah ke Keranjang</button>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <x-footer />
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const endDate = new Date();
    endDate.setHours(endDate.getHours() + 6);
    const timer = setInterval(() => {
        const now = new Date().getTime();
        const distance = endDate - now;
        if (distance < 0) {
            clearInterval(timer);
            document.querySelector('section').innerHTML = '<h2 class="text-3xl font-bold text-white py-10 text-center">⚡ Flash Sale Telah Berakhir ⚡</h2>';
            return;
        }
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        document.getElementById('days').textContent = String(days).padStart(2, '0');
        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
    }, 1000);
});

function claimVoucher(code) {
    alert('Voucher "' + code + '" berhasil diklaim! Silakan gunakan saat checkout.');
}
</script>
@endsection
