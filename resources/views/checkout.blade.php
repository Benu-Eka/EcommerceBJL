@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-gray-50">
        <x-navbar/>
        <main class="container mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16">
            
            <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Selesaikan Pesanan Anda</h1>

            {{-- Struktur Utama: 2 Kolom untuk Checkout --}}
            <div class="flex flex-col lg:flex-row gap-8">
                
                {{-- KOLOM KIRI: ALAMAT, PENGIRIMAN, & PEMBAYARAN --}}
                <div class="w-full lg:w-3/5 space-y-8">
                    
                    {{-- 1. INFORMASI PENGIRIMAN/ALAMAT --}}
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                        <div class="flex items-center justify-between mb-4 border-b pb-3">
                            <h2 class="text-xl font-bold text-red-700 flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Alamat Pengiriman
                            </h2>
                            <button class="text-sm font-semibold text-red-600 hover:text-red-800 transition">Ubah Alamat</button>
                        </div>
                        
                        {{-- Placeholder Alamat --}}
                        <div class="text-gray-700 text-base space-y-1">
                            <p class="font-semibold">Budi Santoso (0812-XXXX-7890)</p>
                            <p>Jl. Utama Fanjaya Blok A No. 12, Kel. Sukamaju, Kec. Jatiasih, Bekasi, Jawa Barat 17423</p>
                        </div>
                    </div>

                    {{-- 2. METODE PENGIRIMAN --}}
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                        <h2 class="text-xl font-bold text-red-700 mb-4 border-b pb-3 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Opsi Pengiriman
                        </h2>
                        
                        <div class="space-y-4">
                            {{-- Pilihan 1: Reguler --}}
                            <label class="flex justify-between items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-red-50 transition">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" name="shipping_method" value="reguler" checked 
                                           class="h-4 w-4 text-red-700 focus:ring-red-500 border-gray-300">
                                    <div class="text-gray-800">
                                        <p class="font-semibold">Reguler (JNE/TIKI/Sicepat)</p>
                                        <p class="text-xs text-gray-500">Estimasi 2-4 Hari</p>
                                    </div>
                                </div>
                                <span class="font-bold text-gray-800">Rp 18.000</span>
                            </label>
                            
                            {{-- Pilihan 2: Cargo (Hemat) --}}
                            <label class="flex justify-between items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-red-50 transition">
                                <div class="flex items-center space-x-3">
                                    <input type="radio" name="shipping_method" value="cargo" 
                                           class="h-4 w-4 text-red-700 focus:ring-red-500 border-gray-300">
                                    <div class="text-gray-800">
                                        <p class="font-semibold">Kargo (Untuk Berat > 10kg)</p>
                                        <p class="text-xs text-gray-500">Estimasi 3-7 Hari</p>
                                    </div>
                                </div>
                                <span class="font-bold text-gray-800">Rp 35.000</span>
                            </label>
                        </div>
                    </div>

                    {{-- 3. METODE PEMBAYARAN --}}
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200">
                        <h2 class="text-xl font-bold text-red-700 mb-4 border-b pb-3 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Metode Pembayaran
                        </h2>
                        
                        <div class="space-y-4">
                            {{-- Opsi 1: Transfer Bank (BCA) --}}
                            <label class="flex items-center space-x-3 p-4 border border-gray-300 rounded-lg cursor-pointer has-[:checked]:border-red-700 has-[:checked]:bg-red-50 transition">
                                <input type="radio" name="payment_method" value="bca" checked
                                       class="h-4 w-4 text-red-700 focus:ring-red-500 border-gray-300">
                                <span class="font-semibold text-gray-800">Transfer Bank (BCA)</span>
                                <img src="https://via.placeholder.com/40x20?text=BCA" alt="BCA Logo" class="h-4 ml-auto">
                            </label>
                            
                            {{-- Opsi 2: Virtual Account (Mandiri) --}}
                            <label class="flex items-center space-x-3 p-4 border border-gray-300 rounded-lg cursor-pointer has-[:checked]:border-red-700 has-[:checked]:bg-red-50 transition">
                                <input type="radio" name="payment_method" value="va_mandiri"
                                       class="h-4 w-4 text-red-700 focus:ring-red-500 border-gray-300">
                                <span class="font-semibold text-gray-800">Virtual Account (Mandiri)</span>
                                <img src="https://via.placeholder.com/40x20?text=MDR" alt="Mandiri Logo" class="h-4 ml-auto">
                            </label>
                            
                            {{-- Opsi 3: E-Wallet (QRIS) --}}
                            <label class="flex items-center space-x-3 p-4 border border-gray-300 rounded-lg cursor-pointer has-[:checked]:border-red-700 has-[:checked]:bg-red-50 transition">
                                <input type="radio" name="payment_method" value="qris"
                                       class="h-4 w-4 text-red-700 focus:ring-red-500 border-gray-300">
                                <span class="font-semibold text-gray-800">E-Wallet (QRIS)</span>
                                <img src="https://via.placeholder.com/40x20?text=QRIS" alt="QRIS Logo" class="h-4 ml-auto">
                            </label>
                        </div>
                    </div>
                    
                </div>
                
                {{-- KOLOM KANAN: RINGKASAN PESANAN --}}
                <div class="w-full lg:w-2/5 sticky top-8 h-fit">
                    <div class="bg-white p-6 rounded-xl shadow-xl border-2 border-red-500 space-y-5">
                        <h2 class="text-xl font-bold text-gray-900 mb-3 border-b pb-3">Ringkasan Pesanan</h2>
                        
                        {{-- Daftar Item (Contoh 2 Item) --}}
                        <div class="space-y-3 text-sm border-b pb-4">
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Beras Premium 5kg (x1)</span>
                                <span>Rp 65.000</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Minyak Goreng 2 Liter (x3)</span>
                                <span>Rp 104.700</span> {{-- 3 * 34.900 --}}
                            </div>
                            <div class="flex justify-between items-center text-gray-700">
                                <span>Lada Bubuk Murni 100gr (x2)</span>
                                <span>Rp 36.000</span> {{-- 2 * 18.000 --}}
                            </div>
                        </div>

                        {{-- Subtotal & Diskon --}}
                        <div class="space-y-3 text-gray-700 border-b pb-4">
                            <div class="flex justify-between">
                                <span>Subtotal Produk</span>
                                <span class="font-semibold">Rp 205.700</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Biaya Pengiriman</span>
                                <span class="font-semibold">Rp 18.000</span> {{-- Berdasarkan pilihan Reguler --}}
                            </div>
                            <div class="flex justify-between text-red-600">
                                <span>Diskon Voucher</span>
                                <span class="font-bold">- Rp 5.000</span>
                            </div>
                        </div>

                        {{-- TOTAL PEMBAYARAN --}}
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-lg font-bold text-gray-900">Total Pembayaran</span>
                            <span class="text-2xl font-extrabold text-red-700">Rp 218.700</span>
                        </div>

                        {{-- Tombol Konfirmasi --}}
                        <button class="w-full py-3 px-4 rounded-full text-lg font-bold text-white bg-red-700 hover:bg-red-800 transition shadow-lg mt-4">
                            Konfirmasi Pesanan
                        </button>
                    </div>
                </div>
                
            </div>
            
        </main>
        
        <x-footer />
    </div>
@endsection