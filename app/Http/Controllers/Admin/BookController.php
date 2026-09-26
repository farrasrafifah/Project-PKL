<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Admin cuma bertugas moderasi (lihat, ubah status/harga/genre, hapus).
 * Judul, sinopsis, dan isi naskah adalah hak penulis — dibuat & diedit
 * lewat alur User\WritingController, bukan di sini.
 */
class BookController extends Controller
{
    public function index(Request $request): View
    {
        $books = Book::with(['genre', 'author'])
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.books.index', compact('books'));
    }

    public function edit(Book $book): View
    {
        $genres = Genre::all();

        return view('admin.books.edit', compact('book', 'genres'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'genre_id' => ['required', 'exists:genres,id'],
            'price'    => ['required', 'numeric', 'min:0'],
            'status'   => ['required', 'in:draft,menunggu_review,terbit'],
        ]);

        $book->update($validated);

        return redirect()
            ->route('admin.books.index')
            ->with('status', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return back()->with('status', 'Buku berhasil dihapus.');
    }
}