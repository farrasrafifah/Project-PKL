<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Naskah: {{ $naskah->title }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Pesan sukses --}}
            @if (session('status'))
                <div class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Pesan sukses dari controller --}}
            @if (session('success'))
                <div class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error validasi --}}
            @if ($errors->any())
                <div class="text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Status Naskah --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Status Naskah</p>

                    <p class="font-semibold text-[#1B2A4A] capitalize">
                        {{ str_replace('_', ' ', $naskah->status) }}
                    </p>
                </div>

                @if ($naskah->status === 'draft' || $naskah->status === 'revisi')
                    <form
                        action="{{ route('user.menulis.submit', $naskah) }}"
                        method="POST"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="bg-[#C9A24B] text-[#1B2A4A] text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-[#dbb35e]"
                        >
                            Kirim ke Redaksi
                        </button>
                    </form>
                @endif
            </div>

            {{-- Form edit judul/genre/sinopsis --}}
            <form
                action="{{ route('user.menulis.update', $naskah) }}"
                method="POST"
                class="bg-white rounded-2xl border border-gray-200 p-6 space-y-4"
            >
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Judul
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $naskah->title) }}"
                        class="mt-1 block w-full border-gray-300 rounded-lg"
                        required
                    >
                </div>

                {{-- Genre --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Genre
                    </label>

                    <select
                        name="genre_id"
                        class="mt-1 block w-full border-gray-300 rounded-lg"
                        required
                    >
                        @foreach ($genres as $genre)
                            <option
                                value="{{ $genre->id }}"
                                {{ old('genre_id', $naskah->genre_id) == $genre->id ? 'selected' : '' }}
                            >
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sinopsis --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Sinopsis
                    </label>

                    <textarea
                        name="synopsis"
                        rows="4"
                        class="mt-1 block w-full border-gray-300 rounded-lg"
                        required
                    >{{ old('synopsis', $naskah->synopsis) }}</textarea>
                </div>

                <button
                    type="submit"
                    class="text-sm bg-[#1B2A4A] text-white px-5 py-2.5 rounded-full hover:bg-[#13203a]"
                >
                    Simpan Perubahan
                </button>
            </form>

            {{-- Catatan revisi dari redaksi --}}
            @if ($naskah->reviews && $naskah->reviews->isNotEmpty())
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">

                    <h3 class="font-semibold text-sm text-yellow-800 mb-3">
                        Catatan dari Redaksi
                    </h3>

                    @foreach ($naskah->reviews as $review)
                        <p class="text-sm text-yellow-700 mb-2">
                            {{ $review->catatan }}
                        </p>
                    @endforeach

                </div>
            @endif

            {{-- Daftar Chapter --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6">

                <h3 class="font-semibold text-[#1B2A4A] mb-4">
                    Chapter
                </h3>

                @if ($naskah->chapters && $naskah->chapters->isNotEmpty())

                    @foreach ($naskah->chapters as $chapter)
                        <div class="border border-gray-100 rounded-xl p-4 mb-3">

                            <p class="text-xs text-gray-500 mb-1">
                                Bab {{ $chapter->chapter_number }}
                            </p>

                            <p class="font-medium text-sm mb-2">
                                {{ $chapter->title }}
                            </p>

                            <p class="text-xs text-gray-500 line-clamp-2">
                                {{ $chapter->content }}
                            </p>

                        </div>
                    @endforeach

                @else

                    <p class="text-sm text-gray-500 mb-4">
                        Belum ada chapter. Silakan tambahkan chapter pertama.
                    </p>

                @endif

                {{-- Form tambah chapter baru --}}
                <form
                    action="{{ route('user.menulis.chapter.store', $naskah) }}"
                    method="POST"
                    class="mt-4 space-y-3 border-t border-gray-100 pt-4"
                >
                    @csrf

                    <input
                        type="text"
                        name="title"
                        placeholder="Judul chapter"
                        class="block w-full border-gray-300 rounded-lg text-sm"
                        required
                    >

                    <textarea
                        name="content"
                        rows="6"
                        placeholder="Tulis isi chapter di sini..."
                        class="block w-full border-gray-300 rounded-lg text-sm"
                        required
                    ></textarea>

                    <button
                        type="submit"
                        class="text-sm bg-[#1B2A4A] text-white px-5 py-2.5 rounded-full hover:bg-[#13203a]"
                    >
                        + Tambah Chapter
                    </button>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>
