<?php

use App\Http\Controllers\ProfileController;
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

// ================= PEMBACA (Flowchart 2, 3, 4) =================
Route::middleware(['auth', 'role:pembaca'])->prefix('pembaca')->name('pembaca.')->group(function () {
    Route::get('/home', function () {
        return view('pembaca.home');
    })->name('home');
});

// ================= PENULIS (Flowchart 5) =================
Route::middleware(['auth', 'role:penulis'])->prefix('penulis')->name('penulis.')->group(function () {
    Route::get('/dashboard', function () {
        return view('penulis.dashboard');
    })->name('dashboard');
});

// ================= TIM REDAKSI (Flowchart 6) =================
Route::middleware(['auth', 'role:redaksi'])->prefix('redaksi')->name('redaksi.')->group(function () {
    Route::get('/dashboard', function () {
        return view('redaksi.dashboard');
    })->name('dashboard');
});

// ================= ADMIN (Flowchart 9) =================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});