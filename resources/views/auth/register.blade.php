@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col">
    {{-- Navbar --}}
    <x-navbar />

    {{-- Konten Utama --}}
    <div class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Daftar Sebagai Pelanggan</h2>

            {{-- Alert error --}}
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('pelanggan.register') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="nama_pelanggan" name="nama_pelanggan" type="text" value="{{ old('nama_pelanggan') }}" required
                           class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                           class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" required
                           class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" rows="2" required
                              class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('alamat') }}</textarea>
                </div>

                <div>
                    <label for="PIC" class="block text-sm font-medium text-gray-700 mb-1">Nama Kontak / PIC</label>
                    <input id="PIC" name="PIC" type="text" value="{{ old('PIC') }}" required
                           class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <button type="submit" 
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition duration-300">
                    Daftar Sekarang
                </button>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Sudah punya akun? 
                    <a href="{{ route('pelanggan.login.form') }}" class="text-green-700 font-semibold hover:underline">
                        Login di sini
                    </a>
                </p>
            </form>
        </div>
    </div>

    {{-- Footer --}}
    <x-footer />
</div>
@endsection
    