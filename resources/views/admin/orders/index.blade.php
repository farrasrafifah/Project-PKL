<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lihat Transaksi</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Ringkasan --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Total Transaksi</p>
                    <p class="text-2xl font-bold text-[#1B2A4A] mt-1">{{ $ringkasan['total'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-[#1B2A4A] mt-1">{{ $ringkasan['pending'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Dibatalkan</p>
                    <p class="text-2xl font-bold text-[#1B2A4A] mt-1">{{ $ringkasan['cancelled'] }}</p>
                </div>
                <div class="bg-[#1B2A4A] rounded-2xl p-5">
                    <p class="text-xs text-white/70">Pendapatan (paid)</p>
                    <p class="text-2xl font-bold text-white mt-1">
                        Rp{{ number_format($ringkasan['pendapatan'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Filter status --}}
            <form method="GET" class="flex gap-2">
                <select name="status" onchange="this.form.submit()"
                    class="rounded-lg border-gray-300 text-sm focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                    <option value="semua" @selected($status === 'semua')>Semua Status</option>
                    <option value="pending" @selected($status === 'pending')>Pending</option>
                    <option value="paid" @selected($status === 'paid')>Paid</option>
                    <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
                </select>
            </form>

            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-[#F7F3EA] text-[#1B2A4A]">
                        <tr>
                            <th class="text-left px-5 py-3 font-semibold">User</th>
                            <th class="text-left px-5 py-3 font-semibold">Total</th>
                            <th class="text-left px-5 py-3 font-semibold">Status</th>
                            <th class="text-left px-5 py-3 font-semibold">Tanggal</th>
                            <th class="text-right px-5 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-5 py-4 font-medium text-[#1B2A4A]">{{ $order->user->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-gray-600">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-5 py-4">
                                    <span @class([
                                        'text-xs capitalize px-2.5 py-1 rounded-full',
                                        'bg-green-50 text-green-700' => $order->status === 'paid',
                                        'bg-yellow-50 text-yellow-700' => $order->status === 'pending',
                                        'bg-red-50 text-red-700' => $order->status === 'cancelled',
                                    ])>
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-[#1B2A4A] hover:underline">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-gray-500">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>