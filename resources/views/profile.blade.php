@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <x-navbar />

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Tombol Back dan Judul Halaman --}}
        <div class="mb-8">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center text-gray-600 hover:text-red-700 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-3">Pengaturan Akun Agen</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Kolom Kiri: Data Diri & Toko --}}
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow border border-gray-100">
                <h2 class="text-lg font-semibold text-red-700 mb-5 border-b border-gray-200 pb-2">
                    Data Diri & Toko
                </h2>

                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col md:flex-row gap-6">
                        {{-- Area Foto Profil --}}
                        <div class="flex flex-col items-center space-y-3 w-full md:w-1/3 order-first md:order-last">
                            <img src="https://via.placeholder.com/128x128/D9534F/FFFFFF?text=FJA" 
                                 alt="Foto Profil" 
                                 class="h-28 w-28 rounded-full object-cover border-4 border-red-200 shadow-md">
                            
                            <label for="profile_photo" 
                                   class="cursor-pointer inline-flex justify-center py-2 px-4 border border-red-700 shadow-sm text-xs font-semibold rounded-full text-red-700 bg-white hover:bg-red-50 transition">
                                Pilih Gambar Baru
                            </label>
                            <input type="file" id="profile_photo" name="profile_photo" class="hidden">
                        </div>

                        {{-- Area Form Input --}}
                        <div class="w-full md:w-2/3 space-y-4">
                            {{-- Nama Lengkap --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="Budi Santoso"
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                            </div>

                            {{-- Nama Toko --}}
                            <div>
                                <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Toko/Bisnis</label>
                                <input type="text" id="business_name" name="business_name" value="Toko Grosir Barokah Jaya"
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                            </div>

                            {{-- Email (Disabled) --}}
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" value="budisantoso@example.com" disabled
                                    class="w-full border border-gray-200 bg-gray-100 rounded-lg py-2 px-3.5 text-sm cursor-not-allowed text-gray-500">
                            </div>

                            {{-- Nomor Telepon --}}
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                <input type="text" id="phone" name="phone" value="0812-3456-7890"
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                            </div>

                            {{-- Tombol Simpan --}}
                            <div class="pt-3">
                                <button type="submit" 
                                    class="py-2 px-6 border border-transparent shadow-sm text-sm font-semibold rounded-full text-white bg-red-700 hover:bg-red-800 transition">
                                    Simpan Perubahan Data Diri
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Kolom Kanan: Keamanan Akun --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow border border-gray-100">
                    <h2 class="text-lg font-semibold text-red-700 mb-3">Keamanan Akun</h2>
                    <p class="text-gray-600 mb-5 text-sm">
                        Ubah kata sandi Anda secara berkala untuk menjaga keamanan akun.
                    </p>

                    {{-- Tombol untuk menampilkan form password --}}
                    <button id="toggle-password-form"
                        class="w-full py-2 px-4 border border-red-700 text-sm font-semibold rounded-lg text-red-700 bg-white hover:bg-red-50 transition shadow-sm">
                        Ganti Kata Sandi
                    </button>

                    {{-- Form Ubah Password --}}
                    <div id="password-form-container" class="mt-6 space-y-4 hidden">
                        <form action="#" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            {{-- Password Lama --}}
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Sandi Lama</label>
                                <input type="password" id="current_password" name="current_password" required
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                            </div>

                            {{-- Password Baru --}}
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Sandi Baru</label>
                                <input type="password" id="password" name="password" required
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Sandi Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                            </div>

                            {{-- Tombol Simpan --}}
                            <div class="pt-2">
                                <button type="submit"
                                    class="w-full py-2 px-4 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white bg-red-700 hover:bg-red-800 transition">
                                    Simpan Sandi Baru
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggle-password-form');
        const passwordForm = document.getElementById('password-form-container');

        toggleButton.addEventListener('click', function() {
            passwordForm.classList.toggle('hidden');
            toggleButton.textContent = passwordForm.classList.contains('hidden')
                ? 'Ganti Kata Sandi'
                : 'Sembunyikan Form';
        });
    });
</script>
@endsection
