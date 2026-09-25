<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WritingController extends Controller
{
    public function index()
    {
        $naskahList = Book::with('genre')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.menulis.index', compact('naskahList'));
    }

    public function create()
    {
        $genres = Genre::all();

        return view('user.menulis.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'synopsis' => 'required|string',
        ]);

        $book = new Book();
        $book->user_id = Auth::id();
        $book->title = $validated['title'];
        $book->slug = Str::slug($validated['title']).'-'.Str::random(6);
        $book->genre_id = $validated['genre_id'];
        $book->synopsis = $validated['synopsis'];
        $book->status = 'draft';
        $book->save();

        return redirect()
            ->route('user.menulis.edit', $book)
            ->with('success', 'Naskah berhasil dibuat. Yuk mulai tulis bab pertama.');
    }

    public function edit(Book $naskah)
    {
        abort_unless($naskah->user_id === Auth::id(), 403);

        $naskah->load(['genre', 'chapters', 'reviews' => fn ($q) => $q->latest()]);
        $genres = Genre::all();

        return view('user.menulis.edit', compact('naskah', 'genres'));
    }

    public function update(Request $request, Book $naskah)
    {
        abort_unless($naskah->user_id === Auth::id(), 403);
        $this->abortIfLocked($naskah);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'synopsis' => 'required|string',
        ]);

        $naskah->title = $validated['title'];
        $naskah->slug = Str::slug($validated['title']).'-'.Str::random(6);
        $naskah->genre_id = $validated['genre_id'];
        $naskah->synopsis = $validated['synopsis'];
        $naskah->save();

        return redirect()
            ->route('user.menulis.index')
            ->with('success', 'Naskah berhasil diperbarui.');
    }

    // Flowchart: Naskah Selesai -> Kirim ke Redaksi -> Menunggu Review
    public function submitToRedaksi(Book $naskah)
    {
        abort_unless($naskah->user_id === Auth::id(), 403);

        abort_if(
            !in_array($naskah->status, ['draft', 'revisi']),
            400,
            'Naskah ini sedang diproses dan tidak bisa dikirim ulang.'
        );

        abort_if($naskah->chapters()->count() === 0, 422, 'Tambahkan minimal 1 chapter sebelum mengirim ke redaksi.');

        $naskah->update(['status' => 'menunggu_review']);

        return redirect()
            ->route('user.menulis.status', $naskah)
            ->with('success', 'Naskah berhasil dikirim ke redaksi.');
    }

    public function status(Book $naskah)
    {
        abort_unless($naskah->user_id === Auth::id(), 403);

        $naskah->load(['reviews' => fn ($q) => $q->latest(), 'genre']);

        return view('user.menulis.status', compact('naskah'));
    }

    // Flowchart: Tambah Chapter
    public function storeChapter(Book $naskah, Request $request)
    {
        abort_unless($naskah->user_id === Auth::id(), 403);
        $this->abortIfLocked($naskah);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $nextNumber = $naskah->chapters()->max('chapter_number') + 1;

        $naskah->chapters()->create([
            'chapter_number' => $nextNumber,
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return redirect()
            ->route('user.menulis.edit', $naskah)
            ->with('success', 'Chapter berhasil ditambahkan.');
    }

    public function updateChapter(Book $naskah, Chapter $chapter, Request $request)
    {
        abort_unless($naskah->user_id === Auth::id(), 403);
        $this->abortIfLocked($naskah);
        abort_unless($chapter->book_id === $naskah->id, 404);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $chapter->update($validated);

        return redirect()
            ->route('user.menulis.edit', $naskah)
            ->with('success', 'Chapter berhasil diperbarui.');
    }

    public function destroyChapter(Book $naskah, Chapter $chapter)
    {
        abort_unless($naskah->user_id === Auth::id(), 403);
        $this->abortIfLocked($naskah);
        abort_unless($chapter->book_id === $naskah->id, 404);

        $chapter->delete();

        return redirect()
            ->route('user.menulis.edit', $naskah)
            ->with('success', 'Chapter dihapus.');
    }

    // Naskah yang sudah dikirim ke redaksi tidak boleh diedit,
    // kecuali statusnya 'revisi' (redaksi minta user perbaiki naskah)
    private function abortIfLocked(Book $naskah): void
    {
        abort_if(
            !in_array($naskah->status, ['draft', 'revisi']),
            400,
            'Naskah sedang diproses redaksi dan tidak bisa diedit saat ini.'
        );
    }
}
