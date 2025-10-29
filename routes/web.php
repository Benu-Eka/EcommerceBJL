<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

Route::get('/produk/{kode_barang}', [ProductController::class, 'show'])->name('product.detail');

Route::get('/chart', [CartController::class, 'index'])->name('chart.index');
Route::put('/chart/update/{id}', [CartController::class, 'update'])->name('chart.update');
Route::delete('/chart/delete/{id}', [CartController::class, 'destroy'])->name('chart.destroy');

Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

// ===================================
// ✅ ROUTE UTAMA (Memanggil Controller)
// ===================================
Route::get('/', [KategoriBarangController::class, 'index'])->name('kategori.index');
Route::get('/home', [KategoriBarangController::class, 'index'])->name('kategori.home');

// ===================================
// ORDER
// ===================================
Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');

// ===================================
// PAGE LAIN (STATIC VIEW)
// ===================================
Route::view('/register', 'register');
Route::view('/product', 'product');
Route::view('/chart2', 'products.chart2');
Route::view('/favorit', 'products.favorit');
Route::view('/chat', 'products.chat');
Route::view('/promo', 'products.promo');
Route::view('/riwayat', 'orders.riwayat');
Route::view('/profile', 'profile')->name('profiles.index');
Route::view('/checkout', 'checkout')->name('checkouts.index');


// Route Index / Homepage
// Route::get('/', function () {
//     return view('welcome'); // Atau ganti dengan view 'home' jika ada
// })->name('home');

// Route Halaman Produk (Menangani Tampilan Semua Produk, Pencarian, dan Sorting)
// Route ini harus mengarah ke ProductController@index yang sudah dimodifikasi
Route::get('/product', [ProductController::class, 'index'])->name('product');

// Route untuk melihat detail produk (Perlu ditambahkan di Blade Card)
Route::get('/product/{kode_barang}', [ProductController::class, 'show'])->name('product.detail');

// Route Navigasi Lain (Asumsi menggunakan Blade view sederhana)
Route::get('/product/promo', function () {
    return view('promo');
})->name('promo');

Route::get('/orders/pesanan', function () {
    return view('pesanan');
})->name('pesanan');

Route::get('/orders/riwayat', function () {
    return view('riwayat');
})->name('riwayat');

Route::get('/product/{kode_barang}', [ProductController::class, 'show'])->name('product.detail');
// ==========================================================
// 2. ROUTES AKUN PENGGUNA (Dari Ikon Kanan Navbar)
// ==========================================================

// Route::middleware('auth')->group(function () {
//     Route::get('/chat', function () {
//         return view('chat.index');
//     })->name('chat');

//     Route::get('/chart', function () {
//         return view('cart.index');
//     })->name('cart');

//     Route::get('/favorit', function () {
//         return view('favorite.index');
//     })->name('favorit');

//     Route::get('/profile', function () {
//         return view('profile.index');
//     })->name('profile');
// });
