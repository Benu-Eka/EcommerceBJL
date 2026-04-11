@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f8fafc] flex flex-col font-sans">
    {{-- Navbar --}}
    <x-navbar />

    <div class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full">
            
            {{-- Header & Back Button --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-6 gap-4">
                <div>
                    <a href="{{ url('/') }}" class="group inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-600 transition-all duration-300">
                        <div class="p-2 bg-white rounded-lg shadow-sm group-hover:shadow-md group-hover:-translate-x-1 transition-all mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </div>
                        Kembali ke Beranda
                    </a>
                    <h1 class="text-3xl font-black text-gray-900 mt-4 tracking-tight">Akun <span class="text-red-600">Saya</span></h1>
                </div>
                <!-- <div class="hidden md:block">
                    <span class="px-4 py-2 bg-red-50 text-red-600 text-xs font-bold uppercase tracking-widest rounded-full border border-red-100">
                        Status: Aktif
                    </span>
                </div> -->
            </div>

            {{-- Main Profile Card --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                <div class="flex flex-col md:flex-row">
                    
                    {{-- Sisi Kiri: Visual/Avatar --}}
                    <div class="md:w-1/3 bg-gradient-to-br from-red-600 to-red-700 p-10 flex flex-col items-center justify-center text-white relative overflow-hidden">
                        {{-- Ornamen Dekoratif --}}
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-red-900/20 rounded-full blur-2xl"></div>
                        
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pelanggan->nama_pelanggan) }}&background=ffffff&color=dc2626&size=128"
                                 alt="Avatar"
                                 class="h-32 w-32 rounded-3xl object-cover border-4 border-white/30 shadow-2xl transition-transform hover:scale-105 duration-500">
                            <div class="absolute -bottom-2 -right-2 bg-green-500 border-4 border-red-600 w-8 h-8 rounded-full flex items-center justify-center" title="Online">
                                <div class="w-2 h-2 bg-white rounded-full animate-ping"></div>
                            </div>
                        </div>
                        
                        <h3 class="mt-6 font-bold text-xl text-center leading-tight">{{ $pelanggan->nama_pelanggan ?? 'Member' }}</h3>
                        <p class="text-red-100 text-sm opacity-80">{{ $pelanggan->kategoriPelanggan->kategori_pelanggan ?? 'Customer' }}</p>
                    </div>

                    {{-- Sisi Kanan: Detail --}}
                    <div class="md:w-2/3 p-8 md:p-12">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                            
                            {{-- Info Item --}}
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase tracking-[0.15em] font-bold text-gray-400">Email Utama</label>
                                <p class="text-gray-800 font-semibold truncate">{{ $pelanggan->email ?? '-' }}</p>
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] uppercase tracking-[0.15em] font-bold text-gray-400">NPWP</label>
                                <p class="text-gray-800 font-semibold">{{ $pelanggan->NPWP ?? '-' }}</p>
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] uppercase tracking-[0.15em] font-bold text-gray-400">Penanggung Jawab (PIC)</label>
                                <div class="flex items-center text-gray-800 font-semibold">
                                    <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    {{ $pelanggan->PIC ?? '-' }}
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-[10px] uppercase tracking-[0.15em] font-bold text-gray-400">Sejak Tanggal</label>
                                <p class="text-gray-800 font-semibold">{{ $pelanggan->created_at ? $pelanggan->created_at->format('d M, Y') : '-' }}</p>
                            </div>

                            <div class="sm:col-span-2 space-y-1">
                                <label class="text-[10px] uppercase tracking-[0.15em] font-bold text-gray-400">Alamat Pengiriman</label>
                                <p class="text-gray-700 leading-relaxed font-medium bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                    {{ $pelanggan->alamat ?? '-' }}
                                </p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-10 pt-8 border-t border-gray-100 flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('profile.edit') }}"
                               class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-red-200 transition-all hover:-translate-y-1 active:scale-95">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5l3 3L12 15l-3.5.5.5-3.5L18.5 2.5z"/></svg>
                                Perbarui Profil
                            </a>

                            <form action="{{ route('pelanggan.logout') }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 border-2 border-gray-200 bg-white text-gray-600 text-sm font-bold rounded-2xl hover:bg-gray-50 hover:border-gray-300 transition-all active:scale-95">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/></svg>
                                    Keluar Sesi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Saldo Card --}}
    <div class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-gradient-to-br from-red-600 via-red-700 to-red-900 rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full border-4 border-white"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full border-4 border-white"></div>
            </div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <p class="text-sm text-red-100 font-medium">Saldo Anda</p>
                    </div>
                    <p class="text-3xl md:text-4xl font-black tracking-tight">
                        Rp {{ number_format($pelanggan->saldo ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <a href="{{ route('orders.saldo') }}" 
                   class="inline-flex items-center justify-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white font-bold text-sm px-6 py-3 rounded-2xl transition-all border border-white/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Lihat Riwayat Saldo
                </a>
            </div>
        </div>
    </div>

    <x-footer />
</div>
@endsection