<?php

namespace App\Http\Controllers\Redaksi;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NaskahController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status', 'menunggu_review');

        $naskahList = Book::whereIn('status', ['menunggu_review', 'editing', 'revisi', 'finalisasi'])
            ->when($status !== 'semua', fn ($q) => $q->where('status', $status))
            ->with(['author', 'genre'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('redaksi.naskah.index', compact('naskahList', 'status'));
    }

    public function show(Book $naskah): View
    {
        $naskah->load([
            'author', 'genre',
            'chapters' => fn ($q) => $q->orderBy('chapter_number'),
            'reviews' => fn ($q) => $q->latest(),
        ]);

        return view('redaksi.naskah.show', compact('naskah'));
    }

    public function requestRevision(Request $request, Book $naskah): RedirectResponse
    {
        $validated = $request->validate(['catatan' => 'required|string|max:2000']);

        $naskah->reviews()->create([
            'reviewer_id' => auth()->id(),
            'catatan' => $validated['catatan'],
            'keputusan' => 'perlu_revisi',
        ]);

        $naskah->update(['status' => 'revisi', 'reviewed_by' => auth()->id()]);

        return redirect()->route('redaksi.naskah.index')->with('status', 'Catatan revisi terkirim ke penulis.');
    }

    public function approveToEditing(Request $request, Book $naskah): RedirectResponse
    {
        $naskah->reviews()->create([
            'reviewer_id' => auth()->id(),
            'catatan' => $request->input('catatan', 'Naskah disetujui, lanjut proses editing.'),
            'keputusan' => 'lanjut_editing',
        ]);

        $naskah->update(['status' => 'editing', 'reviewed_by' => auth()->id()]);

        return redirect()->route('redaksi.naskah.index')->with('status', 'Naskah masuk tahap editing.');
    }

    public function finalize(Book $naskah): RedirectResponse
    {
        abort_unless($naskah->status === 'editing', 400, 'Naskah belum dalam tahap editing.');

        $naskah->update(['status' => 'finalisasi']);

        return redirect()->route('redaksi.naskah.show', $naskah)->with('status', 'Naskah masuk tahap finalisasi.');
    }

    public function publish(Request $request, Book $naskah): RedirectResponse
    {
        abort_unless($naskah->status === 'finalisasi', 400, 'Naskah belum siap diterbitkan.');

        $validated = $request->validate(['price' => 'required|numeric|min:0']);

        $naskah->update([
            'status' => 'terbit',
            'price' => $validated['price'],
            'published_at' => now(),
        ]);

        return redirect()->route('redaksi.naskah.index')->with('status', 'Ebook berhasil diterbitkan!');
    }
}
