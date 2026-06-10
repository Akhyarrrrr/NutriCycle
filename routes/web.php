<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPemanggilanController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/pelayanan', [LandingController::class, 'pelayanan'])->name('pelayanan');
Route::post('/midtrans/callback', [MidtransController::class, 'callback'])->name('midtrans.callback');

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/produk', [UserController::class, 'produk'])->name('produk.index');
    Route::get('/produk/{slug}', [UserController::class, 'produkDetail'])->name('produk.show');
    Route::get('/keranjang', [UserController::class, 'keranjang'])->name('keranjang.index');
    Route::post('/keranjang/{id}', [UserController::class, 'addCart'])->name('keranjang.add');
    Route::patch('/keranjang/{id}', [UserController::class, 'updateCart'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [UserController::class, 'removeCart'])->name('keranjang.remove');
    Route::get('/checkout', [UserController::class, 'checkoutPage'])->name('checkout.page');
    Route::post('/checkout', [UserController::class, 'checkoutProcess'])->name('checkout.process');
    Route::get('/transaksi', [UserController::class, 'transaksiIndex'])->name('transaksi.index');
    Route::get('/transaksi/{kode}', [UserController::class, 'transaksiDetail'])->name('transaksi.show');
    Route::get('/pemanggilan', [UserController::class, 'pemanggilanIndex'])->name('pemanggilan.index');
    Route::get('/pemanggilan/buat', [UserController::class, 'pemanggilanCreate'])->name('pemanggilan.create');
    Route::post('/pemanggilan', [UserController::class, 'pemanggilanStore'])->name('pemanggilan.store');
});

Route::middleware(['auth', 'petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::get('/pickup', [PetugasController::class, 'pickupIndex'])->name('pickup.index');
    Route::patch('/pickup/{id}', [PetugasController::class, 'pickupUpdate'])->name('pickup.update');
    Route::get('/pengiriman', [PetugasController::class, 'pengirimanIndex'])->name('pengiriman.index');
    Route::patch('/pengiriman/{id}', [PetugasController::class, 'pengirimanUpdate'])->name('pengiriman.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
    Route::get('/pemanggilan', [AdminPemanggilanController::class, 'index'])->name('pemanggilan.index');
    Route::patch('/pemanggilan/{id}', [AdminPemanggilanController::class, 'update'])->name('pemanggilan.update');
    Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('transaksi.index');
    Route::patch('/transaksi/{id}', [AdminTransaksiController::class, 'update'])->name('transaksi.update');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
