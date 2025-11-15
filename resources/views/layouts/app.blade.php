<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- VITE ASSETS (Ini adalah bagian penting untuk memuat Tailwind CSS) --}}
    {{-- Vite akan mengkompilasi resources/css/app.css (yang berisi @tailwind directives) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Style Tambahan dari halaman spesifik (jika ada) --}}
    @stack('styles')
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-100">

    {{-- Konten Utama Halaman --}}
    <div id="app">
        {{-- Di sinilah Konten dari halaman spesifik (misalnya welcome.blade.php) akan ditempatkan --}}
        @yield('content')
    </div>

    {{-- Script Tambahan dari halaman spesifik (jika ada) --}}
    @stack('scripts')
</body>
</html>