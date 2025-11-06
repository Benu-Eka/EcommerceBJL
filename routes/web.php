<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PelangganAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| ROUTE UNTUK PELANGGAN (Login & Register)
|--------------------------------------------------------------------------
*/
Route::get('/login-pelanggan', [PelangganAuthController::class, 'showLoginForm'])->name('pelanggan.login.form');
Route::post('/login-pelanggan', [PelangganAuthController::class, 'login'])->name('pelanggan.login');
Route::post('/logout-pelanggan', [PelangganAuthController::class, 'logout'])->name('pelanggan.logout');

Route::get('/register-pelanggan', [PelangganAuthController::class, 'showRegisterForm'])->name('pelanggan.register.form');
Route::post('/register-pelanggan', [PelangganAuthController::class, 'register'])->name('pelanggan.register');

/*
|--------------------------------------------------------------------------
| ROUTE UTAMA (Home & Kategori)
|--------------------------------------------------------------------------
*/
Route::get('/', [KategoriBarangController::class, 'index'])->name('kategori.index');
Route::get('/home', [KategoriBarangController::class, 'index'])->name('kategori.home');

/*
|--------------------------------------------------------------------------
| ROUTE PRODUK (Daftar & Detail)
|--------------------------------------------------------------------------
*/
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/{kode_barang}', [ProductController::class, 'show'])->name('product.detail');

/*
|--------------------------------------------------------------------------
| ROUTE YANG WAJIB LOGIN (auth:pelanggan)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:pelanggan')->group(function () {

    // 🛒 Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // ✅ Checkout hanya untuk user login
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

    // 📦 Pesanan / Riwayat
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');

    // 👤 Profile pelanggan
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['post', 'put'], '/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| ROUTE TAMBAHAN (Static Page, Promo, dll)
|--------------------------------------------------------------------------
*/
Route::view('/promo', 'products.promo')->name('promo');
Route::view('/favorit', 'products.favorit')->name('favorit');
Route::view('/chat', 'products.chat')->name('chat');
Route::view('/riwayat', 'orders.riwayat')->name('riwayat');

require __DIR__ . '/auth.php';


Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout');
Route::put('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.updateAll');


Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
