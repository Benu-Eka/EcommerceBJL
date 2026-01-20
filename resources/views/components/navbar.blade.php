@php
    $pelangganId = auth('pelanggan')->id();
    $cartTotal = 0;
    if ($pelangganId) {
        $cartTotal = \App\Models\Cart::where('pelanggan_id', $pelangganId)->sum('jumlah');
    }
    $current = Request::path();
@endphp

<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 shadow-2xl">
    <div class="bg-red-900 relative border-b border-white/10">
        
        {{-- Pola Batik Subtle --}}
        <div class="absolute inset-0 opacity-5 pointer-events-none" 
             style="background-image: url('{{ asset('build/assets/images/batik.png') }}'); background-size: 500px;">
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex items-center justify-between py-3">
                
                {{-- 1. MOBILE: Tombol Menu (Kiri) --}}
                <div class="flex md:hidden flex-1">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white p-2 focus:outline-none">
                        <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- DESKTOP KIRI: Search & Nav --}}
                <div class="hidden md:flex flex-1 items-center justify-start">
                    <form action="{{ route('product') }}" method="GET" class="hidden lg:flex items-center relative w-full max-w-[200px] xl:max-w-[260px] mr-4">
                        <input name="q" type="search" value="{{ request('q') }}" placeholder="Cari..." 
                            class="w-full bg-white/20 border border-white/10 text-white placeholder-white/70 rounded-full pl-9 pr-4 py-1.5 text-xs focus:outline-none focus:bg-white focus:text-red-900 transition duration-300">
                        <div class="absolute left-3 top-2 text-white/70">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </form>

                    <nav class="hidden md:flex items-center space-x-4 xl:space-x-6 flex-1 justify-end mr-4">
                        <a href="{{ route('kategori.index') }}" class="text-xs xl:text-sm font-bold uppercase tracking-widest transition-all {{ $current == 'home' ? 'text-white border-b-2 border-white' : 'text-red-100 hover:text-white' }} py-1">Home</a>
                        <a href="{{ route('product') }}" class="text-xs xl:text-sm font-bold uppercase tracking-widest transition-all {{ $current == 'product' ? 'text-white border-b-2 border-white' : 'text-red-100 hover:text-white' }} py-1">Produk</a>
                    </nav>
                </div>

                {{-- 2. TENGAH: Logo (Tetap di tengah di semua layar) --}}
                <div class="flex-shrink-0 z-20">
                    <a href="/" class="block bg-white p-1.5 md:p-2 rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('build/assets/images/Logo_fanjaya_1.png') }}" alt="Logo" class="h-10 md:h-14 w-auto">
                    </a>
                </div>

                {{-- 3. KANAN: Nav Kanan & Ikon --}}
                <div class="flex-1 flex items-center justify-end">
                    <nav class="hidden md:flex items-center space-x-4 xl:space-x-6 flex-1 justify-start ml-4">
                        <a href="/pesanan" class="text-xs xl:text-sm font-bold uppercase tracking-widest transition-all {{ $current == 'pesanan' ? 'text-white border-b-2 border-white' : 'text-red-100 hover:text-white' }} py-1">Transaksi</a>
                        <a href="/riwayat" class="text-xs xl:text-sm font-bold uppercase tracking-widest transition-all {{ $current == 'riwayat' ? 'text-white border-b-2 border-white' : 'text-red-100 hover:text-white' }} py-1">Riwayat</a>
                    </nav>

                    {{-- Ikon Grup (Selalu tampil) --}}
                    <div class="flex items-center space-x-1 sm:space-x-2 bg-black/10 p-1 rounded-full ml-2 border border-white/5">
                        <a href="{{ route('chat.index') }}" class="p-2 text-red-100 hover:text-white transition-colors relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.74 9.74 0 01-4-.84L3 20l1.28-3.84A8.94 8.94 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </a>
                        <a href="/cart" class="p-2 text-red-100 hover:text-white transition-colors relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            @if($cartTotal > 0)
                                <span class="absolute top-1 right-1 bg-white text-red-900 text-[8px] font-black h-3.5 w-3.5 rounded-full flex items-center justify-center">
                                    {{ $cartTotal }}
                                </span>
                            @endif
                        </a>
                        <a href="/profile" class="p-2 text-red-100 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- MOBILE DROPDOWN MENU --}}
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-cloak
             class="md:hidden bg-red-950 border-t border-white/10 px-6 py-4 space-y-4">
            
            {{-- Search Mobile --}}
            <form action="{{ route('product') }}" method="GET" class="relative w-full">
                <input name="q" type="search" placeholder="Cari bumbu..." class="w-full bg-white/10 border border-white/10 text-white rounded-lg py-2 pl-10 text-sm">
                <div class="absolute left-3 top-2.5 text-white/50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </form>

            {{-- Link Navigasi Mobile --}}
            <nav class="flex flex-col space-y-3">
                <a href="/home" class="text-white font-bold uppercase tracking-widest text-sm {{ $current == 'home' ? 'text-white' : 'text-red-200' }}">Home</a>
                <a href="/product" class="text-white font-bold uppercase tracking-widest text-sm {{ $current == 'product' ? 'text-white' : 'text-red-200' }}">Produk</a>
                <a href="/pesanan" class="text-white font-bold uppercase tracking-widest text-sm {{ $current == 'pesanan' ? 'text-white' : 'text-red-200' }}">Transaksi</a>
                <a href="/riwayat" class="text-white font-bold uppercase tracking-widest text-sm {{ $current == 'riwayat' ? 'text-white' : 'text-red-200' }}">Riwayat</a>
            </nav>
        </div>
    </div>
</header>

<style>
    [x-cloak] { display: none !important; }
</style>