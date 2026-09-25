<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Naskah Baru
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl border border-gray-200 p-8">

                <h1 class="text-2xl font-bold text-[#1B2A4A] mb-6">
                    Buat Naskah Baru
                </h1>

                {{-- Pesan error --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                        <p class="font-semibold text-red-700 mb-2">
                            Ada data yang belum benar:
                        </p>

                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('user.menulis.store') }}" method="POST">
                    @csrf

                    {{-- Judul --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Judul
                        </label>

                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Masukkan judul naskah"
                            required
                        >
                    </div>

                    {{-- Genre --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Genre
                        </label>

                        <select
                            name="genre_id"
                            class="w-full rounded-lg border-gray-300"
                            required
                        >
                            <option value="">Pilih Genre</option>

                            @foreach ($genres as $genre)
                                <option
                                    value="{{ $genre->id }}"
                                    {{ old('genre_id') == $genre->id ? 'selected' : '' }}
                                >
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sinopsis --}}
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sinopsis
                        </label>

                        <textarea
                            name="synopsis"
                            rows="6"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Tulis sinopsis naskah..."
                            required
                        >{{ old('synopsis') }}</textarea>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex gap-3">

                        <a
                            href="{{ route('user.menulis.index') }}"
                            class="px-5 py-3 rounded-full border border-gray-300 text-gray-600"
                        >
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="bg-[#1B2A4A] text-white px-6 py-3 rounded-full"
                        >
                            Simpan Naskah
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
