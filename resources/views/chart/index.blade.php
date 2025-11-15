@extends('layouts.app')

@section('title', 'Keranjang Belanja Gudang Bumbu & Sembako')

@section('content')
<x-navbar />

<div class="min-h-screen bg-gray-50 py-6 px-4">
    <div class="mb-2 ml-20">
        <a href="{{ url()->previous() }}" 
           class="inline-flex items-center text-gray-600 hover:text-red-700 font-medium transition">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-3">Keranjang Belanja</h1>
    </div>

    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            {{-- BAGIAN KIRI - PRODUK DALAM KERANJANG --}}
            <div class="lg:col-span-2 bg-white rounded-xl shadow p-4">
                @if($cartItems->isEmpty())
                    <div class="text-center py-10">
                        <img src="https://cdn-icons-png.flaticon.com/512/1170/1170678.png" 
                             alt="empty cart" class="mx-auto w-24 opacity-60 mb-3">
                        <p class="text-gray-500 font-medium">Keranjang kamu masih kosong 😢</p>
                        <a href="/product" 
                           class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm">
                            Belanja Sekarang →
                        </a>
                    </div>
                @else
                    <table class="w-full border-collapse text-sm" id="cartTable">
                        <thead>
                            <tr class="text-left border-b text-gray-600">
                                <th class="py-2 w-8"></th>
                                <th class="py-2">Produk</th>
                                <th class="py-2">Harga</th>
                                <th class="py-2 text-center">Jumlah</th>
                                <th class="py-2 text-right">Total</th>
                                <th class="py-2 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($cartItems as $item)
                            @php
                                $itemTotal = $item->barang->harga_jual * $item->jumlah;
                            @endphp

                            <tr class="border-b hover:bg-gray-50 transition cart-row">

                                {{-- Checkbox memilih produk --}}
                                <td class="py-3 text-center">
                                    <input type="checkbox" 
                                           class="cart-check accent-green-600 w-4 h-4" 
                                           checked
                                           data-total="{{ $itemTotal }}">
                                </td>

                                {{-- Detail Produk --}}
                                <td class="py-3">
                                    <div class="flex gap-3 items-center">
                                        <img src="{{ asset($item->barang->foto_produk ?? 'images/no-image.png') }}" 
                                            alt="{{ $item->barang->nama_barang }}" 
                                            class="w-12 h-12 object-cover rounded-md border">

                                        <div>
                                            <p class="font-medium text-gray-800 text-sm">
                                                {{ $item->barang->nama_barang }}
                                            </p>
                                            <p class="text-xs text-gray-500 kode-barang">Kode: {{ $item->kode_barang }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Harga --}}
                                <td class="py-3 text-gray-700">
                                    Rp {{ number_format($item->barang->harga_jual, 0, ',', '.') }}
                                </td>

                                {{-- Jumlah --}}
                                <td class="py-3 text-center">
                                    <form action="{{ route('cart.update', $item->cart_id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')

                                        <div class="flex items-center justify-center border rounded-md w-fit text-sm mx-auto">
                                            <button type="submit" name="action" value="decrease"
                                                class="px-2 text-gray-600 hover:text-green-600 font-bold">−</button>

                                            <input type="text" name="jumlah" 
                                                value="{{ $item->jumlah }}" min="1"
                                                class="w-12 text-center border-x text-gray-700 font-semibold">

                                            <button type="submit" name="action" value="increase"
                                                class="px-2 text-gray-600 hover:text-green-600 font-bold">+</button>
                                        </div>
                                    </form>
                                </td>

                                {{-- Total harga per item --}}
                                <td class="py-3 text-right font-semibold text-gray-800 item-total"
                                    data-price="{{ $item->barang->harga_jual }}">
                                    Rp {{ number_format($itemTotal, 0, ',', '.') }}
                                </td>

                                {{-- Aksi Hapus --}}
                                <td class="py-3 text-right">
                                    <form action="{{ route('cart.destroy', $item->cart_id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                    </form>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- BAGIAN KANAN - RINGKASAN --}}
            <div class="bg-white rounded-xl shadow p-4 h-fit text-sm sticky top-4">
                <h2 class="text-base font-semibold mb-3 text-gray-800">Ringkasan Belanja</h2>

                <div class="space-y-2 text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Diskon (10%)</span>
                        <span class="text-green-600 font-semibold" id="discount">- Rp 0</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Biaya Pengiriman</span>
                        <span id="handling">Rp 5.000</span>
                    </div>

                    <hr class="my-2 border-gray-300">

                    <div class="flex justify-between font-semibold text-gray-800 text-base">
                        <span>Total Bayar</span>
                        <span id="totalBayar">Rp {{ number_format($subtotal + 5000, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- FORM CHECKOUT MENGIRIM ITEM TERPILIH --}}
                {{-- <form method="POST" action="{{ route('orders.checkout') }}" id="checkoutForm"> --}}
                <form action="{{ route('checkout.show') }}">
                    @csrf
                    <input type="hidden" name="selected_items" id="selectedItemsInput">
                    

                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition text-sm">
                        Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<x-footer />

{{-- SCRIPT UNTUK MENGHITUNG TOTAL + MENGIRIM ITEM KE CHECKOUT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    const checkboxes = document.querySelectorAll('.cart-check');
    const subtotalElem = document.getElementById('subtotal');
    const discountElem = document.getElementById('discount');
    const totalElem = document.getElementById('totalBayar');

    const HANDLING_FEE = 5000;
    const DISCOUNT_RATE = 0.10;

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function updateTotal() {
        let subtotal = 0;

        checkboxes.forEach(cb => {
            if (cb.checked) {
                subtotal += parseInt(cb.getAttribute('data-total'));
            }
        });

        const discount = subtotal * DISCOUNT_RATE;
        const totalBayar = subtotal - discount + HANDLING_FEE;

        subtotalElem.textContent = formatRupiah(subtotal);
        discountElem.textContent = '- ' + formatRupiah(discount);
        totalElem.textContent = formatRupiah(totalBayar);
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
    updateTotal();


    // SIAPKAN ITEM TERPILIH UNTUK DIKIRIM KE CHECKOUT
    const checkoutForm = document.getElementById('checkoutForm');
    const selectedItemsInput = document.getElementById('selectedItemsInput');

    checkoutForm.addEventListener('submit', function (e) {
        let selectedItems = [];

        document.querySelectorAll('.cart-row').forEach(function(row) {
            let cb = row.querySelector('.cart-check');

            if (!cb.checked) return;

            let kode = row.querySelector('.kode-barang').innerText.replace('Kode: ', '').trim();
            let qty = row.querySelector('input[name="jumlah"]').value;
            let harga = row.querySelector('.item-total').dataset.price;

            selectedItems.push({
                kode_barang: kode,
                qty: qty,
                harga: parseInt(harga)
            });
        });

        selectedItemsInput.value = JSON.stringify(selectedItems);
    });

});
</script>

@endsection
