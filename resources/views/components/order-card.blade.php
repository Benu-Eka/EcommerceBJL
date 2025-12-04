<div class="bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden p-5 sm:p-6 mb-4">
    <div class="flex flex-col sm:flex-row items-start gap-4">
        {{-- Gambar produk --}}
        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
            <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7 19h10V4H7v15zm-5-2h4V6H2v11zM18 6v11h4V6h-4z"/>
            </svg>
        </div>

        {{-- Detail pesanan utama --}}
        <div class="flex-1 w-full">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-3 mb-3">
                {{-- Info Dasar --}}
                <div class="mb-2 sm:mb-0">
                    <h3 class="text-gray-800 font-bold text-lg leading-tight">{{ $order['midtrans_order_id'] ?? 'Order ID Tidak Tersedia' }}</h3>
                    <p class="text-gray-500 text-sm mt-1">
                        <span class="font-medium text-gray-600">{{ $order->items()->count() }}</span> Produk
                        <span class="mx-2 text-gray-300">|</span>
                        Tanggal: {{ $order['created_at'] ?? '-' }}
                    </p>
                </div>

                {{-- Status Pembayaran --}}
                <span class="text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap
                    @php
                        $status = strtolower($order['status'] ?? 'pending');
                        if ($status === 'belum_bayar') {
                            echo 'text-yellow-700 bg-yellow-100';
                        } elseif (in_array($status, ['dikirim', 'diproses'])) {
                            echo 'text-blue-700 bg-blue-100';
                        } elseif ($status === 'selesai') {
                            echo 'text-green-700 bg-green-100';
                        } elseif (in_array($status, ['dibatalkan', 'gagal'])) {
                            echo 'text-red-700 bg-red-100';
                        } else {
                            echo 'text-gray-700 bg-gray-100';
                        }
                    @endphp
                ">
                    {{ ucfirst(str_replace('_', ' ', $order['status'] ?? 'Pending')) }}
                </span>
            </div>

            {{-- Total harga & Aksi --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pt-2">
                {{-- Total Harga --}}
                <div class="text-gray-900 font-extrabold text-xl mb-3 sm:mb-0">
                    Total: Rp {{ number_format($order['total'] ?? 0, 0, ',', '.') }}
                </div>

                {{-- Tombol aksi berdasarkan status --}}
                <div class="flex flex-col sm:flex-row gap-2">
                    @if(($order['status'] ?? '') === 'belum_bayar')
                        <button class="w-full sm:w-auto bg-blue-600 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-blue-700 transition shadow-md">Bayar Sekarang</button>
                    @elseif(($order['status'] ?? '') === 'dikirim')
                        <button class="w-full sm:w-auto bg-green-600 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-green-700 transition shadow-md">Lacak Pesanan</button>
                    @elseif(($order['status'] ?? '') === 'selesai')
                        <button class="w-full sm:w-auto bg-gray-200 text-gray-700 text-sm font-medium px-5 py-2 rounded-lg cursor-default">Pesanan Selesai</button>
                    @elseif(($order['status'] ?? '') === 'dibatalkan')
                        <button class="w-full sm:w-auto bg-red-100 text-red-700 text-sm font-medium px-5 py-2 rounded-lg cursor-default">Dibatalkan</button>
                    @endif

                    {{-- Link Detail (Selalu ada) --}}
                    <a href="{{ route('orders.show', $order->order_id) }}"
                       class="w-full sm:w-auto text-blue-600 font-medium text-sm px-5 py-2 border border-blue-600 rounded-lg hover:bg-blue-50 transition text-center">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>