<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

/**
 * [Admin Login] -> [Dashboard Admin] -> Kelola User | Kelola Redaksi |
 * Kelola Ebook/Buku | Kelola Genre | Lihat Transaksi  (flowchart bagian 5)
 *
 * Catatan: saya asumsikan model transaksi bernama `Order` dengan kolom
 * `status` (mis. pending/paid/failed) dan `total_price`, mengacu ke
 * CheckoutController yang sudah ada di routes (checkout.store, checkout.pay,
 * checkout.confirm). Kalau nama model/kolomnya beda, tinggal sesuaikan
 * bagian yang saya tandai di bawah.
 */
class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_user' => User::where('role', 'user')->count(),
            'total_redaksi' => User::where('role', 'redaksi')->count(),
            'total_buku' => Book::count(),
            'total_genre' => Genre::count(),
        ];

        // Breakdown naskah/buku per status, dipakai untuk kartu "Kelola Ebook/Buku"
        $bukuPerStatus = Book::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // --- Bagian transaksi: sesuaikan nama model/kolom jika berbeda ---
        $totalTransaksi = 0;
        $pendapatan = 0;
        $transaksiTerbaru = collect();

        if (class_exists(Order::class)) {
            $totalTransaksi = Order::count();
            $pendapatan = Order::where('status', 'paid')->sum('total');
            $transaksiTerbaru = Order::with('user')->latest()->take(5)->get();
        }

        $stats['total_transaksi'] = $totalTransaksi;
        $stats['pendapatan'] = $pendapatan;

        return view('admin.dashboard', compact('stats', 'bukuPerStatus', 'transaksiTerbaru'));
    }
}