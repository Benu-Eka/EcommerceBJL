@extends('layouts.app')

@section('title', 'Katalog Produk | Gudang Bumbu & Sembako')

@section('content')
<div class="min-h-screen bg-[#f9fafb]"> {{-- Warna background premium --}}
    <x-navbar />
    
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-16">
        
        <!-- {{-- Tombol Kembali Konsisten --}}
        <div class="mb-6">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center text-gray-500 hover:text-red-700 font-medium transition-colors duration-200 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Beranda
            </a>
        </div> -->

        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- KOLOM KIRI: FILTER (SIDEBAR) --}}
            <aside class="w-full lg:w-1/4">
                <div class="sticky top-24">
                    <x-sidebar-filter :categories="$categories" /> 
                </div>
            </aside>

            {{-- KOLOM KANAN: DAFTAR PRODUK --}}
            <div class="w-full lg:w-3/4">
                
                {{-- Header Katalog & Sort --}}
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 mb-8 flex flex-wrap justify-between items-center gap-4">
                    <div class="flex flex-col">
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">Katalog Produk</h1>
                        <div class="flex items-center gap-2 mt-1">
                            @if(request('q')) 
                                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-lg uppercase tracking-wider">
                                    "{{ request('q') }}"
                                </span>
                            @endif
                            <span class="text-xs text-gray-400 font-bold uppercase tracking-widest">
                                {{ $products->total() }} Produk Tersedia
                            </span>
                        </div>
                    </div>
                    
                    {{-- Dropdown Sort By --}}
                    <form action="{{ route('product') }}" method="GET" id="sort-form" class="relative group">
                        @if(request('q')) 
                            <input type="hidden" name="q" value="{{ request('q') }}">
                        @endif
                        @if(is_array(request('kategori')))
                            @foreach(request('kategori') as $kat)
                                <input type="hidden" name="kategori[]" value="{{ $kat }}">
                            @endforeach
                        @endif
                        @if(request('harga_min'))
                            <input type="hidden" name="harga_min" value="{{ request('harga_min') }}">
                        @endif
                        @if(request('harga_max'))
                            <input type="hidden" name="harga_max" value="{{ request('harga_max') }}">
                        @endif
                        <select name="sort" id="sort" onchange="this.form.submit()"
                            class="appearance-none bg-gray-50 border-none rounded-2xl py-3 pl-5 pr-12 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-red-50 transition-all cursor-pointer">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                            <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Termahal</option>
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400 group-hover:text-red-500 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </form>
                </div>

                {{-- GRID PRODUK --}}
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                    @forelse ($products as $product)
                        @if($product->is_visible)
                            <div class="transform transition-all duration-300 hover:-translate-y-2">
                                <x-product-card 
                                    :kodeBarang="$product->kode_barang"
                                    :name="$product->nama_barang"
                                    :price="number_format($product->harga_jual, 0, ',', '.')"
                                    :oldPrice="number_format($product->harga_beli, 0, ',', '.')"
                                    :discount="$product->diskon ? $product->diskon . '%' : null"
                                    :image="$product->foto_produk"
                                    :productLink="route('product.detail', $product->kode_barang)"
                                />
                            </div>
                        @endif
                    @empty
                        <div class="col-span-full text-center py-24 bg-white rounded-[3rem] border border-dashed border-gray-200">
                            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-black text-gray-900">Produk Tidak Ditemukan</h2>
                            <p class="text-gray-400 text-sm mt-2">Coba gunakan kata kunci lain atau periksa filter Anda.</p>
                            <a href="{{ route('product') }}" class="inline-block mt-6 text-red-600 font-bold border-b-2 border-red-600 pb-1 hover:text-red-800 transition">Lihat Semua Produk</a>
                        </div>
                    @endforelse
                </div>

                {{-- PAGINATION --}}
                <div class="mt-16 flex justify-center">
                    <div class="bg-white px-6 py-4 rounded-3xl shadow-sm border border-gray-100">
                        {{ $products->appends(['q' => request('q'), 'sort' => request('sort'), 'kategori' => request('kategori'), 'harga_min' => request('harga_min'), 'harga_max' => request('harga_max')])->links() }}
                    </div>
                </div>
                
            </div>
        </div>
    </main>
    <x-footer />
</div>

<style>
    /* Menghilangkan scrollbar pada pagination jika terlalu lebar di mobile */
    .pagination { display: flex; gap: 0.5rem; }
    /* Styling select untuk menghilangkan default arrow di beberapa browser */
    select { -webkit-appearance: none; -moz-appearance: none; appearance: none; }
</style>
@endsection