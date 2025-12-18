@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50"> {{-- Ubah background sedikit abu-abu --}}
        {{-- Navbar --}}
        <x-navbar />
        
        <main class="container mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-12">
            
            {{-- Bagian Filter dan Daftar Produk --}}
            <div class="flex flex-col lg:flex-row gap-8">
                
                {{-- Kolom Kiri: Filter (Sidebar) --}}
                <div class="w-full lg:w-1/4">
                    {{-- Asumsi x-sidebar-filter memiliki styling Tailwind yang baik --}}
                    <x-sidebar-filter /> 
                </div>

                {{-- Kolom Kanan: Daftar Produk --}}
                <div class="w-full lg:w-3/4">
                    
                    {{-- Header Hasil Pencarian dan Sort --}}
                    <div class="flex flex-wrap justify-between items-center mb-6 pb-3 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center space-x-4 text-sm text-gray-600 mb-2 sm:mb-0">
                            {{-- Tampilkan hasil pencarian --}}
                            @if(request('q')) 
                                <span class="text-sm text-gray-500 font-medium">
                                    Hasil untuk: 
                                    <span class="font-bold text-red-800 bg-red-100 px-2 py-0.5 rounded-md shadow-sm">
                                        "{{ request('q') }}"
                                    </span>
                                </span>
                            @endif
                            {{-- Angka ini dinamis dari Controller --}}
                            <span class="font-semibold text-gray-800 text-lg">
                                {{ $products->total() }} Hasil Ditemukan
                            </span>
                        </div>
                        
                        {{-- Dropdown Sort By (Menggunakan Form Sederhana) --}}
                        <div class="flex items-center space-x-2 text-sm">
                            <form action="{{ route('product') }}" method="GET" id="sort-form" class="flex items-center space-x-2">
                                {{-- Pertahankan query pencarian saat sorting --}}
                                @if(request('q')) 
                                    <input type="hidden" name="q" value="{{ request('q') }}">
                                @endif
                                <label for="sort" class="text-gray-600 font-medium">Urutkan:</label>
                                <select name="sort" id="sort" onchange="document.getElementById('sort-form').submit()"
                                    class="border border-gray-300 rounded-lg py-2 px-4 text-gray-700 bg-white shadow-sm hover:border-red-500 transition duration-150 focus:ring-red-500 focus:border-red-500 appearance-none cursor-pointer">
                                    
                                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga: Termurah</option>
                                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga: Termahal</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    {{-- Grid Produk DINAMIS --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
    
                    @forelse ($products as $product)
                        {{-- Hanya tampilkan jika status is_visible bernilai 1 --}}
                        @if($product->is_visible)
                            <x-product-card 
                                :kodeBarang="$product->kode_barang"
                                :name="$product->nama_barang"
                                :price="number_format($product->harga_jual, 0, ',', '.')"
                                :oldPrice="number_format($product->harga_beli, 0, ',', '.')"
                                :discount="$product->diskon ? 'Diskon ' . $product->diskon . '%' : null"
                                :image="$product->foto_produk"
                                :productLink="route('product.detail', $product->kode_barang)"
                            />
                        @endif
                    @empty
                        <div class="col-span-full text-center py-20 bg-white rounded-lg shadow-lg border border-gray-100">
                            <p class="text-2xl font-bold text-gray-700 mb-2">😭 Ups! Produk Tidak Ditemukan</p>
                            <p class="text-gray-500">Coba kata kunci lain atau periksa kembali ejaan Anda.</p>
                        </div>
                    @endforelse
                    
                </div>

                    {{-- Pagination --}}
                    <div class="mt-10 flex justify-center">
                        {{-- Laravel's pagination links should be styled with Tailwind if using custom views (vendor:publish) --}}
                        {{ $products->appends(['q' => request('q'), 'sort' => request('sort')])->links() }}
                    </div>
                    
                </div>
            </div>
            
        </main>
        <x-footer />
    </div>


@endsection