@extends('layouts.app')

@section('title', 'Keranjang Belanja Gudang Bumbu & Sembako')

@section('content')
<x-navbar />

<div class="min-h-screen bg-[#f9fafb] py-10 px-4">
    <div class="max-w-6xl mx-auto">
        {{-- Header & Breadcrumb --}}
        <div class="mb-8">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center text-gray-500 hover:text-red-600 font-medium transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Belanja
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-4 tracking-tight">Keranjang Belanja</h1>
            <p class="text-gray-500 text-sm mt-1">Anda memiliki {{ $cartItems->count() }} item dalam keranjang.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- BAGIAN KIRI - DAFTAR PRODUK --}}
            <div class="lg:col-span-2 space-y-4">
                @if($cartItems->isEmpty())
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 text-center py-20">
                        <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Keranjang Anda Kosong</h2>
                        <p class="text-gray-500 mt-2">Sepertinya Anda belum menambahkan produk apapun.</p>
                        <a href="/product" 
                           class="inline-block mt-8 bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-2xl font-bold transition-all transform hover:scale-105 shadow-lg shadow-red-100">
                            Mulai Belanja Sekarang
                        </a>
                    </div>
                @else
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse" id="cartTable">
                            <thead>
                                <tr class="bg-gray-50/50 text-gray-400 text-[11px] uppercase tracking-widest font-bold border-b border-gray-100">
                                    <th class="py-4 px-6 text-center w-12">
                                        <input type="checkbox" id="checkAll" class="rounded border-gray-300 text-red-600 focus:ring-red-500 w-4 h-4" checked>
                                    </th>
                                    <th class="py-4 px-4">Produk</th>
                                    <th class="py-4 px-4">Harga</th>
                                    <th class="py-4 px-4 text-center">Jumlah</th>
                                    <th class="py-4 px-4 text-right">Subtotal</th>
                                    <th class="py-4 px-6"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($cartItems as $item)
                                @php $itemTotal = $item->barang->harga_jual * $item->jumlah; @endphp
                                <tr class="group hover:bg-gray-50/50 transition-colors duration-200 cart-row">
                                    <td class="py-6 px-6 text-center">
                                        <input type="checkbox" class="cart-check rounded border-gray-300 text-red-600 focus:ring-red-500 w-4 h-4" checked
                                               data-total="{{ $itemTotal }}" data-name="{{ $item->barang->nama_barang }}" data-qty="{{ $item->jumlah }}">
                                    </td>
                                    <td class="py-6 px-4">
                                        <div class="flex items-center gap-4">
                                            <div class="relative w-16 h-16 flex-shrink-0">
                                                <img src="{{ asset($item->barang->foto_produk ?? 'images/no-image.png') }}" 
                                                     class="w-full h-full object-cover rounded-2xl border border-gray-100 shadow-sm">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-gray-900 text-sm leading-tight hover:text-red-600 transition cursor-pointer">
                                                    {{ $item->barang->nama_barang }}
                                                </h3>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase mt-1 tracking-tighter">SKU: {{ $item->kode_barang }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6 px-4 text-sm font-medium text-gray-600">
                                        Rp {{ number_format($item->barang->harga_jual, 0, ',', '.') }}
                                    </td>
                                    <td class="py-6 px-4">
                                        <form action="{{ route('cart.update', $item->cart_id) }}" method="POST" class="flex justify-center">
                                            @csrf @method('PUT')
                                            <div class="flex items-center bg-gray-100 rounded-xl p-1 h-9">
                                                <button type="submit" name="action" value="decrease" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-white hover:text-red-600 rounded-lg transition font-bold">−</button>
                                                <input type="text" readonly name="jumlah" value="{{ $item->jumlah }}" class="w-10 bg-transparent text-center text-xs font-bold text-gray-800 border-none focus:ring-0">
                                                <button type="submit" name="action" value="increase" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-white hover:text-red-600 rounded-lg transition font-bold">+</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="py-6 px-4 text-right">
                                        <span class="text-sm font-bold text-gray-900">
                                            Rp {{ number_format($itemTotal, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="py-6 px-6 text-right">
                                        <form action="{{ route('cart.destroy', $item->cart_id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                            @csrf @method('DELETE')
                                            <button class="p-2 text-gray-300 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- BAGIAN KANAN - RINGKASAN --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 sticky top-10">
                    <h2 class="text-xl font-black text-gray-900 mb-6">Ringkasan Pesanan</h2>
                    
                    {{-- Dinamis List --}}
                    <div id="summaryList" class="space-y-4 mb-6 border-b border-gray-50 pb-6 max-h-48 overflow-y-auto custom-scrollbar">
                        {{-- Diisi oleh JS --}}
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between text-gray-500 font-medium">
                            <span>Subtotal</span>
                            <span id="subtotal" class="text-gray-900">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-gray-500 font-medium">
                            <span>Diskon Member (10%)</span>
                            <span id="discount" class="text-green-600">- Rp 0</span>
                        </div>
                        <div class="flex justify-between text-gray-500 font-medium">
                            <span>Biaya Pengiriman</span>
                            <span id="handling" class="text-gray-900">Rp 5.000</span>
                        </div>
                        
                        <div class="pt-4 mt-4 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-gray-900 font-bold text-lg">Total Akhir</span>
                            <span id="totalBayar" class="text-2xl font-black text-red-600 tracking-tight">Rp 0</span>
                        </div>
                    </div>

                    <form action="{{ route('orders.checkout') }}" class="mt-8">
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-red-100 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2 group">
                            Checkout Sekarang
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </form>

                    <div class="mt-6 flex items-center justify-center gap-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-4 opacity-30">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-6 opacity-30">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Logo_Gopay.svg" class="h-4 opacity-30">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-footer />

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #e2e2e2; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('.cart-check');
    const checkAll = document.getElementById('checkAll');
    const subtotalElem = document.getElementById('subtotal');
    const discountElem = document.getElementById('discount');
    const totalElem = document.getElementById('totalBayar');
    const summaryList = document.getElementById('summaryList');

    const HANDLING_FEE = 5000;
    const DISCOUNT_RATE = 0.1;

    function formatRupiah(angka) {
        return 'Rp ' + Math.floor(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function updateTotal() {
        let subtotal = 0;
        let htmlSummary = "";

        checkboxes.forEach(cb => {
            if (cb.checked) {
                const price = parseInt(cb.getAttribute('data-total'));
                const name = cb.getAttribute('data-name');
                const qty = cb.getAttribute('data-qty');
                subtotal += price;

                htmlSummary += `
                    <div class="flex justify-between items-start text-[13px] animate-fadeIn">
                        <span class="text-gray-600 pr-4">${name} <b class="text-gray-400">x${qty}</b></span>
                        <span class="text-gray-900 font-semibold flex-shrink-0">${formatRupiah(price)}</span>
                    </div>
                `;
            }
        });

        const discount = subtotal * DISCOUNT_RATE;
        const totalBayar = (subtotal > 0) ? (subtotal - discount + HANDLING_FEE) : 0;

        summaryList.innerHTML = htmlSummary || '<p class="text-gray-400 text-xs italic text-center py-4">Pilih produk untuk melihat ringkasan</p>';
        subtotalElem.textContent = formatRupiah(subtotal);
        discountElem.textContent = '- ' + formatRupiah(discount);
        totalElem.textContent = formatRupiah(totalBayar);
    }

    checkAll?.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateTotal();
    });

    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
    updateTotal();
});
</script>
@endsection