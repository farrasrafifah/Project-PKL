<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * [Dashboard Admin] -> [Kelola Redaksi] (flowchart bagian 5)
 * Akun redaksi dibuat langsung oleh admin (tidak lewat register publik).
 */
class RedaksiController extends Controller
{
    public function index(): View
    {
        $redaksiList = User::where('role', 'redaksi')->latest()->paginate(15);

        return view('admin.redaksi.index', compact('redaksiList'));
    }

    public function create(): View
    {
        return view('admin.redaksi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'redaksi',
        ]);

        return redirect()
            ->route('admin.redaksi.index')
            ->with('status', 'Akun redaksi berhasil dibuat.');
    }

    public function edit(User $redaksi): View
    {
        abort_unless($redaksi->role === 'redaksi', 404);

        return view('admin.redaksi.edit', compact('redaksi'));
    }

    public function update(Request $request, User $redaksi): RedirectResponse
    {
        abort_unless($redaksi->role === 'redaksi', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($redaksi->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $redaksi->name = $validated['name'];
        $redaksi->email = $validated['email'];

        if (!empty($validated['password'])) {
            $redaksi->password = Hash::make($validated['password']);
        }

        $redaksi->save();

        return redirect()
            ->route('admin.redaksi.index')
            ->with('status', 'Akun redaksi berhasil diperbarui.');
    }

    public function destroy(User $redaksi): RedirectResponse
    {
        abort_unless($redaksi->role === 'redaksi', 404);

        $redaksi->delete();

        return redirect()
            ->route('admin.redaksi.index')
            ->with('status', 'Akun redaksi berhasil dihapus.');
    }
}