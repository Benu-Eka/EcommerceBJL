<div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition duration-300 overflow-hidden">
    <div class="flex flex-col sm:flex-row items-center sm:items-start p-4 sm:p-6 gap-4">
        {{-- Gambar produk --}}
        <div class="w-24 h-24 flex-shrink-0 rounded-lg overflow-hidden bg-gray-50">
            <img src="{{ asset('images/products/' . ($order['image'] ?? 'default.png')) }}" alt="{{ $order['product_name'] ?? 'Produk' }}" class="w-full h-full object-contain">
        </div>

        {{-- Detail pesanan --}}
        <div class="flex-1 w-full">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-800 font-semibold text-base">{{ $order['product_name'] ?? 'Nama Produk' }}</h3>
                    <p class="text-gray-500 text-sm mt-1">Jumlah: {{ $order['quantity'] ?? 1 }}</p>
                    <p class="text-gray-500 text-sm">Tanggal: {{ $order['created_at'] ?? '-' }}</p>
                </div>
                <span class="text-sm font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                    {{ ucfirst(str_replace('_', ' ', $order['status'] ?? 'pending')) }}
                </span>
            </div>

            {{-- Total harga --}}
            <div class="mt-4 flex justify-between items-center">
                <div class="text-gray-700 font-bold text-lg">
                    Rp {{ number_format($order['total'] ?? 0, 0, ',', '.') }}
                </div>

                {{-- Tombol aksi berdasarkan status --}}
                @if(($order['status'] ?? '') === 'belum_bayar')
                    <button class="bg-red-500 text-white text-sm px-4 py-2 rounded-full hover:bg-red-600 transition">Bayar Sekarang</button>
                @elseif(($order['status'] ?? '') === 'dikirim')
                    <button class="bg-green-500 text-white text-sm px-4 py-2 rounded-full hover:bg-green-600 transition">Lacak</button>
                @elseif(($order['status'] ?? '') === 'selesai')
                    <button class="bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded-full cursor-default">Selesai</button>
                @elseif(($order['status'] ?? '') === 'dibatalkan')
                    <button class="bg-gray-200 text-gray-400 text-sm px-4 py-2 rounded-full cursor-default">Dibatalkan</button>
                @endif
            </div>
        </div>
    </div>
</div>
