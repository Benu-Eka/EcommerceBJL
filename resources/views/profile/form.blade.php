@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f8fafc] flex flex-col font-sans">
    <x-navbar />

    <div class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            
            {{-- Alert Section --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-sm font-bold">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl shadow-sm">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span class="text-sm font-bold">Terjadi Kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 ml-8">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Breadcrumb & Title --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <a href="{{ route('profile.index') }}" class="group inline-flex items-center text-sm font-semibold text-gray-500 hover:text-red-600 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Profil
                    </a>
                    <h1 class="text-3xl font-black text-gray-900 mt-3 tracking-tight">Pengaturan <span class="text-red-600">Akun</span></h1>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Kolom Kiri: Form Utama --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100">
                        <div class="flex items-center mb-8">
                            <div class="p-3 bg-red-50 rounded-2xl mr-4 text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Informasi Pribadi</h2>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                            @method('PUT')
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                                    <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan ?? '') }}"
                                           class="w-full bg-gray-50 border-none rounded-2xl py-3 px-5 focus:ring-4 focus:ring-red-100 transition-all text-gray-700 font-medium">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Email (Terkunci)</label>
                                    <input type="email" value="{{ $pelanggan->email ?? '' }}" readonly
                                           class="w-full bg-gray-100 border-none rounded-2xl py-3 px-5 text-gray-400 cursor-not-allowed font-medium">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3"
                                          class="w-full bg-gray-50 border-none rounded-3xl py-3 px-5 focus:ring-4 focus:ring-red-100 transition-all text-gray-700 font-medium">{{ old('alamat', $pelanggan->alamat ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Nomor NPWP</label>
                                    <input type="text" name="NPWP" value="{{ old('NPWP', $pelanggan->NPWP ?? '') }}"
                                           class="w-full bg-gray-50 border-none rounded-2xl py-3 px-5 focus:ring-4 focus:ring-red-100 transition-all text-gray-700 font-medium">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Kontak / PIC</label>
                                    <input type="text" name="PIC" value="{{ old('PIC', $pelanggan->PIC ?? '') }}"
                                           class="w-full bg-gray-50 border-none rounded-2xl py-3 px-5 focus:ring-4 focus:ring-red-100 transition-all text-gray-700 font-medium">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Kategori Bisnis</label>
                                <div class="relative">
                                    <select name="kategori_pelanggan_id" class="w-full bg-gray-50 border-none rounded-2xl py-3 px-5 focus:ring-4 focus:ring-red-100 transition-all text-gray-700 font-medium appearance-none">
                                        <option value="">Pilih kategori...</option>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->kategori_pelanggan_id }}" {{ old('kategori_pelanggan_id', $pelanggan->kategori_pelanggan_id ?? '') == $k->kategori_pelanggan_id ? 'selected' : '' }}>
                                                {{ $k->kategori_pelanggan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6">
                                <button type="submit" class="w-full md:w-auto px-10 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl shadow-lg shadow-red-200 transition-all hover:-translate-y-1 active:scale-95">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Kolom Kanan: Keamanan --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 relative overflow-hidden">
                        {{-- Ornamen --}}
                        <div class="absolute -top-12 -right-12 w-24 h-24 bg-red-50 rounded-full blur-2xl"></div>
                        
                        <div class="relative">
                            <div class="p-3 bg-red-50 rounded-2xl w-fit mb-5 text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800 mb-2">Keamanan</h2>
                            <p class="text-gray-400 text-sm leading-relaxed mb-6">Pastikan akun Anda tetap aman dengan mengganti kata sandi secara berkala.</p>

                            <button id="toggle-password-form" class="w-full py-3 px-4 bg-gray-50 hover:bg-gray-100 text-gray-700 font-bold rounded-2xl transition-all border border-gray-100 flex items-center justify-center">
                                <span id="btn-text">Ganti Kata Sandi</span>
                                <svg id="btn-icon" class="w-4 h-4 ml-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <div id="password-form-container" class="mt-8 hidden animate-fadeIn">
                                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                                    @method('PUT')
                                    @csrf
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Sandi Baru</label>
                                        <input type="password" name="password" required
                                               class="w-full bg-gray-50 border-none rounded-2xl py-3 px-5 focus:ring-4 focus:ring-red-100 transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Konfirmasi Sandi</label>
                                        <input type="password" name="password_confirmation" required
                                               class="w-full bg-gray-50 border-none rounded-2xl py-3 px-5 focus:ring-4 focus:ring-red-100 transition-all">
                                    </div>
                                    <button type="submit" class="w-full py-4 bg-gray-900 hover:bg-black text-white font-bold rounded-2xl shadow-xl transition-all active:scale-95 mt-2">
                                        Update Sandi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <x-footer />
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn { animation: fadeIn 0.4s ease forwards; }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('toggle-password-form');
        const passwordForm = document.getElementById('password-form-container');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');

        toggleButton.addEventListener('click', function() {
            const isHidden = passwordForm.classList.contains('hidden');
            
            passwordForm.classList.toggle('hidden');
            btnText.textContent = isHidden ? 'Batalkan Ganti Sandi' : 'Ganti Kata Sandi';
            btnIcon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
            
            if(isHidden) {
                toggleButton.classList.add('bg-red-50', 'text-red-600', 'border-red-100');
            } else {
                toggleButton.classList.remove('bg-red-50', 'text-red-600', 'border-red-100');
            }
        });
    });
</script>
@endsection