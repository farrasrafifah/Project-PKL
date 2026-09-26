<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\BookController;
use App\Http\Controllers\User\LibraryController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\WritingController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Redaksi\DashboardController as RedaksiDashboardController;
use App\Http\Controllers\Redaksi\NaskahController as RedaksiNaskahController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RedaksiController as AdminRedaksiController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// =====================================================
// HOMEPAGE (bisa diakses tanpa login)
// =====================================================
Route::get('/', function () {

    // Kalau yang login itu admin/redaksi, tetap lempar ke dashboard masing-masing.
    // Guest & role "user" tetap lihat halaman Home.
    if (Auth::check()) {
        $role = Auth::user()->role;

        if ($role === 'redaksi') {
            return redirect()->route('redaksi.dashboard');
        }

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }

    return app(HomeController::class)->index();

})->name('home');


// =====================================================
// AUTH
// =====================================================
require __DIR__.'/auth.php';


// =====================================================
// PROFILE
// =====================================================
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


// =====================================================
// BUKU (bisa diakses tanpa login — guest boleh lihat-lihat)
// =====================================================
Route::prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/buku', [BookController::class, 'index'])
            ->name('buku.index');

        Route::get('/buku/genre/{genre}', [BookController::class, 'byGenre'])
            ->name('buku.genre');

        Route::get('/buku/{book}', [BookController::class, 'show'])
            ->name('buku.show');

    });


// =====================================================
// USER (wajib login — transaksi & data pribadi)
// =====================================================
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/home', [HomeController::class, 'index'])
            ->name('home');

        // Baca full ebook tetap wajib login (hak akses setelah beli/pinjam)
        Route::get('/buku/{book}/baca', [BookController::class, 'read'])
            ->name('buku.read');

        Route::get('/keranjang', [CartController::class, 'index'])
            ->name('keranjang.index');

        Route::post('/keranjang/{book}', [CartController::class, 'add'])
            ->name('keranjang.add');

        Route::delete('/keranjang/{book}', [CartController::class, 'remove'])
            ->name('keranjang.remove');

        Route::get('/checkout', [CheckoutController::class, 'create'])
            ->name('checkout.create');

        Route::post('/checkout', [CheckoutController::class, 'store'])
            ->name('checkout.store');

        Route::get('/checkout/{order}/bayar', [CheckoutController::class, 'pay'])
            ->name('checkout.pay');

        Route::post('/checkout/{order}/konfirmasi', [CheckoutController::class, 'confirm'])
            ->name('checkout.confirm');

        Route::get('/library', [LibraryController::class, 'index'])
            ->name('library.index');

        Route::get('/menulis', [WritingController::class, 'index'])
            ->name('menulis.index');

        Route::get('/menulis/buat', [WritingController::class, 'create'])
            ->name('menulis.create');

        Route::post('/menulis', [WritingController::class, 'store'])
            ->name('menulis.store');

        Route::get('/menulis/{naskah}/edit', [WritingController::class, 'edit'])
            ->name('menulis.edit');

        Route::put('/menulis/{naskah}', [WritingController::class, 'update'])
            ->name('menulis.update');

        Route::post('/menulis/{naskah}/kirim', [WritingController::class, 'submitToRedaksi'])
            ->name('menulis.submit');

        Route::get('/menulis/{naskah}/status', [WritingController::class, 'status'])
            ->name('menulis.status');

        Route::post('/menulis/{naskah}/chapter', [WritingController::class, 'storeChapter'])
            ->name('menulis.chapter.store');

        Route::put('/menulis/{naskah}/chapter/{chapter}', [WritingController::class, 'updateChapter'])
            ->name('menulis.chapter.update');

        Route::delete('/menulis/{naskah}/chapter/{chapter}', [WritingController::class, 'destroyChapter'])
            ->name('menulis.chapter.destroy');

    });


// =====================================================
// TIM REDAKSI
// =====================================================
Route::middleware(['auth', 'role:redaksi'])
    ->prefix('redaksi')
    ->name('redaksi.')
    ->group(function () {

        Route::get('/dashboard', [RedaksiDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/naskah', [RedaksiNaskahController::class, 'index'])
            ->name('naskah.index');

        Route::get('/naskah/{naskah}', [RedaksiNaskahController::class, 'show'])
            ->name('naskah.show');

        Route::post('/naskah/{naskah}/revisi', [RedaksiNaskahController::class, 'requestRevision'])
            ->name('naskah.revisi');

        Route::post('/naskah/{naskah}/editing', [RedaksiNaskahController::class, 'approveToEditing'])
            ->name('naskah.editing');

        Route::post('/naskah/{naskah}/finalisasi', [RedaksiNaskahController::class, 'finalize'])
            ->name('naskah.finalisasi');

        Route::post('/naskah/{naskah}/terbit', [RedaksiNaskahController::class, 'publish'])
            ->name('naskah.terbit');

    });


// =====================================================
// ADMIN
// =====================================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Kelola Ebook / Buku (read-only monitoring: nggak ada create/store,
        // karena buku dibuat oleh User lewat alur Menulis → Redaksi)
        Route::resource('books', AdminBookController::class)
            ->only(['index', 'edit', 'update', 'destroy']);

        // Kelola Genre
        Route::resource('genres', AdminGenreController::class);

        // Kelola User (controller cuma punya index, show, destroy)
        Route::resource('users', AdminUserController::class)
            ->only(['index', 'show', 'destroy']);

        // Kelola Redaksi
        Route::resource('redaksi', AdminRedaksiController::class);

        // Lihat Transaksi (read-only: index + show saja)
        Route::get('/transaksi', [AdminOrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/transaksi/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');

    });