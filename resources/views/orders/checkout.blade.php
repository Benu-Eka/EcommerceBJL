@extends('layouts.app')

@section('title', 'Checkout | Gudang Bumbu & Sembako')

@section('content')
<x-navbar />

<div class="min-h-screen bg-gray-50 py-6 px-4">
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl p-6">
        <a href="{{ route('cart.index') }}" 
           class="text-sm text-gray-600 hover:text-green-700 flex items-center gap-1">
            ← Kembali ke Keranjang
        </a>

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Checkout</h1>
        </div>

        {{-- FORM CHECKOUT --}}
        <form id="checkout-form" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- BAGIAN KIRI --}}
                <div class="lg:col-span-2 space-y-5">

                    {{-- ALAMAT PENGIRIMAN --}}
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h2 class="text-sm font-semibold text-gray-800 mb-2">Alamat Pengiriman</h2>

                        <div class="space-y-2 text-sm text-gray-700">
                            <input type="text" name="nama_penerima" placeholder="Nama penerima" required
                                class="w-full border-gray-300 rounded-md text-sm p-2 focus:ring-green-500 focus:border-green-500">
                            <input type="text" name="alamat" placeholder="Alamat lengkap" required
                                class="w-full border-gray-300 rounded-md text-sm p-2 focus:ring-green-500 focus:border-green-500">
                            <input type="text" name="kota" placeholder="Kota/Kabupaten" required
                                class="w-full border-gray-300 rounded-md text-sm p-2 focus:ring-green-500 focus:border-green-500">
                            <input type="text" name="telepon" placeholder="Nomor Telepon" required
                                class="w-full border-gray-300 rounded-md text-sm p-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                    </div>

                    {{-- METODE PEMBAYARAN --}}
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">Metode Pembayaran</h2>

                        <label class="flex items-center gap-3 mb-2">
                            <input type="radio" name="pembayaran" value="midtrans" checked class="accent-green-600">
                            <div>
                                <p class="font-medium text-gray-800">Pembayaran Online (Midtrans)</p>
                                <p class="text-xs text-gray-500">Kartu Kredit, Transfer Bank, E-Wallet, QRIS</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3">
                            <input type="radio" name="pembayaran" value="cod" class="accent-green-600">
                            <div>
                                <p class="font-medium text-gray-800">Bayar di Tempat (COD)</p>
                                <p class="text-xs text-gray-500">Bayar langsung ke kurir saat barang diterima</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- BAGIAN KANAN - RINGKASAN --}}
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 h-fit">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Ringkasan Pesanan</h2>

                    {{-- Daftar Barang Sementara (simulasi tampilan) --}}
                    <div id="cartItems" class="space-y-2 mb-3 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>Beras Premium 5kg</span>
                            <span>Rp 70.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Minyak Goreng 2L</span>
                            <span>Rp 35.000</span>
                        </div>
                    </div>

                    <hr class="my-3">

                    {{-- Ringkasan --}}
                    <div class="space-y-1 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp 105.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Diskon (10%)</span>
                            <span id="diskon" class="text-green-600">-Rp 10.500</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Pengiriman</span>
                            <span id="biayaPengiriman">Rp 5.000</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between font-semibold text-gray-900 text-base">
                            <span>Total Bayar</span>
                            <span id="totalBayar">Rp 99.500</span>
                        </div>
                    </div>

                    <button type="button" id="pay-button" form="checkoutForm"
                        class="w-full mt-5 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition text-sm">
                        Buat Surat Jalan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<x-footer />

{{-- ✅ SWEETALERT FEEDBACK --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    confirmButtonText: 'OK',
    confirmButtonColor: '#16a34a'
}).then((result) => {
    if (result.isConfirmed) {
        window.location.href = "{{ url('/product') }}"; // 🔁 redirect ke halaman produk
    }
});
</script>
@endif

@if (session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session('error') }}',
    confirmButtonText: 'OK',
    confirmButtonColor: '#dc2626'
});
</script>
@endif

<script>
document.getElementById('pay-button').addEventListener('click', function () {

    let form = document.getElementById('checkout-form');

    // Ambil data form
    let data = new FormData(form);

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

        console.log("Response dari server:", data);

        // Pastikan snap_token ada
        if (!data.snap_token) {
            console.error("snap_token tidak ada:", data);
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: function(result){
                window.location.href = "{{ route('orders.success') }}";
            },
            onPending: function(result){
                window.location.href = "{{ route('orders.pending') }}";
            },
            onError: function(result){
                window.location.href = "{{ route('orders.failed') }}";
            }
        });
    });
});
</script>


@endsection