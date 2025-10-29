@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="min-h-screen bg-white font-inter">
    <x-navbar />

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-12">
        {{-- Tombol kembali dan judul --}}
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-red-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-3">Pesanan Saya</h1>
        </div>

        {{-- Tabs --}}
        <div class="bg-white rounded-2xl shadow-sm p-3 mb-6">
            <div class="flex flex-wrap gap-2 text-sm font-medium text-gray-700">
                <button data-tab="tab-belum-bayar" class="tab-btn active px-4 py-2 rounded-full text-red-700 bg-red-50 transition">Belum Bayar</button>
                <button data-tab="tab-dikemas" class="tab-btn px-4 py-2 rounded-full hover:bg-gray-100 transition">Dikemas</button>
                <button data-tab="tab-dikirim" class="tab-btn px-4 py-2 rounded-full hover:bg-gray-100 transition">Dikirim</button>
                <button data-tab="tab-selesai" class="tab-btn px-4 py-2 rounded-full hover:bg-gray-100 transition">Selesai</button>
                <button data-tab="tab-dibatalkan" class="tab-btn px-4 py-2 rounded-full hover:bg-gray-100 transition">Dibatalkan</button>
            </div>
        </div>

        {{-- Panels --}}
        <div class="space-y-6">
            {{-- BELUM BAYAR --}}
            <div id="tab-belum-bayar" class="tab-panel">
                @if(!empty($orders['belum_bayar']))
                    @foreach ($orders['belum_bayar'] as $order)
                        @include('components.order-card', ['order' => $order])
                    @endforeach
                @else
                    <p class="text-center text-gray-500 py-4">Tidak ada pesanan yang menunggu pembayaran.</p>
                @endif
            </div>

            {{-- DIKEMAS --}}
            <div id="tab-dikemas" class="tab-panel hidden">
                @if(!empty($orders['dikemas']))
                    @foreach ($orders['dikemas'] as $order)
                        @include('components.order-card', ['order' => $order])
                    @endforeach
                @else
                    <p class="text-center text-gray-500 py-4">Belum ada pesanan yang sedang dikemas.</p>
                @endif
            </div>

            {{-- DIKIRIM --}}
            <div id="tab-dikirim" class="tab-panel hidden">
                @if(!empty($orders['dikirim']))
                    @foreach ($orders['dikirim'] as $order)
                        @include('components.order-card', ['order' => $order])
                    @endforeach
                @else
                    <p class="text-center text-gray-500 py-4">Belum ada pesanan yang sedang dikirim.</p>
                @endif
            </div>

            {{-- SELESAI --}}
            <div id="tab-selesai" class="tab-panel hidden">
                @if(!empty($orders['selesai']))
                    @foreach ($orders['selesai'] as $order)
                        @include('components.order-card', ['order' => $order])
                    @endforeach
                @else
                    <p class="text-center text-gray-500 py-4">Belum ada pesanan yang selesai.</p>
                @endif
            </div>

            {{-- DIBATALKAN --}}
            <div id="tab-dibatalkan" class="tab-panel hidden">
                @if(!empty($orders['dibatalkan']))
                    @foreach ($orders['dibatalkan'] as $order)
                        @include('components.order-card', ['order' => $order])
                    @endforeach
                @else
                    <p class="text-center text-gray-500 py-4">Tidak ada pesanan yang dibatalkan.</p>
                @endif
            </div>
        </div>
    </main>

    <x-footer />
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');

    function activate(tabBtn) {
        tabs.forEach(b => b.classList.remove('bg-red-50', 'text-red-700'));
        tabBtn.classList.add('bg-red-50', 'text-red-700');

        panels.forEach(p => p.classList.add('hidden'));
        const id = tabBtn.getAttribute('data-tab');
        document.getElementById(id)?.classList.remove('hidden');
    }

    // Default aktif
    if (tabs.length) activate(tabs[0]);

    tabs.forEach(btn => {
        btn.addEventListener('click', () => activate(btn));
    });
});
</script>
@endsection
