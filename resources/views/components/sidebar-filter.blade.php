<div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 sticky top-20">
    
    {{-- Tombol Filter (Mobile View) --}}
    <button class="lg:hidden w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg mb-4 flex items-center justify-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6 6V19l-4 2v-8.293l-6-6A1 1 0 013 6V4z"></path></svg>
        Filter
    </button>
    
    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6 6V19l-4 2v-8.293l-6-6A1 1 0 013 6V4z"></path></svg>
        Filter
    </h3>

    {{-- Kategori Produk --}}
    <div class="mb-6 border-b pb-4 border-gray-200">
        <h4 class="text-md font-semibold text-gray-800 mb-3 uppercase tracking-wider">Semua Kategori</h4>
        <div class="space-y-2">
            
            <label class="flex items-center text-sm text-gray-700 cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" checked>
                <span class="ml-2 font-semibold text-green-600">Sembako <span class="text-gray-500">(360)</span></span>
            </label>
            
            <label class="flex items-center text-sm text-gray-700 cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <span class="ml-2">Bumbu Dasar & Rempah <span class="text-gray-500">(180)</span></span>
            </label>
            
            <label class="flex items-center text-sm text-gray-700 cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <span class="ml-2">Bahan Kue & Roti <span class="text-gray-500">(95)</span></span>
            </label>
            
            <label class="flex items-center text-sm text-gray-700 cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <span class="ml-2">Minuman Serbuk & Bubuk <span class="text-gray-500">(78)</span></span>
            </label>
            
            <label class="flex items-center text-sm text-gray-700 cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <span class="ml-2">Saus & Kecap <span class="text-gray-500">(52)</span></span>
            </label>
            
            <label class="flex items-center text-sm text-gray-700 cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <span class="ml-2">Produk Instan <span class="text-gray-500">(41)</span></span>
            </label>

            <label class="flex items-center text-sm text-gray-700 cursor-pointer">
                <input type="checkbox" class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                <span class="ml-2">Perlengkapan Dapur <span class="text-gray-500">(20)</span></span>
            </label>    
        </div>
    </div>

    {{-- Filter Harga --}}
    <div class="mb-6">
        <h4 class="text-md font-semibold text-gray-800 mb-4 uppercase tracking-wider">Harga</h4>
        
        {{-- Range Slider Placeholder (Memerlukan JS untuk berfungsi dinamis) --}}
        <div class="px-2">
            <input type="range" min="0" max="200000" value="100000" class="w-full h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer range-lg focus:outline-none">
        </div>
        
        <p class="text-sm text-gray-500 mt-3">Rentang Harga: <span class="font-medium text-gray-800">Rp 0 - Rp 200.000</span></p>
    </div>

</div>