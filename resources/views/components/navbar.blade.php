@php
    $pelangganId = auth('pelanggan')->id();
    $cartTotal = 0;
    if ($pelangganId) {
        $cartTotal = \App\Models\Cart::where('pelanggan_id', $pelangganId)->count('jumlah');
    }
@endphp

{{-- <header class="shadow-2xl sticky top-0 z-50 bg-gradient-to-t from-red-900 via-red-900 via-75% to-black relative"> --}}
<header class="shadow-2xl sticky top-0 z-50 bg-red-900 relative">
    <div class="absolute inset-0 z-0 opacity-5" 
        style="background-image: url('{{ asset('build/assets/images/batik.png') }}'); 
                background-size: 600px; 
                background-repeat: repeat;
                background-position: center; 
                background-blend-mode: overlay;
                pointer-events: none;
                filter: grayscale(100%);"> 
    </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">    
        {{-- Row Utama: Search | Logo/Brand | Ikon Navigasi --}}
        <div class="flex items-center py-4 border-b border-white border-opacity-20">            
            
            {{-- 1. Search Bar (KIRI) --}}
            {{-- <div class="w-1/3 flex justify-start pr-4">
                <form action="{{ route('product') }}" method="GET" class="relative w-full max-w-xs">
                    <input 
                        type="text" 
                        name="q"
                        placeholder="Cari produk atau bumbu..." 
                        value="{{ request('q') }}"
                        class="w-full py-2 px-4 border border-red-500 rounded-full text-gray-800 placeholder-gray-500 bg-white focus:outline-none focus:ring-2 focus:ring-red-300">
                    
                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div> --}}
            <div class="w-1/3 flex justify-start pr-4">
                <form action="{{ route('product') }}" method="GET" class="relative w-full max-w-xs">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Cari produk atau bumbu..." 
                    value="{{ request('q') }}" 
                    class="w-full py-2 px-4 border border-red-500 rounded-full text-gray-800 placeholder-gray-500 bg-white focus:outline-none focus:ring-2 focus:ring-red-300">
                <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>
            </div>


            {{-- 2. Logo dan Nama Brand (TENGAH) --}}
            <div class="w-1/3 flex justify-center">
                <a href="{{ url('/') }}" class="flex flex-col items-center">
                    <img src="{{ asset('build/assets/images/Logo_fanjaya_trans.png') }}" alt="Fanjaya Mulia Abadi" class="h-12 mb-1">
                </a>
            </div>

            {{-- 3. Ikon Navigasi (KANAN) --}}
            <div class="w-1/3 flex justify-end space-x-4">

                {{-- Ikon Chat --}}
                <a href="/chat" class="text-white hover:text-red-300 p-2 rounded-full transition duration-300 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.74 9.74 0 01-4-.84L3 20l1.28-3.84A8.94 8.94 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="absolute top-0 right-0 block h-3 w-3 rounded-full ring-2 ring-red-700 bg-white text-red-700 text-xs text-center leading-3"></span>
                </a>

                {{-- Ikon Keranjang --}}
                <a href="/cart" class="text-white hover:text-red-300 p-2 rounded-full transition duration-300 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span class="absolute top-0 right-0 block h-3 w-3 rounded-full ring-2 ring-red-700 bg-white text-red-700 text-xs text-center leading-3">{{ $cartTotal ?? 0 }}</span>
                </a>

                {{-- Ikon Favorit --}}
                {{-- <a href="/favorit" class="text-white hover:text-red-300 p-2 rounded-full transition duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </a> --}}
                
                {{-- Ikon Profil --}}
                <a href="/profile" class="text-white hover:text-red-300 p-2 rounded-full transition duration-300 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- MENU NAVIGASI --}}
        <nav class="hidden md:flex justify-center space-x-2 text-sm font-medium py-2">
            @php
                $current = Request::path();
            @endphp

            <a href="/home" 
               class="px-3 py-1 rounded-full transition-all duration-200 
               {{ $current == 'home' ? 'bg-white text-red-800 font-semibold shadow-md' : 'text-red-100 hover:bg-red-600 hover:text-white' }}">
               Home
            </a>

            <a href="/product" 
               class="px-3 py-1 rounded-full transition-all duration-200 
               {{ $current == 'product' ? 'bg-white text-red-800 font-semibold shadow-md' : 'text-red-100 hover:bg-red-600 hover:text-white' }}">
               Produk
            </a>

            <a href="/promo" 
               class="px-3 py-1 rounded-full transition-all duration-200 
               {{ $current == 'promo' ? 'bg-white text-red-800 font-semibold shadow-md' : 'text-red-100 hover:bg-red-600 hover:text-white' }}">
               Promo
            </a>

            <a href="/pesanan" 
               class="px-3 py-1 rounded-full transition-all duration-200 
               {{ $current == 'pesanan' ? 'bg-white text-red-800 font-semibold shadow-md' : 'text-red-100 hover:bg-red-600 hover:text-white' }}">
               Transaksi
            </a>

            <a href="/riwayat" 
               class="px-3 py-1 rounded-full transition-all duration-200 
               {{ $current == 'riwayat' ? 'bg-white text-red-800 font-semibold shadow-md' : 'text-red-100 hover:bg-red-600 hover:text-white' }}">
               Riwayat
            </a>
        </nav>
    </div>
</header>