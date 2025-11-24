<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PelangganAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoController;


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
// Route::get('/product', [ProductController::class, 'index'])->name('product.index');


/*
|--------------------------------------------------------------------------
| ROUTE YANG WAJIB LOGIN (auth:pelanggan)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:pelanggan')->group(function () {

    // CART
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::put('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.updateAll');

    // CHECKOUT PAGE
    Route::get('/checkout', [OrderController::class, 'index'])->name('orders.checkout');

    // SIMPAN SURAT JALAN
    Route::post('/checkout/store', [OrderController::class, 'store'])->name('orders.store');

    // PROSES PEMBAYARAN MIDTRANS
    Route::post('/checkout/pay', [OrderController::class, 'pay'])->name('orders.pay');

    // CALLBACK RESULT
    Route::get('/orders/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('/orders/failed', [OrderController::class, 'failed'])->name('orders.failed');

    // HISTORY PESANAN
    Route::get('/pesanan', [OrderController::class, 'riwayat'])->name('orders.index');
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


Route::post('/checkout/process', [OrderController::class, 'process'])->name('checkout.process');
Route::get('/transaksi', [OrderController::class, 'transaksi'])->name('orders.transaksi');


Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');
Route::post('/voucher/claim', [PromoController::class, 'claim'])->name('voucher.claim')->middleware('auth:pelanggan');
