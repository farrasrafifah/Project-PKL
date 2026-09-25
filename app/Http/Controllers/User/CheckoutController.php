<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    // Ringkasan checkout dari isi keranjang
    public function create(): View
    {
        $cart = session('cart', []);
        abort_if(empty($cart), 404, 'Keranjang kosong.');

        $books = Book::whereIn('id', array_keys($cart))->get();
        $total = $books->sum('price');

        return view('user.checkout.create', compact('books', 'total'));
    }

    // Buat order dari keranjang
    public function store(Request $request): RedirectResponse
    {
        $cart = session('cart', []);
        abort_if(empty($cart), 404, 'Keranjang kosong.');

        $books = Book::whereIn('id', array_keys($cart))->get();

        $order = Order::create([
            'order_number' => 'INV-'.strtoupper(Str::random(10)),
            'user_id' => $request->user()->id,
            'total' => $books->sum('price'),
            'status' => 'menunggu_pembayaran',
        ]);

        foreach ($books as $book) {
            $order->items()->create([
                'book_id' => $book->id,
                'price' => $book->price,
            ]);
        }
