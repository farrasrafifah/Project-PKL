<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * [Dashboard Admin] -> [Lihat Transaksi] (flowchart bagian 5)
 * Read-only: admin memantau transaksi, tidak mengubah status pembayaran
 * (status pembayaran diubah lewat alur Checkout di sisi User).
 */
class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'semua');

        $query = Order::with('user')->latest();

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(20)->withQueryString();

        $ringkasan = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'pendapatan' => Order::where('status', 'paid')->sum('total'),
        ];

        return view('admin.orders.index', compact('orders', 'status', 'ringkasan'));
    }

    public function show(Order $order): View
    {
        $order->load('user');

        return view('admin.orders.show', compact('order'));
    }
}