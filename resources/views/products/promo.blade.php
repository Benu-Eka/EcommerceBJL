@extends('layouts.app')

@section('title', 'Penawaran Promo Spesial')

@section('content')
<div class="min-h-screen bg-white">
    <x-navbar />

    <section class="bg-yellow-50 py-10 px-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Penawaran Voucher Spesial</h2>
        <p class="text-gray-600 mb-8">Gunakan voucher berikut untuk mendapatkan potongan tambahan di checkout!</p>

        <div class="flex flex-wrap justify-center gap-6">
            @forelse($vouchers as $voucher)
                <div class="bg-white border-2 {{ $voucher->persen_diskon ? 'border-yellow-400' : 'border-green-400' }} rounded-lg px-6 py-5 shadow hover:shadow-xl w-64">
                    <p class="font-bold text-xl mb-1">{{ $voucher->kode }}</p>
                    <p class="text-gray-600 text-sm mb-4">{{ $voucher->keterangan ?? ($voucher->persen_diskon ? $voucher->persen_diskon . '% off' : 'Diskon') }}</p>

                    @auth('pelanggan')
                        <button onclick="claimVoucher('{{ $voucher->kode }}')"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded-lg transition duration-300 w-full">
                            Klaim Voucher
                        </button>
                    @else
                        <a href="{{ route('pelanggan.login.form') }}" class="block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded-lg transition duration-300">
                            Login untuk Klaim
                        </a>
                    @endauth
                </div>
            @empty
                <p class="text-gray-600">Belum ada promo saat ini.</p>
            @endforelse
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
            @forelse($flashsales as $product)
                @php
                    $diskon = $product->diskon ?? 0;
                    $harga = $product->harga_jual;
                    $discountedPrice = $diskon ? round($harga - ($harga * $diskon / 100)) : $harga;
                @endphp

                <div class="border rounded-lg shadow hover:shadow-2xl hover:-translate-y-1 transform transition duration-300 relative overflow-hidden">
                    @if($diskon)
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-md">-{{ $diskon }}%</span>
                    @endif

                    <img src="{{ asset($product->foto_produk ?? 'images/no-image.png') }}" alt="{{ $product->nama_barang }}" class="w-full h-36 object-cover rounded-t-lg">

                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-1">{{ $product->nama_barang }}</h3>

                        @if($diskon)
                            <p class="text-sm text-gray-500 line-through">Rp {{ number_format($harga, 0, ',', '.') }}</p>
                            <p class="text-lg font-bold text-red-600 mb-2">Rp {{ number_format($discountedPrice, 0, ',', '.') }}</p>
                        @else
                            <p class="text-lg font-bold text-gray-900 mb-2">Rp {{ number_format($harga, 0, ',', '.') }}</p>
                        @endif

                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                            @php
                                $percentWidth = $product->stok_flash_sale && $product->stok_flash_sale > 0
                                    ? min(100, ($product->stok_flash_sale / max(1, ($product->stok ?? 1))) * 100)
                                    : 5;
                            @endphp
                            <div class="bg-gradient-to-r from-orange-500 to-red-600 h-2 rounded-full" style="width: {{ $percentWidth }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mb-3">Sisa stok: {{ $product->stok_flash_sale ?? 0 }}</p>

                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kode_barang" value="{{ $product->kode_barang }}">
                            <button class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition duration-300">Tambah ke Keranjang</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-4 text-center text-gray-500">Tidak ada flash sale saat ini.</p>
            @endforelse
        </div>
    </main>

    <x-footer />
</div>
@endsection

@section('scripts')
<script>
function claimVoucher(kode) {
    fetch("{{ route('voucher.claim') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ kode: kode })
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw data;
        // sukses
        alert(data.message || 'Voucher berhasil diklaim');
        // opsional: disable button atau ubah tampilannya
        location.reload();
    })
    .catch(err => {
        alert(err.error || err.message || 'Terjadi kesalahan saat klaim voucher.');
    });
}
</script>

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
</script>
@endsection
