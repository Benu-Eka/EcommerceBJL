@props(['categories'])
<div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 sticky top-24 transition-all duration-300">
    
    {{-- Tombol Filter (Mobile View) --}}
    <button type="button" onclick="document.getElementById('filter-content').classList.toggle('hidden'); document.getElementById('filter-content').classList.toggle('block');"
        class="lg:hidden w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-2xl mb-6 flex items-center justify-center shadow-lg shadow-red-100 transition-all active:scale-95">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6 6V19l-4 2v-8.293l-6-6A1 1 0 013 6V4z"></path>
        </svg>
        Filter Produk
    </button>
    
    <div id="filter-content" class="hidden lg:block">
        <form action="{{ route('product') }}" method="GET" id="filter-form">
            
            {{-- Preserve search & sort --}}
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}">
            @endif
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif

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
                        @foreach($categories as $cat)
                        @php
                            $isChecked = is_array(request('kategori')) && in_array($cat->kategori_barang_id, request('kategori'));
                        @endphp
                        <label class="group flex items-center justify-between p-3 rounded-2xl cursor-pointer transition-all border 
                            {{ $isChecked ? 'bg-red-50 border-red-100' : 'border-transparent hover:bg-gray-50 hover:border-gray-100' }}">
                            <div class="flex items-center">
                                <input type="checkbox" name="kategori[]" value="{{ $cat->kategori_barang_id }}"
                                    {{ $isChecked ? 'checked' : '' }}
                                    class="w-5 h-5 text-red-600 border-gray-200 rounded-lg focus:ring-transparent {{ $isChecked ? 'bg-white shadow-sm border-none' : 'bg-gray-50 group-hover:bg-white' }} transition-all">
                                <span class="ml-3 font-bold text-sm transition-all {{ $isChecked ? 'text-red-700' : 'text-gray-600 group-hover:text-gray-900' }}">
                                    {{ $cat->nama_kategori_barang }}
                                </span>
                            </div>
                            <span class="text-[10px] font-black transition-all {{ $isChecked ? 'bg-white px-2 py-1 rounded-md text-red-400' : 'text-gray-300 group-hover:text-gray-500' }}">
                                {{ $cat->barangs_count }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Filter Rentang Harga --}}
                <div class="pt-6 border-t border-gray-50">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Rentang Harga</h4>
                    <div class="flex items-center gap-3">
                        <div class="flex-1">
                            <input type="number" name="harga_min" value="{{ request('harga_min') }}" placeholder="Min"
                                class="w-full bg-gray-50 border-none rounded-xl py-3 px-4 text-sm font-bold text-gray-700 placeholder-gray-300 focus:ring-4 focus:ring-red-50 transition-all">
                        </div>
                        <span class="text-gray-300 font-bold text-sm">—</span>
                        <div class="flex-1">
                            <input type="number" name="harga_max" value="{{ request('harga_max') }}" placeholder="Max"
                                class="w-full bg-gray-50 border-none rounded-xl py-3 px-4 text-sm font-bold text-gray-700 placeholder-gray-300 focus:ring-4 focus:ring-red-50 transition-all">
                        </div>
                    </div>
                </div>

                {{-- Tombol Terapkan & Reset --}}
                <div class="pt-6 border-t border-gray-50 space-y-3">
                    <button type="submit" 
                        class="w-full py-3.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-red-100 transition-all active:scale-95">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('product') }}" 
                        class="block w-full py-3 text-center text-xs font-bold text-gray-400 hover:text-red-600 transition-colors uppercase tracking-widest">
                        Reset Filter
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>