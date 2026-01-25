@extends('layouts.app')

@section('title', 'Detail Pesanan | Gudang Bumbu & Sembako')

@section('content')
<x-navbar />

<div class="min-h-screen bg-[#f9fafb] py-10 px-4">
    <div class="max-w-4xl mx-auto">
        
        {{-- Tombol Kembali Konsisten --}}
        <div class="mb-8">
            <a href="{{ route('orders.pesanan') }}" 
               class="inline-flex items-center text-gray-500 hover:text-red-700 font-medium transition-colors duration-200 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Pesanan
            </a>
            <div class="flex flex-col md:flex-row md:items-center justify-between mt-4 gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Pesanan</h1>
                    <p class="text-gray-500 text-sm mt-1 uppercase tracking-wider font-bold">ID: #{{ $order->order_id }}</p>
                </div>
                
                {{-- Status Badge Dinamis --}}
                <div class="inline-flex items-center px-5 py-2 rounded-2xl font-bold text-xs uppercase tracking-widest border
                    @php
                        $status = strtolower($order->status ?? 'pending');
                        if ($status === 'belum_bayar') {
                            echo 'text-amber-600 bg-amber-50 border-amber-100';
                        } elseif (in_array($status, ['dikirim', 'diproses', 'dikemas'])) {
                            echo 'text-blue-600 bg-blue-50 border-blue-100';
                        } elseif ($status === 'selesai') {
                            echo 'text-green-600 bg-green-50 border-green-100';
                        } else {
                            echo 'text-red-600 bg-red-50 border-red-100';
                        }
                    @endphp
                ">
                    <span class="w-2 h-2 rounded-full mr-2 
                        @php
                            if ($status === 'belum_bayar') echo 'bg-amber-500';
                            elseif (in_array($status, ['dikirim', 'diproses', 'dikemas'])) echo 'bg-blue-500';
                            elseif ($status === 'selesai') echo 'bg-green-500';
                            else echo 'bg-red-500';
                        @endphp
                    "></span>
                    {{ str_replace('_', ' ', $order->status) }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8">
            
            {{-- INFO PENGIRIMAN & PEMBAYARAN --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                    <div>
                        <h3 class="text-gray-400 font-bold uppercase tracking-widest text-[10px] mb-3">Informasi Penerima</h3>
                        <p class="text-gray-900 font-bold text-lg">{{ $order->nama_penerima ?? 'Nama Tidak Tersedia' }}</p>
                        <p class="text-gray-600 mt-2 leading-relaxed">{{ $order->alamat ?? 'Alamat tidak diatur' }}</p>
                        <p class="text-gray-600">{{ $order->kota ?? '' }}</p>
                        <p class="text-gray-900 font-semibold mt-2">{{ $order->telepon ?? '-' }}</p>
                    </div>
                    <div class="md:text-right">
                        <h3 class="text-gray-400 font-bold uppercase tracking-widest text-[10px] mb-3">Metode Pembayaran</h3>
                        <div class="inline-flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-xl">
                            <span class="text-gray-900 font-bold">Midtrans Payment</span>
                        </div>
                        <p class="text-gray-500 text-xs mt-3 italic">Dipesan pada: {{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }} WIB</p>
                    </div>
                </div>
            </div>

            {{-- DAFTAR ITEM --}}
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50">
                    <h3 class="text-lg font-black text-gray-900">Rincian Produk</h3>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($order->items as $item)
                    <div class="p-8 flex flex-col md:flex-row md:items-center justify-between gap-4 group">
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex-shrink-0 flex items-center justify-center border border-gray-100 font-bold text-gray-400">
                                @if($item->barang && $item->barang->foto_produk)
                                    <img src="{{ asset('build/assets/' . $item->barang->foto_produk) }}" class="w-full h-full object-cover rounded-2xl">
                                @else
                                    <svg class="w-8 h-8 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 group-hover:text-red-600 transition">{{ $item->nama_barang ?? $item->name }}</h4>
                                <p class="text-gray-500 text-xs mt-1">{{ $item->quantity ?? $item->qty }} unit x Rp {{ number_format($item->harga_satuan ?? $item->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-900 font-black">
                                Rp {{ number_format(($item->harga_satuan ?? $item->price) * ($item->quantity ?? $item->qty), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-gray-400 italic">Data produk tidak ditemukan.</div>
                    @endforelse
                </div>

                {{-- TOTAL SECTION --}}
                <div class="bg-gray-50/50 p-8 border-t border-gray-100 space-y-3">
                    <div class="flex justify-between text-gray-500 text-sm font-medium">
                        <span>Total Harga Produk</span>
                        <span>Rp {{ number_format($order->total - 5000, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500 text-sm font-medium">
                        <span>Biaya Operasional / Ongkir</span>
                        <span>Rp 5.000</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <span class="text-gray-900 font-black text-lg">Total Pembayaran</span>
                        <span class="text-2xl font-black text-red-600 tracking-tight">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- BUTTON ACTION PEMBAYARAN --}}
            <div class="flex gap-3 w-full md:w-auto mt-6">
                
            @if(strtolower($order->status ?? '') === 'pending')
                    <button id="pay-button" 
                        class="flex-1 md:flex-none bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-red-100 transition-all transform hover:-translate-y-1">
                        Lakukan Pembayaran
                    </button>
                @elseif(strtolower($order->status ?? '') === 'dikirim')
                    <form action="{{ route('orders.confirmReceipt', $order->order_id) }}" method="POST" class="flex-1 md:flex-none w-full">
                        @csrf
                        <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold px-8 py-4 rounded-2xl shadow-xl shadow-green-100 transition-all transform hover:-translate-y-1">
                            Konfirmasi Terima Pesanan
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</div>
{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
const button = document.getElementById('pay-button');
const orderId = "{{ $order->order_id }}";

button.addEventListener('click', function () {
    button.disabled = true;
    button.innerText = 'Memproses...';

    fetch(`/orders/pay-pending/${orderId}`, { 
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            nama_penerima: "{{ $order->nama_penerima }}",
            alamat: "{{ $order->alamat }}",
            telepon: "{{ $order->telepon }}"
        })
    })
    .then(response => {
        if(!response.ok) throw new Error('HTTP status ' + response.status);
        return response.json();
    })
    .then(data => {
        if(data.error){
            alert(data.error);
            button.disabled = false;
            button.innerText = "Lakukan Pembayaran";
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: function(result){
                window.location.href = `/orders/success/${data.order_id}`;
            },
            onPending: function(result){
                window.location.href = `/orders/pending/${data.order_id}`;
            },
            onError: function(result){
                window.location.href = `/orders/failed/${data.order_id}`;
            },
            onClose: function(){
                button.disabled = false;
                button.innerText = "Lakukan Pembayaran";
            }
        });
    })
    .catch(err => {
        console.error('Fetch error:', err);
        alert('Terjadi kesalahan, coba ulangi.');
        button.disabled = false;
        button.innerText = "Lakukan Pembayaran";
    });
});

</script>

<x-footer />
@endsection
