<div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 sticky top-24 transition-all duration-300">
    
    {{-- Tombol Filter (Mobile View) --}}
    <button class="lg:hidden w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-2xl mb-6 flex items-center justify-center shadow-lg shadow-red-100 transition-all active:scale-95">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6 6V19l-4 2v-8.293l-6-6A1 1 0 013 6V4z"></path>
        </svg>
        Filter Produk
    </button>
    
    <div class="hidden lg:block">
        <h3 class="text-xl font-black text-gray-900 mb-6 flex items-center tracking-tight">
            <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6 6V19l-4 2v-8.293l-6-6A1 1 0 013 6V4z"></path>
                </svg>
            </div>
            Filter
        </h3>

        {{-- Kategori Produk --}}
        <div class="space-y-6">
            <div>
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Kategori Utama</h4>
                <div class="space-y-3">
                    
                    {{-- Item Kategori Aktif --}}
                    <label class="group flex items-center justify-between p-3 rounded-2xl bg-red-50 cursor-pointer transition-all border border-red-100">
                        <div class="flex items-center">
                            <input type="checkbox" class="w-5 h-5 text-red-600 border-none rounded-lg focus:ring-transparent bg-white shadow-sm" checked>
                            <span class="ml-3 font-bold text-red-700 text-sm">Sembako</span>
                        </div>
                        <span class="text-[10px] font-black bg-white px-2 py-1 rounded-md text-red-400">360</span>
                    </label>
                    
                    {{-- Item Kategori Standar --}}
                    @php
                        $categories = [
                            ['name' => 'Bumbu & Rempah', 'count' => 180],
                            ['name' => 'Bahan Kue', 'count' => 95],
                            ['name' => 'Minuman Serbuk', 'count' => 78],
                            ['name' => 'Saus & Kecap', 'count' => 52],
                            ['name' => 'Produk Instan', 'count' => 41]
                        ];
                    @endphp

                    @foreach($categories as $cat)
                    <label class="group flex items-center justify-between p-3 rounded-2xl hover:bg-gray-50 cursor-pointer transition-all border border-transparent hover:border-gray-100">
                        <div class="flex items-center">
                            <input type="checkbox" class="w-5 h-5 text-red-600 border-gray-200 rounded-lg focus:ring-transparent bg-gray-50 group-hover:bg-white transition-all">
                            <span class="ml-3 font-bold text-gray-600 group-hover:text-gray-900 text-sm transition-all">{{ $cat['name'] }}</span>
                        </div>
                        <span class="text-[10px] font-black text-gray-300 group-hover:text-gray-500 transition-all">{{ $cat['count'] }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Filter Tambahan Bisa Di Sini (Misal: Rentang Harga) --}}
            <div class="pt-6 border-t border-gray-50">
                <button type="reset" class="w-full py-3 text-xs font-bold text-gray-400 hover:text-red-600 transition-colors uppercase tracking-widest">
                    Reset Filter
                </button>
            </div>
        </div>
    </div>
</div>