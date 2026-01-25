<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PelangganAuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PromoController;

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', fn () => 'Dashboard Admin')->name('admin.dashboard');

    Route::get('/chat', [AdminChatController::class, 'index'])->name('admin.chat.index');
    Route::get('/chat/{pelanggan}', [AdminChatController::class, 'show'])->name('admin.chat.show');
    Route::post('/chat/{pelanggan}', [AdminChatController::class, 'send'])->name('admin.chat.send');
});

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
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', [KategoriBarangController::class, 'index'])->name('kategori.index');
Route::get('/home', [KategoriBarangController::class, 'index'])->name('kategori.home');

Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/{kode_barang}', [ProductController::class, 'show'])->name('product.detail');

Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');
Route::view('/favorit', 'products.favorit')->name('favorit');

/*
|--------------------------------------------------------------------------
| MIDTRANS CALLBACK (TANPA AUTH)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [OrderController::class, 'callback'])
    ->name('midtrans.callback');

/*
|--------------------------------------------------------------------------
| ROUTE WAJIB LOGIN PELANGGAN
|--------------------------------------------------------------------------
*/
Route::middleware('auth:pelanggan')->group(function () {

    /*
    | CART
    */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::put('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.updateAll');

    /*
    | CHECKOUT & PEMBAYARAN
    */
    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('orders.checkout');
    Route::post('/checkout/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::post('/orders/pay-pending/{orderId}', [OrderController::class, 'payPending'])->name('orders.payPending');


    /*
    | ORDER STATUS
    */
    Route::get('/orders/success/{order_id}', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
    Route::get('/orders/failed', [OrderController::class, 'failed'])->name('orders.failed');

    /*
    | RIWAYAT & DETAIL PESANAN
    */
    Route::get('/pesanan', [OrderController::class, 'pesanan'])->name('orders.pesanan');
    Route::get('/pesanan/{order_id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/riwayat', [OrderController::class, 'riwayat'])->name('orders.riwayat');

    /*
    | PROFILE
    */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    /*
    | CHAT
    */
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/fetch', [ChatController::class, 'fetch'])->name('chat.fetch');

    /*
    | VOUCHER
    */
    Route::post('/voucher/claim', [PromoController::class, 'claim'])->name('voucher.claim');
});

require __DIR__ . '/auth.php';
