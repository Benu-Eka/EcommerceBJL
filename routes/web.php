<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PelangganAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| AUTH PELANGGAN
|--------------------------------------------------------------------------
*/
Route::get('/login-pelanggan', [PelangganAuthController::class, 'showLoginForm'])->name('pelanggan.login.form');
Route::post('/login-pelanggan', [PelangganAuthController::class, 'login'])->name('pelanggan.login');
Route::post('/logout-pelanggan', [PelangganAuthController::class, 'logout'])->name('pelanggan.logout');

Route::get('/register-pelanggan', [PelangganAuthController::class, 'showRegisterForm'])->name('pelanggan.register.form');
Route::post('/register-pelanggan', [PelangganAuthController::class, 'register'])->name('pelanggan.register');

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/
Route::get('/', [KategoriBarangController::class, 'index'])->name('kategori.index');
Route::get('/home', [KategoriBarangController::class, 'index'])->name('kategori.home');

/*
|--------------------------------------------------------------------------
| PRODUK
|--------------------------------------------------------------------------
*/
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/{kode_barang}', [ProductController::class, 'show'])->name('product.detail');

/*
|--------------------------------------------------------------------------
| ROUTES WAJIB LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth:pelanggan')->group(function () {

    /*
    |-------------------------
    | KERANJANG
    |-------------------------
    */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    /*
    |-------------------------
    | CHECKOUT
    |-------------------------
    */
    // Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.show');  // tampilkan halaman checkout
    // Route::post('/checkout/pay', [CheckoutController::class, 'placeOrder'])->name('checkout.pay'); // proses midtrans

    /*
    |-------------------------
    | ORDER (RIWAYAT)
    |-------------------------
    */
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');

    /*
    |-------------------------
    | PROFIL
    |-------------------------
    */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['post', 'put'], '/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| STATIC PAGE
|--------------------------------------------------------------------------
*/
Route::view('/promo', 'products.promo')->name('promo');
Route::view('/favorit', 'products.favorit')->name('favorit');
Route::view('/chat', 'products.chat')->name('chat');
Route::view('/riwayat', 'orders.riwayat')->name('riwayat');

Route::middleware('auth:pelanggan')->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])
        ->name('orders.checkout');

    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])
        ->name('orders.place');
});


// Route::middleware('auth:pelanggan')->group(function () {

//     Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout.show');

//     Route::post('/checkout/place', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
// });

// // Halaman Checkout (GET)
// Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');

// // Proses Order + Midtrans (POST)
// Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// // Callback Midtrans
Route::post('/midtrans/callback', [CheckoutController::class, 'callback'])->name('midtrans.callback');
