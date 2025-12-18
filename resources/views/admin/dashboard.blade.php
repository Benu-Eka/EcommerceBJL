@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-white p-4 shadow rounded">
        <div class="text-gray-500">Total Produk</div>
    </div>
    <div class="bg-white p-4 shadow rounded">
        <div class="text-gray-500">Total Pesanan</div>
    </div>
    <div class="bg-white p-4 shadow rounded">
        <div class="text-gray-500">Total Pendapatan</div>
    </div>
</div>

{{-- Grafik --}}
<div class="bg-white p-6 shadow rounded">
    <h2 class="text-xl font-bold mb-4">Grafik Penjualan Bulanan</h2>
    <canvas id="salesChart"></canvas>
</div>


@endsection
