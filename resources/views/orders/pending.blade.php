@extends('layouts.app')

@section('title', 'Pembayaran Pending | Gudang Bumbu & Sembako')

@section('content')
<x-navbar />

<div class="min-h-screen bg-[#f9fafb] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-white rounded-[3rem] shadow-2xl shadow-gray-200/50 p-10 text-center border border-gray-50 relative overflow-hidden">
        
        {{-- Dekorasi Latar Belakang --}}
        <div class="absolute top-0 left-0 w-full h-2 bg-yellow-500"></div>
        
        {{-- Ikon Pending --}}
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-yellow-50 rounded-full flex items-center justify-center animate-pulse">
                <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center shadow-lg shadow-yellow-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                        <circle cx="12" cy="12" r="9" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Teks Pesan --}}
        <h1 class="text-3xl font-black text-gray-900 leading-tight">
            Pembayaran <br> <span class="text-yellow-600">Sedang Diproses</span>
        </h1>
        
        <div class="mt-4 p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
            <p class="text-sm text-gray-600 leading-relaxed italic">
                "{{ $message ?? 'Pembayaran Anda telah kami terima dan sedang menunggu verifikasi.' }}"
            </p>
        </div>

        <p class="mt-6 text-gray-500 text-sm leading-relaxed">
            Mohon menunggu sebentar. <br>
            Status pesanan akan diperbarui setelah pembayaran diverifikasi oleh admin.
        </p>

        {{-- Tombol Aksi --}}
        <div class="mt-10 space-y-3">
            <a href="{{ route('orders.pending') }}" 
               class="flex items-center justify-center w-full py-4 bg-gray-900 hover:bg-black text-white font-bold rounded-2xl transition-all transform hover:-translate-y-1 active:scale-95 shadow-xl shadow-gray-200">
                Lihat Riwayat Pesanan
            </a>
            
            <a href="{{ url('/') }}" 
               class="flex items-center justify-center w-full py-4 bg-white border-2 border-gray-100 text-gray-600 font-bold rounded-2xl hover:bg-gray-50 transition-all">
                Ke Beranda
            </a>
        </div>

        {{-- Footer Kecil --}}
        <p class="mt-8 text-[10px] text-gray-400 uppercase tracking-[0.2em] font-bold">
            Gudang Bumbu & Sembako
        </p>
    </div>
</div>

<x-footer />
@endsection