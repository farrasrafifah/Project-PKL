<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Akun Redaksi</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.redaksi.update', $redaksi) }}"
                class="bg-white rounded-2xl border border-gray-200 p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $redaksi->name) }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $redaksi->email) }}"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                    @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                    @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.redaksi.index') }}" class="text-sm text-gray-600 px-4 py-2">Batal</a>
                    <button type="submit" class="bg-[#1B2A4A] text-white text-sm px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>