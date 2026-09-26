<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * [Dashboard Admin] -> [Kelola Genre] (flowchart bagian 5)
 */
class GenreController extends Controller
{
    public function index(): View
    {
        // Asumsi: Genre model punya relasi hasMany books().
        // Kalau belum ada, tambahkan: public function books() { return $this->hasMany(Book::class); }
        $genres = Genre::withCount('books')->latest()->paginate(15);

        return view('admin.genres.index', compact('genres'));
    }

    public function create(): View
    {
        return view('admin.genres.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:genres,name'],
        ]);

        Genre::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()
            ->route('admin.genres.index')
            ->with('status', 'Genre berhasil ditambahkan.');
    }

    public function edit(Genre $genre): View
    {
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('genres', 'name')->ignore($genre->id)],
        ]);

        $genre->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect()
            ->route('admin.genres.index')
            ->with('status', 'Genre berhasil diperbarui.');
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        return redirect()
            ->route('admin.genres.index')
            ->with('status', $genre->delete()
                ? 'Genre berhasil dihapus.'
                : 'Genre gagal dihapus.');
    }
}