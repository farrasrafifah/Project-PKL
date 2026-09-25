<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function index()
    {
        $libraries = Library::with([
            'book.genre'
        ])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        return view('user.library.index', compact('libraries'));
    }
}