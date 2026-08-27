<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $books = Book::whereIn('id', array_keys($cart))->get();
        $total = $books->sum('price');

        return view('user.keranjang.index', compact('books', 'total'));
    }

    public function add(Book $book): RedirectResponse
    {
        $cart = session('cart', []);
        $cart[$book->id] = true;
        session(['cart' => $cart]);

        return back()->with('status', 'Buku ditambahkan ke keranjang.');
    }

    public function remove(Book $book): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$book->id]);
        session(['cart' => $cart]);

        return back()->with('status', 'Buku dihapus dari keranjang.');
    }
}