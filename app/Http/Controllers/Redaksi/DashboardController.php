<?php

namespace App\Http\Controllers\Redaksi;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $naskahMasuk = Book::where('status', 'menunggu_review')->count();
        $sedangEditing = Book::where('status', 'editing')->count();
        $sudahTerbit = Book::where('status', 'terbit')->count();

        $antrianTerbaru = Book::where('status', 'menunggu_review')
            ->with(['author', 'genre'])
            ->latest()
            ->take(5)
            ->get();

        return view('redaksi.dashboard', compact(
            'naskahMasuk', 'sedangEditing', 'sudahTerbit', 'antrianTerbaru'
        ));
    }
}
