<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function index(Request $request): View
    {
        $books = $request->user()
            ->libraries()
            ->with('book.genre')
            ->latest()
            ->get()
            ->pluck('book');

        return view('user.library.index', compact('books'));
    }
}