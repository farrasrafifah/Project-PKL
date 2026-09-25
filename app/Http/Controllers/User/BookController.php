<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    // Flowchart: Cari / Jelajah Buku
    public function index(Request $request): View
    {
        $query = Book::query()
            ->where('status', 'terbit')
            ->with(['genre', 'author']);

        $query->when($request->search, fn ($q, $search) =>
            $q->where('title', 'like', "%{$search}%")
        );

        $books = $query->latest('published_at')->paginate(12)->withQueryString();
        $genres = Genre::orderBy('name')->get();

        return view('user.books.index', compact('books', 'genres'));
    }

    // Flowchart: Pilih Genre
    public function byGenre(Genre $genre): View
    {
        $books = Book::where('status', 'terbit')
            ->where('genre_id', $genre->id)
            ->with(['genre', 'author'])
            ->latest('published_at')
            ->paginate(12);

        $genres = Genre::orderBy('name')->get();

        return view('user.books.index', compact('books', 'genres', 'genre'));
    }

    // Flowchart: Detail Buku
    public function show(Book $book): View
    {
        abort_unless($book->status === 'terbit', 404);

        $book->load(['genre', 'author']);

        $sudahDimiliki = auth()->user()
            ->libraries()
            ->where('book_id', $book->id)
            ->exists();

        return view('user.books.show', compact('book', 'sudahDimiliki'));
    }

    // Flowchart: Baca Ebook (hanya bisa kalau sudah ada di Library)
    public function read(Book $book): View
    {
        $dimiliki = auth()->user()
            ->libraries()
            ->where('book_id', $book->id)
            ->exists();

        // Penulis boleh baca naskahnya sendiri meski belum "dibeli"
        $pemilikNaskah = $book->user_id === auth()->id();

        abort_unless($dimiliki || $pemilikNaskah, 403, 'Kamu belum memiliki ebook ini.');

        $book->load(['chapters' => fn ($q) => $q->orderBy('chapter_number')]);

        // Catat riwayat baca
        auth()->user()->readingHistories()->updateOrCreate(
            ['book_id' => $book->id],
            ['last_read_at' => now()]
        );

        return view('user.books.read', compact('book'));
    }
}
