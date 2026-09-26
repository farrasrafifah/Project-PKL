<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Ebook / Buku</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="GET" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul buku..."
                    class="rounded-lg border-gray-300 text-sm focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                <select name="status" class="rounded-lg border-gray-300 text-sm">
                    <option value="">Semua Status</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="menunggu_review" @selected(request('status') === 'menunggu_review')>Menunggu Review</option>
                    <option value="terbit" @selected(request('status') === 'terbit')>Terbit</option>
                </select>
                <button type="submit"
                    class="bg-[#1B2A4A] text-white text-sm px-4 py-2 rounded-lg hover:bg-[#243756]">
                    Cari
                </button>
            </form>

            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-[#F7F3EA] text-[#1B2A4A]">
                        <tr>
                            <th class="text-left px-5 py-3 font-semibold">Judul</th>
                            <th class="text-left px-5 py-3 font-semibold">Penulis</th>
                            <th class="text-left px-5 py-3 font-semibold">Genre</th>
                            <th class="text-left px-5 py-3 font-semibold">Harga</th>
                            <th class="text-left px-5 py-3 font-semibold">Status</th>
                            <th class="text-right px-5 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($books as $book)
                            <tr>
                                <td class="px-5 py-4 font-medium text-[#1B2A4A]">{{ $book->title }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $book->author->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $book->genre->name ?? '-' }}</td>
                                <td class="px-5 py-4 text-gray-600">Rp{{ number_format($book->price, 0, ',', '.') }}</td>
                                <td class="px-5 py-4">
                                    <span class="text-xs capitalize px-2.5 py-1 rounded-full
                                        {{ $book->status === 'terbit' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ str_replace('_', ' ', $book->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.books.edit', $book) }}"
                                        class="text-[#1B2A4A] hover:underline">Edit</a>
                                    <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-8 text-center text-gray-500">Belum ada buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $books->links() }}
        </div>
    </div>
</x-admin-layout>