<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Buku (Moderasi)</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Info buku (read-only, bukan hak Admin buat diubah) --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-6 space-y-3">
                <div>
                    <p class="text-xs text-gray-500">Judul</p>
                    <p class="text-sm font-semibold text-[#1B2A4A]">{{ $book->title }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Penulis</p>
                    <p class="text-sm text-gray-700">{{ $book->author->name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Sinopsis</p>
                    <p class="text-sm text-gray-700">{{ $book->synopsis ?? '-' }}</p>
                </div>
                <p class="text-xs text-gray-400 pt-2 border-t border-gray-100">
                    Judul, sinopsis, dan isi naskah hanya bisa diubah oleh penulisnya sendiri.
                </p>
            </div>

            {{-- Form yang boleh diubah Admin --}}
            <form method="POST" action="{{ route('admin.books.update', $book) }}"
                class="bg-white rounded-2xl border border-gray-200 p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-medium text-gray-700">Genre</label>
                    <select name="genre_id" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" @selected($book->genre_id === $genre->id)>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('genre_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Harga</label>
                    <input type="number" name="price" value="{{ old('price', $book->price) }}" min="0"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                    @error('price') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 w-full rounded-lg border-gray-300 focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                        <option value="draft" @selected($book->status === 'draft')>Draft</option>
                        <option value="menunggu_review" @selected($book->status === 'menunggu_review')>Menunggu Review</option>
                        <option value="terbit" @selected($book->status === 'terbit')>Terbit</option>
                    </select>
                    @error('status') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Ubah manual kalau perlu override di luar alur normal Redaksi.</p>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <a href="{{ route('admin.books.index') }}" class="text-sm text-gray-600 px-4 py-2">Batal</a>
                    <button type="submit" class="bg-[#1B2A4A] text-white text-sm px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>