<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Buku</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-200 p-8 grid md:grid-cols-3 gap-8">

                <div class="h-72 bg-gradient-to-br from-[#1B2A4A] to-[#3A4D77] rounded-2xl flex items-center justify-center">
                    <span class="text-white/40 text-xs">Cover</span>
                </div>

                <div class="md:col-span-2">
                    @if ($book->genre)
                        <span class="inline-block text-xs bg-[#F7F3EA] text-[#1B2A4A] px-3 py-1 rounded-full mb-3">
                            {{ $book->genre->name }}
                        </span>
                    @endif

                    <h1 class="font-bold text-2xl text-[#1B2A4A]">{{ $book->title }}</h1>
                    <p class="text-sm text-gray-500 mt-1">oleh {{ $book->author->name }}</p>

                    <p class="text-gray-600 text-sm mt-5 leading-relaxed">
                        {{ $book->synopsis }}
                    </p>

                    <p class="text-xl font-semibold text-[#C9A24B] mt-6">
                        Rp {{ number_format($book->price, 0, ',', '.') }}
                    </p>

                    <div class="flex gap-3 mt-6">
                        @if ($sudahDimiliki)
                            <a href="{{ route('user.buku.read', $book) }}" class="bg-[#1B2A4A] text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-[#13203a]">
                                Baca Sekarang
                            </a>
                        @else
                            <form action="{{ route('user.keranjang.add', $book) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-[#1B2A4A] text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-[#13203a]">
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
