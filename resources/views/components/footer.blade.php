@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col">
    {{-- Komponen Layout: Navbar --}}
    <x-navbar />

    {{-- Konten Utama Form Login --}}
    <div class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Pelanggan</h2>

            {{-- Alert Sukses (e.g., Setelah Registrasi Berhasil) --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Aler Penanganan Error Validasi/Login Gagal --}}
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Struktur Form: Menggunakan POST dan Token Keamanan CSRF --}}
            <form method="POST" action="{{ route('pelanggan.login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                {{-- Tombol Aksi Submit --}}
                <div class="flex items-center justify-between mt-4">
                    <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition duration-300">
                        Masuk
                    </button>
                </div>

                {{-- Tautan ke Halaman Registrasi --}}
                <p class="text-center text-sm text-gray-600 mt-4">
                    Belum punya akun?
                    <a href="{{ route('pelanggan.register.form') }}" class="text-green-700 font-semibold hover:underline">
                        Daftar Sekarang
                    </a>
                </p>
            </form>
        </div>
    </div>

    {{-- Footer dengan Desain Kustom --}}
    <footer class="bg-red-800 text-white mt-16 shadow-inner">
        
        {{-- BARIS ATAS: INFORMASI, NAVIGASI & KONTAK --}}
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 border-b border-white/20">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                
                {{-- KOLOM 1: Logo & Deskripsi --}}
                <div class="col-span-2 lg:col-span-2 space-y-4">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('build/assets/images/logo2.png') }}" alt="Fanjaya Mulia Abadi" class="h-12">
                        <span class="text-xl font-extrabold text-white">Berkah Jaya Lumintu</span>
                    </div>
                    <p class="text-gray-400 text-sm max-w-sm">
                        Pusat grosir bahan baku dan produk berkualitas tinggi. Melayani kebutuhan bisnis Anda dengan integritas dan profesionalisme.
                    </p>
                    <div class="flex space-x-3 pt-2">
                        <a href="#" class="text-gray-400 hover:text-red-400 transition duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm3 8h-2v2h2v2h-2v6h-3V14h-2v-2h2V9a3 3 0 013-3h3v3z"></path></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-400 transition duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.7 15.3c-.6 0-1.2-.1-1.8-.3-.6-.2-1.1-.5-1.5-1-.4-.5-.7-1-.9-1.6-.2-.6-.2-1.2-.2-1.8s0-1.2.2-1.8c.2-.6.5-1.1.9-1.6.4-.5.9-.8 1.5-1 .6-.2 1.2-.3 1.8-.3s1.2.1 1.8.3c.6.2 1.1.5 1.5 1 .4.5.7 1 .9 1.6.2.6.2 1.2.2 1.8s0 1.2-.2 1.8c-.2.6-.5 1.1-.9 1.6-.4.5-.9.8-1.5 1-.6.2-1.2.3-1.8.3zM12 14.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 9.5 12 9.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"></path></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-400 transition duration-300">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 4.5l-2.4 1.2V20h4.8V5.7L12.5 4.5zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.8 15h-1.4V10h1.4v7zm3.6 0H14V10h1.4v7z"></path></svg>
                        </a>
                    </div>
                </div>
                
                {{-- KOLOM 2: Navigasi Cepat --}}
                <div class="space-y-3">
                    <h3 class="text-lg font-semibold text-white mb-2">Navigasi Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Beranda</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Produk</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Promo</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Transaksi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Profil Agen</a></li>
                    </ul>
                </div>
                
                {{-- KOLOM 3: Bantuan --}}
                <div class="space-y-3">
                    <h3 class="text-lg font-semibold text-white mb-2">Layanan & Bantuan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Cara Berbelanja</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Ketentuan Pengiriman</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-200">Hubungi Kami</a></li>
                    </ul>
                </div>

                {{-- KOLOM 4: Informasi Kontak --}}
                <div class="col-span-2 md:col-span-1 space-y-3">
                    <h3 class="text-lg font-semibold text-white mb-2">Kontak Kami</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-start space-x-2">
                            <svg class="w-5 h-5 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Raya Tembarak, Wonokerso Kulon, Wonokerso, Kec. Tembarak, Kabupaten Temanggung, Jawa Tengah 56261 </span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:info@fanjay.co.id" class="hover:text-white">BerkahJayaLumintu@gmail.com</a>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>0812-2559-159</span>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
        
        {{-- BARIS BAWAH: COPYRIGHT --}}
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row justify-center items-center text-sm">
                <p class="text-gray-400">
                    Copyright &copy; {{ date('Y') }} Berkah Jaya Lumintu. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</div>
@endsection
