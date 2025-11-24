@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50">
    <x-navbar />


@if (session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Tombol Back dan Judul Halaman --}}
        <div class="mb-8">
            <a href="{{ route('profile.index') }}" 
            class="inline-flex items-center text-gray-600 hover:text-green-700 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-3">Pengaturan Akun Pelanggan</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Kolom Kiri: Data Diri Pelanggan --}}
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow border border-gray-100">
                <h2 class="text-lg font-semibold text-green-700 mb-5 border-b border-gray-200 pb-2">
                    Data Diri Pelanggan
                </h2>

                @if(session('status'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                @method('PUT')
                    @csrf
                    {{-- Nama Pelanggan --}}
                    <div class="mb-4">
                        <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                            value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    {{-- Email (tidak bisa diubah langsung) --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $pelanggan->email ?? '') }}" readonly
                            class="w-full border border-gray-200 bg-gray-100 rounded-lg py-2 px-3 text-sm text-gray-500 cursor-not-allowed">
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="2"
                            class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('alamat', $pelanggan->alamat ?? '') }}</textarea>
                    </div>

                    {{-- NPWP --}}
                    <div class="mb-4">
                        <label for="NPWP" class="block text-sm font-medium text-gray-700 mb-1">NPWP</label>
                        <input type="text" id="NPWP" name="NPWP"
                            value="{{ old('NPWP', $pelanggan->NPWP ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    {{-- PIC --}}
                    <div class="mb-4">
                        <label for="PIC" class="block text-sm font-medium text-gray-700 mb-1">Nama Kontak / PIC</label>
                        <input type="text" id="PIC" name="PIC"
                            value="{{ old('PIC', $pelanggan->PIC ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>

                    {{-- kategori pelanggan --}}
                    {{-- <div class="mb-4">
                        <label for="kategori_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">Kategori Pelanggan</label>
                        <input type="text" id="kategori_pelanggan" name="kategori_pelanggan"
                            value="{{ old('kategori_pelanggan', $pelanggan->kategori_pelanggan ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div> --}}
                    <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Pelanggan</label>

                    <select id="kategori_pelanggan_id" name="kategori_pelanggan_id"
                        class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">

                        <option value="">Pilih kategori...</option>

                        @foreach ($kategori as $k)
                            <option value="{{ $k->kategori_pelanggan_id }}"
                                {{ old('kategori_pelanggan_id', $pelanggan->kategori_pelanggan_id ?? '') == $k->kategori_pelanggan_id ? 'selected' : '' }}>
                                {{ $k->kategori_pelanggan }}
                            </option>
                        @endforeach
                    </select>


                    {{-- Tombol Simpan --}}
                    <div class="pt-3">
                        <button type="submit" 
                            class="py-2 px-6 border border-transparent shadow-sm text-sm font-semibold rounded-full text-white bg-green-600 hover:bg-green-700 transition">
                            Simpan Perubahan Data
                        </button>
                    </div>
                </form>
            </div>

            {{-- Kolom Kanan: Keamanan Akun --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow border border-gray-100">
                    <h2 class="text-lg font-semibold text-green-700 mb-3">Keamanan Akun</h2>
                    <p class="text-gray-600 mb-5 text-sm">
                        Ubah kata sandi Anda secara berkala untuk menjaga keamanan akun.
                    </p>

                    <button id="toggle-password-form"
                        class="w-full py-2 px-4 border border-green-700 text-sm font-semibold rounded-lg text-green-700 bg-white hover:bg-green-50 transition shadow-sm">
                        Ganti Kata Sandi
                    </button>

                    {{-- Form Ganti Password --}}
                    <div id="password-form-container" class="mt-6 space-y-4 hidden">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Sandi Baru</label>
                                <input type="password" id="password" name="password"
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Sandi Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full border border-gray-300 rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            </div>

                            <button type="submit"
                                class="w-full py-2 px-4 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white bg-green-600 hover:bg-green-700 transition">
                                Simpan Sandi Baru
                            </button>
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
