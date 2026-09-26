<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * [Dashboard Admin] -> [Kelola User] (flowchart bagian 5)
 * Hanya menampilkan akun dengan role "user" (pelanggan/penulis).
 * Akun redaksi dikelola terpisah lewat Admin\RedaksiController.
 */
class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $users = User::where('role', 'user')
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    public function show(User $user): View
    {
        abort_unless($user->role === 'user', 404);

        $naskahList = \App\Models\Book::where('user_id', $user->id)->latest()->limit(10)->get();

        return view('admin.users.show', compact('user', 'naskahList'));
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_unless($user->role === 'user', 404);

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun user berhasil dihapus.');
    }
}