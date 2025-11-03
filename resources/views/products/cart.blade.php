@extends('layouts.app')

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif


@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-red-700 mb-6 border-b-2 border-red-700 pb-2">Keranjang Belanja Anda</h1>

        @if ($cartItems->isEmpty())
            {{-- Tampilan jika Keranjang Kosong --}}
            <div class="bg-gray-50 border border-gray-200 p-8 rounded-lg text-center shadow-md">
                <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <p class="text-xl font-semibold text-gray-700 mb-4">Keranjang Anda masih kosong.</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-red-700 hover:bg-red-800 text-white font-semibold py-2 px-6 rounded-full transition duration-300 shadow-md">
                    Mulai Belanja Sekarang
                </a>
            </div>
        @else
            {{-- Tampilan Keranjang dengan Item --}}
            <div class="flex flex-col lg:flex-row gap-8">
                
                {{-- Kiri: Daftar Produk (List Produk) --}}
                <div class="w-full lg:w-2/3 space-y-4">
                    @foreach ($cartItems as $item)
                        <div class="flex items-center bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-300">
                            
                            {{-- Checkbox dan Gambar Produk --}}
                            <input type="checkbox" name="selected_item[]" value="{{ $item->id }}" class="form-checkbox h-5 w-5 text-red-600 rounded mr-4 focus:ring-red-500">
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded mr-4 border border-gray-100">
                            
                            {{-- Detail Produk --}}
                            <div class="flex-grow">
                                <h2 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h2>
                                <p class="text-sm text-gray-500">@if($item->product->unit) Satuan: {{ $item->product->unit }} @endif</p>
                                <p class="text-md font-bold text-red-700 mt-1">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            {{-- Kuantitas dan Aksi --}}
                            <div class="flex items-center space-x-4">
                                {{-- Kuantitas --}}
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button class="w-8 h-8 text-gray-600 hover:bg-gray-100 rounded-l-lg" onclick="updateQuantity({{ $item->id }}, -1)">-</button>
                                    <input type="text" value="{{ $item->quantity }}" data-item-id="{{ $item->id }}" class="w-10 text-center border-y-0 border-x border-gray-300 focus:outline-none" readonly>
                                    <button class="w-8 h-8 text-gray-600 hover:bg-gray-100 rounded-r-lg" onclick="updateQuantity({{ $item->id }}, 1)">+</button>
                                </div>
                                
                                {{-- Subtotal --}}
                                <div class="text-right w-24 hidden sm:block">
                                    <p class="text-lg font-bold text-gray-800">
                                        Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </p>
                                </div>

                                {{-- Tombol Hapus --}}
                                <button class="text-gray-400 hover:text-red-600 p-2 rounded-full transition duration-300" onclick="removeItem({{ $item->id }})">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Kanan: Ringkasan Belanja (Checkout Summary) --}}
                <div class="w-full lg:w-1/3">
                    <div class="bg-gray-50 border border-red-200 p-6 rounded-lg shadow-lg sticky top-20">
                        <h2 class="text-xl font-bold text-red-700 mb-4">Ringkasan Belanja</h2>
                        
                        {{-- Detail Biaya --}}
                        <div class="space-y-2 text-gray-700 mb-4">
                            <div class="flex justify-between">
                                <span>Total Harga Produk ({{ $totalItems }} Item)</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Biaya Pengiriman</span>
                                <span>Gratis</span>
                            </div>
                            <div class="flex justify-between font-bold text-lg pt-2 border-t border-red-200">
                                <span>Total Pembayaran</span>
                                <span class="text-red-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        {{-- Tombol Checkout --}}
                        <button class="w-full bg-red-700 hover:bg-red-800 text-white font-bold py-3 rounded-lg transition duration-300 shadow-md">
                            Lanjut ke Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        // Fungsi dummy untuk AJAX, Anda perlu mengimplementasikannya
        function updateQuantity(itemId, change) {
            const input = document.querySelector(`input[data-item-id="${itemId}"]`);
            let newQuantity = parseInt(input.value) + change;
            
            if (newQuantity < 1) {
                newQuantity = 1; // Kuantitas minimum 1
            }
            
            input.value = newQuantity;
            // TODO: Tambahkan AJAX call ke server untuk memperbarui keranjang
            console.log(`Item ${itemId} diperbarui ke jumlah: ${newQuantity}`);
        }

        function removeItem(itemId) {
            if (confirm('Yakin ingin menghapus produk ini dari keranjang?')) {
                // TODO: Tambahkan AJAX call ke server untuk menghapus item
                console.log(`Item ${itemId} dihapus.`);
                // Setelah sukses, muat ulang halaman atau hapus elemen dari DOM
            }
        }
    </script>
@endsection