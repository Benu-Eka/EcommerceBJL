@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col font-sans">
    {{-- Navbar --}}
    <x-navbar />

    {{-- Konten Utama --}}
    <div class="flex-grow flex items-center justify-center py-8 px-4">
        {{-- Card Container Utama --}}
        <div class="max-w-4xl w-full bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-gray-100">
            
            {{-- Sisi Kiri: Branding --}}
            <div class="hidden md:flex md:w-1/3 p-8 flex-col justify-center items-center text-center bg-white border-r border-red-50">
                <div class="mb-6">
                    <h1 class="text-xl font-black text-red-600 tracking-tight leading-tight uppercase">
                        Toko <br> Berkah Jaya Lumintu
                    </h1>
                    <p class="text-gray-500 mt-1 text-xs font-medium">Solusi Belanja Terpercaya Anda</p>
                </div>

                <div class="relative w-full max-w-[180px] transition-transform hover:scale-105 duration-500">
                    <img src="{{ asset('build/assets/images/troli.png') }}"
                         alt="Register" class="w-full h-auto">
                </div>
                
                <!-- <div class="mt-6 space-y-2">
                    <div class="flex items-center text-[10px] text-gray-500 uppercase tracking-wider">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> Harga Grosir Terbaik
                    </div>
                    <div class="flex items-center text-[10px] text-gray-500 uppercase tracking-wider">
                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> Layanan Prioritas PIC
                    </div> -->
                <!-- </div> -->
            </div>

            {{-- Sisi Kanan: Form Register --}}
            <div class="w-full md:w-2/3 bg-[#fbcfe8] p-6 md:p-10 flex flex-col justify-center">
                <div class="w-full">
                    <div class="mb-6 text-center md:text-left">
                        <h2 class="text-xl font-extrabold text-red-600 uppercase tracking-widest">Registrasi Pelanggan</h2>
                        <div class="h-1 w-16 bg-red-600 mx-auto md:mx-0 mt-1 rounded-full"></div>
                    </div>

                    {{-- Alert error --}}
                    @if($errors->any())
                        <div class="mb-4 p-3 bg-red-600 text-white text-[11px] rounded-xl shadow-lg animate-pulse">
                            <strong>Oops!</strong> {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pelanggan.register') }}" class="space-y-3">
                        @csrf

                        {{-- Baris 1: Nama & Email --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="relative group">
                                <input id="nama_pelanggan" name="nama_pelanggan" type="text" value="{{ old('nama_pelanggan') }}" required 
                                       placeholder="Nama Lengkap"
                                       class="w-full bg-white border-none rounded-full py-2 px-5 shadow-sm focus:ring-4 focus:ring-red-200 transition-all placeholder-gray-400 text-gray-700 text-sm">
                            </div>
                            <div class="relative group">
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required 
                                       placeholder="Alamat Email"
                                       class="w-full bg-white border-none rounded-full py-2 px-5 shadow-sm focus:ring-4 focus:ring-red-200 transition-all placeholder-gray-400 text-gray-700 text-sm">
                            </div>
                        </div>

                        {{-- Baris 2: Password --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="relative group">
                                <input id="password" name="password" type="password" required 
                                       placeholder="Password"
                                       class="w-full bg-white border-none rounded-full py-2 px-5 shadow-sm focus:ring-4 focus:ring-red-200 transition-all placeholder-gray-400 text-gray-700 text-sm">
                            </div>
                            <div class="relative group">
                                <input id="password_confirmation" name="password_confirmation" type="password" required 
                                       placeholder="Konfirmasi Password"
                                       class="w-full bg-white border-none rounded-full py-2 px-5 shadow-sm focus:ring-4 focus:ring-red-200 transition-all placeholder-gray-400 text-gray-700 text-sm">
                            </div>
                        </div>

                        {{-- Baris 3: NPWP & PIC --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="relative group">
                                <input id="NPWP" name="NPWP" type="text" value="{{ old('NPWP') }}" 
                                       placeholder="Nomor NPWP (Opsional)"
                                       class="w-full bg-white border-none rounded-full py-2 px-5 shadow-sm focus:ring-4 focus:ring-red-200 transition-all placeholder-gray-400 text-gray-700 text-sm">
                            </div>
                            <div class="relative group">
                                <input id="PIC" name="PIC" type="text" value="{{ old('PIC') }}" required 
                                       placeholder="Nomor Kontak / PIC"
                                       class="w-full bg-white border-none rounded-full py-2 px-5 shadow-sm focus:ring-4 focus:ring-red-200 transition-all placeholder-gray-400 text-gray-700 text-sm">
                            </div>
                        </div>

                        {{-- Baris 4: Kategori Pelanggan --}}
                        <div class="relative group">
                            <select id="kategori_pelanggan_id" name="kategori_pelanggan_id" required
                                    class="w-full bg-white border-none rounded-full py-2 px-5 shadow-sm focus:ring-4 focus:ring-red-200 transition-all text-gray-700 text-sm appearance-none">
                                <option value="" class="text-gray-400">-- Pilih Kategori Pelanggan --</option>
                                @foreach($kategoriPelanggan as $k)
                                    <option value="{{ $k->kategori_pelanggan_id }}" {{ old('kategori_pelanggan_id') == $k->kategori_pelanggan_id ? 'selected' : '' }}>{{ $k->kategori_pelanggan }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-red-500">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                        </div>

                        {{-- Baris 5: Alamat --}}
                        <div class="relative">
                            <textarea id="alamat" name="alamat" rows="2" required 
                                      placeholder="Alamat Lengkap"
                                      class="w-full bg-white border-none rounded-2xl py-2 px-5 shadow-sm focus:ring-4 focus:ring-red-200 transition-all placeholder-gray-400 text-gray-700 text-sm">{{ old('alamat') }}</textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-full font-bold text-sm shadow-lg shadow-red-400/40 active:scale-95 transition-all uppercase tracking-widest">
                                Daftar Sekarang
                            </button>
                        </div>

                        <p class="text-center text-xs text-red-800 mt-4 font-medium">
                            Sudah punya akun? 
                            <a href="{{ route('pelanggan.login.form') }}" class="font-bold border-b border-red-600 hover:text-red-900 transition-all ml-1">
                                Login di sini
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