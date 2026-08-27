<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    // Cari / Jelajah Buku
    public function index(Request $request): View
    {
        $books = Book::query()
            ->where('status', 'terbit')
            ->when($request->search, fn ($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->with(['author', 'genre'])
            ->latest('published_at')
            ->paginate(12);

        $genres = Genre::all();

        return view('user.buku.index', compact('books', 'genres'));
    }

    // Pilih Genre
    public function byGenre(Genre $genre): View
    {
        $books = Book::where('genre_id', $genre->id)
            ->where('status', 'terbit')
            ->with(['author', 'genre'])
            ->paginate(12);

        return view('user.buku.index', compact('books', 'genre'));
    }

    // Detail Buku
    public function show(Book $book): View
    {
        $book->load(['author', 'genre']);

        $owned = auth()->user()->libraries()->where('book_id', $book->id)->exists();

        return view('user.buku.show', compact('book', 'owned'));
    }

    // Baca Ebook (hanya jika sudah dimiliki)
    public function read(Book $book): View
    {
        abort_unless(
            auth()->user()->libraries()->where('book_id', $book->id)->exists(),
            403,
            'Anda belum memiliki buku ini.'
        );

        return view('user.buku.baca', compact('book'));
    }
}