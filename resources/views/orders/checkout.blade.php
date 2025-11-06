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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- BAGIAN KIRI - INFORMASI PENGIRIMAN --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- ALAMAT PENGIRIMAN --}}
                <div class="border border-gray-200 rounded-lg p-4 relative">

    {{-- Alamat Pengiriman --}}
    <div class="flex justify-between items-start">
        <h2 class="text-sm font-semibold text-gray-800">Shipping address</h2>
        <button id="editAddressBtn" class="text-sm text-green-600 hover:text-green-800 font-medium">Change</button>
    </div>

    <div id="addressDisplay" class="mt-2 text-sm text-gray-700 leading-snug">
        <p id="nameDisplay" class="font-medium text-gray-900">John Newman</p>
        <p id="streetDisplay">2135 Chestnut St</p>
        <p id="cityDisplay">San Francisco, CA 94123-2738</p>
        <p id="countryDisplay">United States</p>
    </div>

    {{-- Form Edit (Tersembunyi) --}}
    <form id="editAddressForm" class="mt-2 hidden space-y-2">
        <input type="text" id="nameInput" value="John Newman"
            class="w-full border-gray-300 rounded-md text-sm p-2 focus:ring-green-500 focus:border-green-500">
        <input type="text" id="streetInput" value="2135 Chestnut St"
            class="w-full border-gray-300 rounded-md text-sm p-2 focus:ring-green-500 focus:border-green-500">
        <input type="text" id="cityInput" value="San Francisco, CA 94123-2738"
            class="w-full border-gray-300 rounded-md text-sm p-2 focus:ring-green-500 focus:border-green-500">
        <input type="text" id="countryInput" value="United States"
            class="w-full border-gray-300 rounded-md text-sm p-2 focus:ring-green-500 focus:border-green-500">
        <button type="button" id="saveAddressBtn"
            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-1.5 rounded-md text-sm">Save</button>
    </form>
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

                <div class="space-y-2 mb-3">
                    <div class="flex justify-between text-sm text-gray-700">
                        <span>Beras Premium 5kg</span>
                        <span>Rp 70.000</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-700">
                        <span>Minyak Goreng 2L</span>
                        <span>Rp 35.000</span>
                    </div>
                </div>

                <hr class="my-3">

                <div class="space-y-1 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp 105.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Diskon (10%)</span>
                        <span class="text-green-600">-Rp 10.500</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Penanganan</span>
                        <span>Rp 5.000</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between font-semibold text-gray-900 text-base">
                        <span>Total Bayar</span>
                        <span>Rp 99.500</span>
                    </div>
                </div>

                <button id="payButton"
                    class="w-full mt-5 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition text-sm">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<x-footer />

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('editAddressBtn');
    const form = document.getElementById('editAddressForm');
    const display = document.getElementById('addressDisplay');
    const saveBtn = document.getElementById('saveAddressBtn');

    editBtn.addEventListener('click', () => {
        form.classList.toggle('hidden');
        display.classList.toggle('hidden');
        editBtn.textContent = form.classList.contains('hidden') ? 'Change' : 'Cancel';
    });

    saveBtn.addEventListener('click', () => {
        document.getElementById('nameDisplay').textContent = document.getElementById('nameInput').value;
        document.getElementById('streetDisplay').textContent = document.getElementById('streetInput').value;
        document.getElementById('cityDisplay').textContent = document.getElementById('cityInput').value;
        document.getElementById('countryDisplay').textContent = document.getElementById('countryInput').value;

        form.classList.add('hidden');
        display.classList.remove('hidden');
        editBtn.textContent = 'Change';
        alert('Alamat berhasil diperbarui!');
    });
    // Simulasi pembayaran Midtrans
    document.getElementById('payButton').addEventListener('click', () => {
        const metode = document.querySelector('input[name="pembayaran"]:checked').value;
        if (metode === 'midtrans') {
            alert('Redirect ke halaman pembayaran Midtrans...');
        } else {
            alert('Pesanan akan dibayar di tempat (COD)');
        }
    });
});
</script>
@endsection
