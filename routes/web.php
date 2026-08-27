<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\BookController;
use App\Http\Controllers\User\LibraryController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\WritingController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

// Flowchart 1: Homepage publik
Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__.'/auth.php';

// Profile (bawaan Breeze — berlaku untuk semua role yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================= USER (Pelanggan + Penulis, satu akun) =================
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    // Home / Dashboard gabungan (Flowchart 3)
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ---- Fungsi PELANGGAN (Flowchart 2) ----
    Route::get('/buku', [BookController::class, 'index'])->name('buku.index');
    Route::get('/buku/genre/{genre}', [BookController::class, 'byGenre'])->name('buku.genre');
    Route::get('/buku/{book}', [BookController::class, 'show'])->name('buku.show');
    Route::get('/buku/{book}/baca', [BookController::class, 'read'])->name('buku.read');

    // ---- Keranjang ----
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/{book}', [CartController::class, 'add'])->name('keranjang.add');
    Route::delete('/keranjang/{book}', [CartController::class, 'remove'])->name('keranjang.remove');

    // ---- Checkout (dari keranjang) ----
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/{order}/bayar', [CheckoutController::class, 'pay'])->name('checkout.pay');
    Route::post('/checkout/{order}/konfirmasi', [CheckoutController::class, 'confirm'])->name('checkout.confirm');

    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');

    // ---- Fungsi PENULIS (Flowchart 3, "Karya Saya") ----
    Route::get('/menulis', [WritingController::class, 'index'])->name('menulis.index'); // Karya Saya
    Route::get('/menulis/buat', [WritingController::class, 'create'])->name('menulis.create');
    Route::post('/menulis', [WritingController::class, 'store'])->name('menulis.store');
    Route::get('/menulis/{naskah}/edit', [WritingController::class, 'edit'])->name('menulis.edit');
    Route::put('/menulis/{naskah}', [WritingController::class, 'update'])->name('menulis.update');
    Route::post('/menulis/{naskah}/kirim', [WritingController::class, 'submitToRedaksi'])->name('menulis.submit');
    Route::get('/menulis/{naskah}/status', [WritingController::class, 'status'])->name('menulis.status');
});

// ================= TIM REDAKSI (Flowchart 4) =================
Route::middleware(['auth', 'role:redaksi'])->prefix('redaksi')->name('redaksi.')->group(function () {
    Route::get('/dashboard', function () {
        return view('redaksi.dashboard');
    })->name('dashboard');
});

// ================= ADMIN (Flowchart 5) =================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});