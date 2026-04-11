@extends('layouts.app')

@section('title', 'Keranjang Belanja Gudang Bumbu & Sembako')

@section('content')
<x-navbar />

<div class="min-h-screen bg-[#f9fafb] py-10 px-4">
    <div class="max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center text-gray-500 hover:text-red-600 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Belanja
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-4">Keranjang Belanja</h1>
            <p class="text-gray-500 text-sm mt-1">
                Anda memiliki {{ $cartItems->count() }} item dalam keranjang.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KIRI --}}
            <div class="lg:col-span-2 space-y-4">
                @if($cartItems->isEmpty())
                    <div class="bg-white rounded-3xl shadow-sm border text-center py-20">
                        <h2 class="text-xl font-bold text-gray-800">Keranjang Kosong</h2>
                        <a href="/product"
                           class="inline-block mt-8 bg-red-600 text-white px-8 py-3 rounded-2xl font-bold">
                            Mulai Belanja
                        </a>
                    </div>
                @else
                    <div class="bg-white rounded-3xl shadow-sm border overflow-hidden">
                        <table class="w-full text-left" id="cartTable">
                            <thead>
                                <tr class="bg-gray-50 text-gray-400 text-xs uppercase font-bold">
                                    <th class="py-4 px-6 text-center">
                                        <input type="checkbox" id="checkAll" checked>
                                    </th>
                                    <th class="py-4 px-4">Produk</th>
                                    <th class="py-4 px-4">Harga</th>
                                    <th class="py-4 px-4 text-center">Jumlah</th>
                                    <th class="py-4 px-4 text-right">Subtotal</th>
                                    <th class="py-4 px-6"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y">
                                @foreach ($cartItems as $item)
                                @php
                                    $barang = $item->barang;
                                    $harga = $barang->harga_jual ?? 0;
                                    $nama = $barang->nama_barang ?? 'Produk tidak tersedia';
                                    $foto = $barang->foto_produk ?? 'images/no-image.png';
                                    $itemTotal = $harga * $item->jumlah;
                                @endphp

                                <tr class="cart-row">
                                    <td class="py-6 px-6 text-center">
                                        <input type="checkbox"
                                               class="cart-check"
                                               checked
                                               data-total="{{ $itemTotal }}"
                                               data-name="{{ $nama }}"
                                               data-qty="{{ $item->jumlah }}">
                                    </td>

                                    <td class="py-6 px-4">
                                        <div class="flex items-center gap-4">
                                            <img src="{{ asset('build/assets/' . $foto) }}"
                                                 class="w-16 h-16 object-cover rounded-xl border">
                                            <div>
                                                <h3 class="font-bold text-sm text-gray-900">
                                                    {{ $nama }}
                                                </h3>
                                                @if(!$barang)
                                                    <span class="text-xs text-red-500 font-semibold">
                                                        Produk sudah tidak tersedia
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-6 px-4 text-sm text-gray-600">
                                        Rp {{ number_format($harga, 0, ',', '.') }}
                                    </td>

                                    <td class="py-6 px-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('cart.update', $item->cart_id) }}" method="POST" class="inline">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit" class="w-8 h-8 bg-gray-200 text-gray-600 rounded-full hover:bg-gray-300 flex items-center justify-center">-</button>
                                            </form>
                                            <span class="mx-2">{{ $item->jumlah }}</span>
                                            <form action="{{ route('cart.update', $item->cart_id) }}" method="POST" class="inline">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit" class="w-8 h-8 bg-gray-200 text-gray-600 rounded-full hover:bg-gray-300 flex items-center justify-center">+</button>
                                            </form>
                                        </div>
                                    </td>

                                    <td class="py-6 px-4 text-right font-bold">
                                        Rp {{ number_format($itemTotal, 0, ',', '.') }}
                                    </td>

                                    <td class="py-6 px-6 text-right">
                                        <form action="{{ route('cart.destroy', $item->cart_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Hapus item ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- KANAN --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm border p-8 sticky top-10">
                    <h2 class="text-xl font-black mb-6">Ringkasan Pesanan</h2>

                    <div id="summaryList" class="space-y-3 mb-6"></div>

                    {{-- Badge kategori pelanggan --}}
                    @if($diskonPersen > 0)
                    <div class="mb-4 px-4 py-2.5 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span class="text-green-700 text-xs font-bold">Member {{ $kategoriNama }} — Diskon {{ (int)$diskonPersen }}%</span>
                    </div>
                    @endif

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-green-600">
                            <span>Diskon {{ $kategoriNama }} ({{ (int)$diskonPersen }}%)</span>
                            <span id="discount">- Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkir</span>
                            <span>Rp 5.000</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg border-t pt-4">
                            <span>Total</span>
                            <span id="totalBayar" class="text-red-600">Rp 0</span>
                        </div>
                    </div>

                    <form action="{{ route('orders.checkout') }}" class="mt-8">
                        <button type="submit"
                                class="w-full bg-red-600 text-white py-4 rounded-xl font-bold">
                            Checkout
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<x-footer />

<script>
document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('.cart-check');
    const subtotalElem = document.getElementById('subtotal');
    const discountElem = document.getElementById('discount');
    const totalElem = document.getElementById('totalBayar');

    const HANDLING = 5000;
    const DISCOUNT = {{ $diskonPersen }} / 100; // Diskon dinamis dari kategori pelanggan

    function formatRupiah(n) {
        return 'Rp ' + Math.floor(n).toLocaleString('id-ID');
    }

    function updateTotal() {
        let subtotal = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) subtotal += parseInt(cb.dataset.total);
        });

        const discount = subtotal * DISCOUNT;
        const total = subtotal > 0 ? subtotal - discount + HANDLING : 0;

        subtotalElem.textContent = formatRupiah(subtotal);
        discountElem.textContent = '- ' + formatRupiah(discount);
        totalElem.textContent = formatRupiah(total);
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
    updateTotal();
});
</script>
@endsection
