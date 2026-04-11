<div class="bg-white border border-gray-200 rounded-xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden p-5 sm:p-6 mb-4">
    <div class="flex flex-col sm:flex-row items-start gap-4">
        {{-- Gambar produk --}}
        <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
            @php
                $firstItem = $order->items->first();
                $image = $firstItem && $firstItem->barang && $firstItem->barang->foto_produk
                    ? asset('build/assets/' . $firstItem->barang->foto_produk)
                    : 'https://via.placeholder.com/80x80?text=Produk';
            @endphp
            <img src="{{$image }}" alt="Gambar Produk" class="w-full h-full object-cover">
        </div>

        {{-- Detail pesanan utama --}}
        <div class="flex-1 w-full">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-3 mb-3">
                {{-- Info Dasar --}}
                <div class="mb-2 sm:mb-0">
                    <h3 class="text-gray-800 font-bold text-lg leading-tight">{{ $order['order_id'] ?? 'Order ID Tidak Tersedia' }}</h3>
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
                        } elseif ($status === 'dibayar') {
                            echo 'text-green-700 bg-green-100';
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
                    @if(($order['status'] ?? '') === 'pending')
                        <form action="{{ route('orders.cancel', $order->order_id) }}" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-5 py-2 rounded-lg transition shadow-md">
                                ❌ Batalkan Pesanan
                            </button>
                        </form>
                    @elseif(($order['status'] ?? '') === 'dibayar')
                        @if($order['cancel_requested'] ?? 0)
                            <span class="w-full sm:w-auto bg-red-100 text-red-700 text-sm font-medium px-5 py-2 rounded-lg text-center shadow-inner cursor-wait border border-red-200">
                                ⏳ Menunggu Konfirmasi Batal
                            </span>
                        @else
                            <form action="{{ route('orders.cancel', $order->order_id) }}" method="POST"
                                  onsubmit="return confirm('Ajukan pembatalan pesanan ini ke admin? Dana akan dikembalikan ke saldo setelah disetujui.')">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-5 py-2 rounded-lg transition shadow-md">
                                    ❌ Ajukan Batal & Refund
                                </button>
                            </form>
                        @endif
                    @elseif(($order['status'] ?? '') === 'dikemas')
                        <span class="w-full sm:w-auto bg-orange-100 text-orange-700 text-sm font-medium px-5 py-2 rounded-lg text-center">
                            📦 Sedang Dikemas
                        </span>
                    @elseif(($order['status'] ?? '') === 'dikirim')
                        <form action="{{ route('orders.confirmReceived', $order->order_id) }}" method="POST"
                              onsubmit="return confirm('Konfirmasi pesanan sudah diterima?')">
                            @csrf
                            <button type="submit" class="w-full sm:w-auto bg-green-600 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-green-700 transition shadow-md">
                                ✅ Konfirmasi Diterima
                            </button>
                        </form>
                    @elseif(($order['status'] ?? '') === 'selesai')
                        <button class="w-full sm:w-auto bg-gray-200 text-gray-700 text-sm font-medium px-5 py-2 rounded-lg cursor-default">Pesanan Selesai</button>
                    @elseif(in_array($order['status'] ?? '', ['dibatalkan', 'batal']))
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