<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Genre</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.genres.store') }}"
                class="bg-white rounded-2xl border border-gray-200 p-6 space-y-4">
                @csrf

                <div>
                    <label class="text-sm font-medium text-gray-700">Nama Genre</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.genres.index') }}" class="text-sm text-gray-600 px-4 py-2">Batal</a>
                    <button type="submit" class="bg-[#1B2A4A] text-white text-sm px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>