<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Library Saya
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-[#1B2A4A]">
                    Library Saya
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Koleksi buku yang kamu simpan.
                </p>
            </div>

            @if ($libraries->isEmpty())

                <div class="bg-white rounded-2xl border border-gray-200 p-10 text-center">

                    <div class="text-4xl mb-4">
                        📚
                    </div>

                    <h3 class="font-semibold text-lg text-[#1B2A4A]">
                        Library masih kosong
                    </h3>

                    <p class="text-sm text-gray-500 mt-2 mb-5">
                        Belum ada buku yang tersimpan di library kamu.
                    </p>

                    <a
                        href="{{ route('user.buku.index') }}"
                        class="inline-block bg-[#1B2A4A] text-white px-6 py-3 rounded-full text-sm font-semibold"
                    >
                        Jelajahi Buku
                    </a>

                </div>

            @else

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                    @foreach ($libraries as $library)

                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

                            {{-- Cover --}}
                            <div class="h-52 bg-gray-100 flex items-center justify-center">

                                @if (isset($library->book) && $library->book && $library->book->cover)
                                    <img
                                        src="{{ asset('storage/' . $library->book->cover) }}"
                                        alt="{{ $library->book->title }}"
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <div class="text-gray-400 text-4xl">
                                        📖
                                    </div>
                                @endif

                            </div>

                            {{-- Informasi buku --}}
                            <div class="p-5">

                                <h3 class="font-bold text-lg text-[#1B2A4A]">
                                    {{ $library->book->title ?? 'Buku' }}
                                </h3>

                                @if (isset($library->book) && $library->book)

                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $library->book->author ?? 'Penulis tidak diketahui' }}
                                    </p>

                                    @if ($library->book->genre)
                                        <span class="inline-block mt-3 text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                                            {{ $library->book->genre->name }}
                                        </span>
                                    @endif

                                    <div class="mt-5">

                                        <a
                                            href="{{ route('user.buku.show', $library->book) }}"
                                            class="block text-center bg-[#1B2A4A] text-white px-4 py-2.5 rounded-full text-sm font-semibold"
                                        >
                                            Lihat Buku
                                        </a>

                                    </div>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>
    </div>

</x-app-layout>