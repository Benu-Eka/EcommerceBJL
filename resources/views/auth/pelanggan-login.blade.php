@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col font-sans">
    <x-navbar />

    {{-- Konten Utama --}}
    <div class="flex-grow flex items-center justify-center py-10 px-4">
        {{-- Card Container Utama --}}
        <div class="max-w-5xl w-full bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-gray-100">
            
            <div class="w-full md:w-1/2 p-10 flex flex-col justify-center items-center text-center bg-white">
                <div class="mb-8">
                    <h1 class="text-3xl font-black text-red-600 tracking-tight leading-tight uppercase">
                        Toko <br> Berkah Jaya Lumintu
                    </h1>
                    <p class="text-gray-500 mt-2 font-medium">Solusi Belanja Terpercaya Anda</p>
                </div>

                <div class="relative w-full max-w-xs transition-transform hover:scale-105 duration-500">
                    <img src="{{ asset('build/assets/images/troli.png') }}"
                         alt="Shopping Illustration" class="w-full h-auto">
                </div>
            </div>

            <div class="w-full md:w-1/2 bg-[#fbcfe8] p-8 md:p-12 flex flex-col justify-center">
                <div class="max-w-sm mx-auto w-full text-center">
                    <h2 class="text-2xl font-extrabold mb-8 text-red-600 uppercase tracking-widest">
                        Masuk Akun Anda
                    </h2>

                    {{-- Alert handling --}}
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-500 text-white text-xs rounded-full shadow-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-500 text-white text-xs rounded-full shadow-md">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pelanggan.login') }}" class="space-y-6">
                        @csrf

                        {{-- Email Input --}}
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-red-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                            </span>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                                   placeholder="Username / Email"
                                   class="w-full bg-white border-none rounded-full py-2 pl-12 pr-4 shadow-sm focus:ring-4 focus:ring-red-200 transition-all placeholder-gray-400 text-gray-700">
                        </div>

                        {{-- Password Input --}}
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-red-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            </span>
                            <input id="password" name="password" type="password" required
                                   placeholder="Password"
                                   class="w-full bg-white border-none rounded-full py-2 pl-12 pr-4 shadow-sm focus:ring-4 focus:ring-red-200 transition-all placeholder-gray-400 text-gray-700">
                        </div>

                        {{-- Forgot Password --}}
                        <!-- <div class="text-right px-2">
                            <a href="#" class="text-xs text-red-600 hover:underline">Forgot your password?</a>
                        </div> -->

                        {{-- Login Button --}}
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-full font-bold text-lg shadow-xl shadow-red-200 active:scale-95 transition-all uppercase tracking-widest">
                            Login
                        </button>

                        {{-- Register Link --}}
                        <p class="text-center text-sm text-red-700 mt-6">
                            Belum punya akun? <br>
                            <a href="{{ route('pelanggan.register.form') }}" class="font-bold border-b-2 border-red-700 hover:text-red-800 transition-colors">
                                Daftar sekarang
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <x-footer />
</div>
@endsection