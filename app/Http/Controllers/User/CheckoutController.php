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
            'status' => 'pending',
        ]);

        foreach ($books as $book) {
            $order->items()->create([
                'book_id' => $book->id,
                'price' => $book->price,
            ]);
        }

        return redirect()->route('user.checkout.pay', $order)
            ->with('status', 'Order dibuat, lanjut ke pembayaran.');
    }

    public function pay(Order $order): View
    {
        abort_unless($order->user_id === auth()->id(), 403);

        return view('user.checkout.pay', compact('order'));
    }

    // Konfirmasi pembayaran berhasil → masukkan semua buku ke Library
    public function confirm(Order $order): RedirectResponse
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->update(['status' => 'paid']);

        foreach ($order->items as $item) {
            $order->user->libraries()->firstOrCreate(
                ['book_id' => $item->book_id],
                ['tipe' => 'beli']
            );
        }

        session()->forget('cart');

        return redirect()->route('user.library.index')
            ->with('status', 'Pembayaran berhasil! Ebook masuk ke Library kamu.');
    }
}