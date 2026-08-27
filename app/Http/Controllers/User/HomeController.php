<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $recentBooks = $user->libraries()
            ->with('book')
            ->latest()
            ->take(6)
            ->get()
            ->pluck('book');

        $recentBooksWritten = $user->books()
            ->latest()
            ->take(5)
            ->get();

        return view('user.home', [
            'recentBooks' => $recentBooks,
            'recentBooks_written' => $recentBooksWritten,
        ]);
    }
}