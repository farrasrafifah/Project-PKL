<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Transaksi #{{ $order->id }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500">Pemesan</p>
                        <p class="text-sm font-semibold text-[#1B2A4A]">{{ $order->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</p>
                    </div>
                    <span @class([
                        'text-xs capitalize px-3 py-1.5 rounded-full',
                        'bg-green-50 text-green-700' => $order->status === 'paid',
                        'bg-yellow-50 text-yellow-700' => $order->status === 'pending',
                        'bg-red-50 text-red-700' => $order->status === 'cancelled',
                    ])>
                        {{ $order->status }}
                    </span>
                </div>

                <div class="border-t border-gray-100 pt-4 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Total</p>
                        <p class="text-lg font-bold text-[#1B2A4A]">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Tanggal</p>
                        <p class="text-sm text-gray-700">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.orders.index') }}" class="text-sm text-[#1B2A4A] hover:underline">&larr; Kembali ke daftar transaksi</a>
        </div>
    </div>
</x-app-layout>