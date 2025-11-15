@extends('layouts.app')

@section('title', 'Checkout | Gudang Bumbu & Sembako')

@section('content')
<x-navbar />

@php
    // DATA ITEM DARI CART DIKIRIM MELALUI HIDDEN INPUT
    $items = json_decode(request('selected_items'), true);

    // HITUNG SUBTOTAL
    $subtotal = collect($items)->sum(fn($x) => $x['harga'] * $x['qty']);
    $ongkir = 5000;
    $total = $subtotal + $ongkir;

    $user = Auth::user();
@endphp

<div class="min-h-screen bg-gray-50 py-6 px-4">
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl p-6">

        <a href="{{ route('cart.index') }}" 
           class="text-sm text-gray-600 hover:text-green-700 flex items-center gap-1">
            ← Kembali ke Keranjang
        </a>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Checkout</h1>
        </div>

        {{-- FORM CHECKOUT --}}
        <form id="checkoutForm">
            @csrf

            {{-- Kirim data barang ke controller --}}
            <input type="hidden" name="items" value="{{ request('selected_items') }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- KIRI --}}
                <div class="lg:col-span-2 space-y-5">

                    {{-- ALAMAT --}}
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h2 class="text-sm font-semibold text-gray-800 mb-2">Alamat Pengiriman</h2>

                        <div class="space-y-2 text-sm text-gray-700">
                            <input type="text" name="nama_penerima" value="{{ $user->nama_pelanggan }}"
                                class="w-full border-gray-300 rounded-md text-sm p-2" required>

                            <input type="text" name="alamat" value="{{ $user->alamat }}"
                                class="w-full border-gray-300 rounded-md text-sm p-2" required>

                            <input type="text" name="kota" value="{{ $user->kota ?? '' }}"
                                class="w-full border-gray-300 rounded-md text-sm p-2" required>

                            <input type="text" name="telepon" value="{{ $user->telepon ?? '' }}"
                                class="w-full border-gray-300 rounded-md text-sm p-2" required>
                        </div>
                    </div>

                    {{-- PEMBAYARAN --}}
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">Metode Pembayaran</h2>

                        <label class="flex items-center gap-3 mb-2">
                            <input type="radio" name="pembayaran" value="midtrans" checked class="accent-green-600">
                            <div>
                                <p class="font-medium text-gray-800">Pembayaran Online (Midtrans)</p>
                                <p class="text-xs text-gray-500">QRIS, Transfer Bank, E-Wallet, dll.</p>
                            </div>
                        </label>

                        <label class="flex items-center gap-3">
                            <input type="radio" name="pembayaran" value="cod" class="accent-green-600">
                            <div>
                                <p class="font-medium text-gray-800">Bayar di Tempat (COD)</p>
                                <p class="text-xs text-gray-500">Pembayaran dilakukan ke kurir.</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- KANAN --}}
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 h-fit">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Ringkasan Pesanan</h2>

                    {{-- LIST PRODUK --}}
                    <div id="cartItems" class="space-y-2 mb-3 text-sm text-gray-700">
                        @foreach ($items as $item)
                        <div class="flex justify-between">
                            <span>{{ $item['kode_barang'] }} (x{{ $item['qty'] }})</span>
                            <span>Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <hr class="my-3">

                    <div class="space-y-1 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span>Biaya Pengiriman</span>
                            <span>Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                        </div>

                        <hr class="my-2">

                        <div class="flex justify-between font-semibold text-gray-900 text-base">
                            <span>Total Bayar</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="button" id="payButton"
                        class="w-full mt-5 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg">
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<x-footer />

{{-- MIDTRANS SCRIPT --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('payButton').addEventListener('click', async function () {

    let metode = document.querySelector('input[name="pembayaran"]:checked').value;

    // Jika COD → submit ke backend
    if (metode === 'cod') {
        document.getElementById('checkoutForm').submit();
        return;
    }

    // MIDTRANS → KIRIM KE BACKEND UNTUK SNAP TOKEN
    let formData = new FormData(document.getElementById('checkoutForm'));

    let response = await fetch("{{ route('orders.store') }}", {
        method: "POST",
        body: formData
    });

    let result = await response.json();

    if (!result.snap_token) {
        Swal.fire("Error", "Gagal membuat transaksi Midtrans.", "error");
        return;
    }

    // JALANKAN MIDTRANS SNAP
    snap.pay(result.snap_token, {
        onSuccess: function(result){
            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil!',
                text: 'Surat jalan berhasil dibuat.',
            }).then(() => {
                window.location.href = "/pesanan";
            });
        },
        onPending: function(result){ alert("Menunggu pembayaran..."); },
        onError: function(result){ alert("Pembayaran gagal"); }
    });

});
</script>

@endsection
