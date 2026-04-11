@extends('layouts.app')

@section('title', 'Saldo Saya')

@section('content')
<div class="min-h-screen bg-[#f9fafb]">
    <x-navbar />

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-16">

        <div class="mb-8">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-500 hover:text-red-700 font-medium transition-colors duration-200 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-black text-gray-900 mt-3 tracking-tight">Saldo Saya</h1>
            <p class="text-sm text-gray-400 mt-1">Kelola saldo dan lihat riwayat transaksi saldo Anda</p>
        </div>

        {{-- Kartu Saldo --}}
        <div class="bg-gradient-to-br from-red-600 via-red-700 to-red-900 rounded-3xl p-6 md:p-8 text-white shadow-xl mb-8 relative overflow-hidden">
            {{-- Background pattern --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full border-4 border-white"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full border-4 border-white"></div>
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-red-100 font-medium">Total Saldo</p>
                        <p class="text-xs text-red-200">{{ $pelanggan->nama_pelanggan }}</p>
                    </div>
                </div>
                <p class="text-4xl md:text-5xl font-black tracking-tight">
                    Rp {{ number_format($pelanggan->saldo ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-xs text-red-200 mt-3">
                    Saldo dapat digunakan untuk pembayaran pesanan berikutnya
                </p>
            </div>
        </div>

        {{-- Alert sukses --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Riwayat Transaksi Saldo --}}
        <div class="mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-gray-900">Riwayat Transaksi Saldo</h2>
                    <p class="text-xs text-gray-400">Semua mutasi saldo Anda</p>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            @forelse ($transactions as $trx)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center justify-between hover:shadow-md transition">
                    {{-- Kiri: Icon + Info --}}
                    <div class="flex items-center gap-4">
                        @if($trx->tipe === 'refund')
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </div>
                        @endif

                        <div>
                            <p class="font-bold text-sm text-gray-800">
                                {{ $trx->tipe === 'refund' ? 'Refund Diterima' : 'Penggunaan Saldo' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $trx->keterangan }}</p>
                            <p class="text-xs text-gray-300 mt-1">{{ $trx->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    {{-- Kanan: Jumlah --}}
                    <div class="text-right flex-shrink-0 ml-4">
                        <p class="font-extrabold text-sm {{ $trx->tipe === 'refund' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trx->tipe === 'refund' ? '+' : '-' }} Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                        </p>
                        <p class="text-[10px] text-gray-400 mt-1">
                            Saldo: Rp {{ number_format($trx->saldo_sesudah, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-[3rem] border border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-black text-gray-900">Belum Ada Transaksi</h2>
                    <p class="text-gray-400 text-sm mt-2">Riwayat transaksi saldo akan muncul di sini.</p>
                </div>
            @endforelse
        </div>
    </main>

    <x-footer />
</div>
@endsection
