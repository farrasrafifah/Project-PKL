<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Admin</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('status'))
                <div class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Kartu Ringkasan --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Total User</p>
                    <p class="text-2xl font-bold text-[#1B2A4A] mt-1">{{ $stats['total_user'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Total Redaksi</p>
                    <p class="text-2xl font-bold text-[#1B2A4A] mt-1">{{ $stats['total_redaksi'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Total Buku / Naskah</p>
                    <p class="text-2xl font-bold text-[#1B2A4A] mt-1">{{ $stats['total_buku'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Total Genre</p>
                    <p class="text-2xl font-bold text-[#1B2A4A] mt-1">{{ $stats['total_genre'] }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-5">
                    <p class="text-xs text-gray-500">Total Transaksi</p>
                    <p class="text-2xl font-bold text-[#1B2A4A] mt-1">{{ $stats['total_transaksi'] }}</p>
                </div>
                <div class="bg-[#1B2A4A] rounded-2xl p-5">
                    <p class="text-xs text-white/70">Pendapatan (transaksi berhasil)</p>
                    <p class="text-2xl font-bold text-white mt-1">
                        Rp{{ number_format($stats['pendapatan'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Menu Kelola --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-500 mb-3">Kelola</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.users.index') }}" class="bg-white rounded-2xl border border-gray-200 p-5 hover:border-[#1B2A4A] transition">
                        <p class="font-semibold text-[#1B2A4A]">Kelola User</p>
                        <p class="text-xs text-gray-500 mt-1">Atur akun pelanggan</p>
                    </a>
                    <a href="{{ route('admin.redaksi.index') }}" class="bg-white rounded-2xl border border-gray-200 p-5 hover:border-[#1B2A4A] transition">
                        <p class="font-semibold text-[#1B2A4A]">Kelola Redaksi</p>
                        <p class="text-xs text-gray-500 mt-1">Atur akun tim redaksi</p>
                    </a>
                    <a href="{{ route('admin.books.index') }}" class="bg-white rounded-2xl border border-gray-200 p-5 hover:border-[#1B2A4A] transition">
                        <p class="font-semibold text-[#1B2A4A]">Kelola Ebook / Buku</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $stats['total_buku'] }} judul terdaftar</p>
                    </a>
                    <a href="{{ route('admin.genres.index') }}" class="bg-white rounded-2xl border border-gray-200 p-5 hover:border-[#1B2A4A] transition">
                        <p class="font-semibold text-[#1B2A4A]">Kelola Genre</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $stats['total_genre'] }} genre</p>
                    </a>
                </div>
            </div>

            {{-- Breakdown status naskah --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-[#1B2A4A] mb-4">Naskah per Status</h3>
                <div class="flex flex-wrap gap-3">
                    @forelse ($bukuPerStatus as $status => $total)
                        <span class="text-xs bg-[#F7F3EA] text-[#1B2A4A] px-3 py-1.5 rounded-full capitalize">
                            {{ str_replace('_', ' ', $status) }}: <span class="font-semibold">{{ $total }}</span>
                        </span>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada data naskah.</p>
                    @endforelse
                </div>
            </div>

            {{-- Transaksi terbaru --}}
            <div class="bg-white rounded-2xl border border-gray-200">
                <div class="p-6 pb-0 flex items-center justify-between">
                    <h3 class="font-semibold text-[#1B2A4A]">Transaksi Terbaru</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-[#C9A24B] font-medium hover:underline">Lihat semua →</a>
                </div>
                <div class="divide-y divide-gray-100 mt-4">
                    @forelse ($transaksiTerbaru as $order)
                        <div class="flex items-center justify-between p-5">
                            <div>
                                <p class="text-sm font-medium text-[#1B2A4A]">{{ $order->user->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                                <span class="text-xs capitalize {{ $order->status === 'paid' ? 'text-green-600' : 'text-gray-500' }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 p-6">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>