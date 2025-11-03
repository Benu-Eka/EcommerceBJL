@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col">
    {{-- Navbar --}}
    <x-navbar />

    {{-- Konten Utama --}}
    <div class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Pelanggan</h2>

            {{-- Alert sukses --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Alert error --}}
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('pelanggan.login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" required
                           class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="flex items-center justify-between mt-4">
                    <button type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold transition duration-300">
                        Masuk
                    </button>
                </div>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Belum punya akun? 
                    <a href="{{ route('pelanggan.register.form') }}" class="text-green-700 font-semibold hover:underline">
                        Daftar Sekarang
                    </a>
                </p>
            </form>
        </div>
    </div>

    {{-- Footer --}}
    <x-footer />
</div>
@endsection
