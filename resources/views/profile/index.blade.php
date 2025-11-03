@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <x-navbar />

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Tombol Kembali dan Judul --}}
        <div class="mb-8">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center text-gray-600 hover:text-green-700 font-medium transition">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800 mt-3">Profil Pelanggan</h1>
        </div>

        {{-- Kartu Profil --}}
        <div class="bg-white rounded-2xl shadow border border-gray-100 p-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                {{-- Foto Profil --}}
                <div class="flex-shrink-0">
                    <img src="https://via.placeholder.com/128x128/16a34a/FFFFFF?text=User"
                         alt="Foto Profil"
                         class="h-28 w-28 rounded-full object-cover border-4 border-green-200 shadow-md">
                </div>

                {{-- Informasi Akun --}}
                <div class="flex-1 space-y-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $pelanggan->nama_pelanggan ?? 'Nama Pelanggan' }}</h2>
                        <p class="text-sm text-gray-500">{{ $pelanggan->email ?? '-' }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="font-medium text-gray-600">Alamat:</p>
                            <p class="text-gray-800">{{ $pelanggan->alamat ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="font-medium text-gray-600">NPWP:</p>
                            <p class="text-gray-800">{{ $pelanggan->NPWP ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="font-medium text-gray-600">Nama Kontak / PIC:</p>
                            <p class="text-gray-800">{{ $pelanggan->PIC ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="font-medium text-gray-600">Tipe Harga:</p>
                            <p class="text-gray-800 capitalize">{{ $pelanggan->tipe_harga ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="font-medium text-gray-600">Kategori Pelanggan:</p>
                            <p class="text-gray-800">{{ $pelanggan->kategoriPelanggan->nama_kategori ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="font-medium text-gray-600">Tanggal Bergabung:</p>
                            <p class="text-gray-800">{{ $pelanggan->created_at ? $pelanggan->created_at->format('d M Y') : '-' }}</p>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="pt-4 flex flex-wrap gap-3">
                        <a href="{{ route('profile.edit') }}"
                           class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-full transition">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" 
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5l3 3L12 15l-3.5.5.5-3.5L18.5 2.5z"/>
                            </svg>
                            Edit Profil
                        </a>

                        <form action="{{ route('pelanggan.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 border border-gray-300 bg-white text-gray-700 text-sm font-semibold rounded-full hover:bg-gray-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                     class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />
</div>
@endsection
