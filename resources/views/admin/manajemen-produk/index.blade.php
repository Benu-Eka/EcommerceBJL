@extends('admin.layout.app')

@section('title', 'Manajemen Produk')
@section('content')
<div class="p-4 md:p-6 bg-white rounded-xl shadow-lg">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 border-b pb-3 flex items-center">
        <i class="fa-solid fa-eye-low-vision mr-3 text-red-600"></i> Kontrol Tampilan Produk
    </h1>

    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
        <p class="font-semibold">Fokus Utama</p>
        <p class="text-sm">Gunakan tombol *toggle* di kolom **Visible** untuk menentukan produk mana yang aktif ditampilkan di katalog penjualan.</p>
    </div>

    {{-- Tabel Daftar Produk dengan Kontrol Visibility --}}
    <div class="shadow-md rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-red-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">SKU</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-red-800 uppercase tracking-wider">Nama Produk</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-red-800 uppercase tracking-wider">Stok</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-red-800 uppercase tracking-wider">Visible</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-red-800 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                
                @forelse ($barangs as $barang)
                <tr x-data="{ 
                    isVisible: {{ $barang->is_visible ? 'true' : 'false' }}, 
                    kodeBarang: '{{ $barang->kode_barang }}' 
                }">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">{{ $barang->kode_barang }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $barang->nama_barang }}</td>
                    {{-- Ganti 0 dengan $barang->stok jika ada kolom stok, atau gunakan placeholder jika stok ada di tabel lain --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">{{ $barang->stok ?? 'N/A' }}</td>
                    
                    {{-- Kolom Kontrol Visibility --}}
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        {{-- Menggunakan form untuk POST request ke route toggle --}}
                        <form action="{{ route('manajemenProduk.toggleVisibility', $barang->kode_barang) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    @click="isVisible = !isVisible"
                                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    :class="{'bg-red-600': isVisible, 'bg-gray-300': !isVisible}" 
                                    :aria-checked="isVisible">
                                <span class="sr-only">Toggle Visibility</span>
                                <span :class="{'translate-x-6': isVisible, 'translate-x-1': !isVisible}"
                                      class="inline-block h-4 w-4 transform rounded-full bg-white shadow-lg transition-transform"></span>
                            </button>
                        </form>
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-center space-x-3">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900 transition duration-150" title="Edit Detail"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="#" class="text-red-600 hover:text-red-900 transition duration-150" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data produk yang tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginasi --}}
    <div class="mt-6">
        {{ $barangs->links() }}
    </div>
</div>
@endsection