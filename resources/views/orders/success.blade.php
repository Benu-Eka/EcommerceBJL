@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center text-center">
    <h1 class="text-3xl font-bold text-green-600">Pembayaran Berhasil 🎉</h1>
    <p class="mt-2 text-gray-600">{{ $message }}</p>

    <a href="{{ route('product') }}" 
       class="mt-6 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
       Kembali ke Beranda
    </a>
</div>
@endsection
