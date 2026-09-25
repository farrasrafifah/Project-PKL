<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jelajah Buku</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="GET" action="{{ route('user.buku.index') }}" class="flex flex-col md:flex-row gap-3 mb-8">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul buku..."
                    class="flex-1 border-gray-300 rounded-lg text-sm"
                >
                <select name="genre" class="border-gray-300 rounded-lg text-sm">
                    <option value="">Semua Genre</option>
                    @foreach ($genres as $g)
                        <option value="{{ $g->slug }}" {{ request('genre') == $g->slug ? 'selected' : '' }}>
                            {{ $g->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-[#1B2A4A] text-white text-sm font-medium px-6 py-2 rounded-lg hover:bg-[#13203a]">
                    Cari
                </button>
            </form>

            @if (isset($genre))
                <p class="text-sm text-gray-500 mb-4">Menampilkan genre: <span class="font-semibold text-[#1B2A4A]">{{ $genre->name }}</span></p>
            @endif

            @if ($books->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 p-10 text-center text-gray-500">
                    Belum ada buku yang cocok.
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($books as $book)
                        <a href="{{ route('user.buku.show', $book) }}" class="bg-white rounded-2xl overflow-hidden border border-gray-200 hover:shadow-md transition block">
                            <div class="h-48 bg-gradient-to-br from-[#1B2A4A] to-[#3A4D77] flex items-center justify-center">
                                <span class="text-white/40 text-xs">Cover</span>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-sm text-[#1B2A4A] leading-snug line-clamp-2">{{ $book->title }}</h3>
                                <p class="text-xs text-gray-500 mt-1">{{ $book->author->name }}</p>
                                @if ($book->genre)
                                    <span class="inline-block mt-2 text-[10px] bg-[#F7F3EA] text-[#1B2A4A] px-2 py-1 rounded-full">
                                        {{ $book->genre->name }}
                                    </span>
                                @endif
                                <p class="text-sm font-semibold text-[#C9A24B] mt-2">
                                    Rp {{ number_format($book->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
