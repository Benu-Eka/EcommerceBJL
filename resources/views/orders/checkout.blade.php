@extends('layouts.app')

@section('title', 'Checkout | Gudang Bumbu & Sembako')

@section('content')
<x-navbar />

<div class="min-h-screen bg-[#f9fafb] py-10 px-4">
    <div class="max-w-5xl mx-auto">
        
        {{-- Tombol Kembali Konsisten --}}
        <div class="mb-8">
            <a href="{{ route('cart.index') }}" 
               class="inline-flex items-center text-gray-500 hover:text-red-700 font-medium transition-colors duration-200 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Keranjang
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-4 tracking-tight">Checkout</h1>
            <p class="text-gray-500 text-sm mt-1">Lengkapi informasi pengiriman untuk menyelesaikan pesanan.</p>
        </div>

        {{-- FORM CHECKOUT --}}
        <form id="checkout-form" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- BAGIAN KIRI: DATA PENGIRIMAN & PEMBAYARAN --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- ALAMAT PENGIRIMAN --}}
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Alamat Pengiriman</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Nama Penerima</label>
                                <input type="text" name="nama_penerima" placeholder="Contoh: Budi Santoso" required
                                    class="w-full mt-1 bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-4 focus:ring-red-50 transition-all outline-none">
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW..." required
                                    class="w-full mt-1 bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-4 focus:ring-red-50 transition-all outline-none resize-none"></textarea>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Kota/Kabupaten</label>
                                <input type="text" name="kota" placeholder="Contoh: Jakarta Selatan" required
                                    class="w-full mt-1 bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-4 focus:ring-red-50 transition-all outline-none">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Nomor Telepon</label>
                                <input type="text" name="telepon" placeholder="0812xxxx" required
                                    class="w-full mt-1 bg-gray-50 border-none rounded-2xl p-4 text-sm focus:ring-4 focus:ring-red-50 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- METODE PEMBAYARAN --}}
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-red-50 rounded-xl flex items-center justify-center text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Metode Pembayaran</h2>
                        </div>

                        <label class="flex items-center justify-between p-4 bg-red-50 border-2 border-red-100 rounded-2xl cursor-pointer group transition-all">
                            <div class="flex items-center gap-4">
                                <input type="radio" name="pembayaran" value="midtrans" checked class="w-5 h-5 text-red-600 focus:ring-red-500 border-gray-300">
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">Pembayaran Instan (Midtrans)</p>
                                    <p class="text-xs text-gray-500">Virtual Account, E-Wallet, Kartu Kredit</p>
                                </div>
                            </div>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b9/Midtrans.png" class="h-4 grayscale group-hover:grayscale-0 transition">
                        </label>
                    </div>
                </div>

                {{-- BAGIAN KANAN: RINGKASAN TOTAL --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 border border-gray-100 p-8 sticky top-10">
                        <h2 class="text-xl font-black text-gray-900 mb-6">Ringkasan Biaya</h2>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-sm text-gray-500 font-medium">
                                <span>Subtotal Produk</span>
                                <span class="text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex justify-between text-sm text-gray-500 font-medium">
                                <span>Diskon Member (10%)</span>
                                <span class="text-green-600">- Rp {{ number_format($diskon, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex justify-between text-sm text-gray-500 font-medium">
                                <span>Biaya Pengiriman</span>
                                <span class="text-gray-900">Rp {{ number_format($biayaPengiriman, 0, ',', '.') }}</span>
                            </div>

                            <div class="pt-4 mt-4 border-t border-gray-50 flex justify-between items-center">
                                <span class="text-gray-900 font-bold">Total Pembayaran</span>
                                <span class="text-2xl font-black text-red-600 tracking-tight">
                                    Rp {{ number_format($totalBayar, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <button type="button" id="pay-button"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-red-100 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 group">
                            <span>Bayar Sekarang</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>

                        <p class="text-[10px] text-gray-400 text-center mt-6 leading-relaxed uppercase font-bold tracking-widest">
                            Terverifikasi & Aman <br> 
                            Gudang Bumbu & Sembako
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<x-footer />

{{-- Scripts tetap sama seperti fungsionalitas Anda --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    confirmButtonColor: '#dc2626'
}).then(() => { window.location.href = "{{ url('/product') }}"; });
</script>
@endif

@if (session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session('error') }}',
    confirmButtonColor: '#dc2626'
});
</script>
@endif

<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').addEventListener('click', function () {
    let form = document.getElementById('checkout-form');
    let data = new FormData(form);

    // Efek loading saat klik
    this.innerHTML = "Memproses...";
    this.disabled = true;

    fetch("{{ route('orders.pay') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if (!data.snap_token) {
            Swal.fire('Error', 'Gagal mendapatkan token pembayaran', 'error');
            this.innerHTML = "Bayar Sekarang";
            this.disabled = false;
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: (result) => { window.location.href = "{{ route('orders.success') }}"; },
            onPending: (result) => { window.location.href = "{{ route('orders.pending') }}"; },
            onError: (result) => { window.location.href = "{{ route('orders.failed') }}"; },
            onClose: () => { 
                this.innerHTML = "Bayar Sekarang";
                this.disabled = false;
            }
        });
    })
    .catch(err => {
        this.innerHTML = "Bayar Sekarang";
        this.disabled = false;
    });
});
</script>
@endsection