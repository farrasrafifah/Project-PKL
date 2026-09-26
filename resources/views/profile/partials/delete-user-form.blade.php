<section class="space-y-4">
    <header>
        <h2 class="font-display text-lg font-semibold text-red-700">Hapus Akun</h2>
        <p class="mt-1 text-sm text-[#1B2A4A]/50">
            Setelah akun dihapus, semua data akan hilang permanen. Unduh data yang ingin kamu simpan sebelum melanjutkan.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 text-white text-sm font-semibold px-6 py-2.5 rounded-full hover:bg-red-700 transition">
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 font-body">
            @csrf
            @method('delete')

            <h2 class="font-display text-lg font-semibold text-[#1B2A4A]">
                Yakin mau hapus akun ini?
            </h2>

            <p class="mt-2 text-sm text-[#1B2A4A]/60">
                Setelah akun dihapus, semua data akan hilang permanen. Masukkan password untuk konfirmasi.
            </p>

            <div class="mt-5">
                <label for="password" class="sr-only">Password</label>
                <input id="password" name="password" type="password" placeholder="Password"
                    class="mt-1 block w-3/4 rounded-xl border-[#E7E0D2] focus:ring-[#1B2A4A] focus:border-[#1B2A4A] text-sm">
                @error('password', 'userDeletion')
                    <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="text-sm font-medium text-[#1B2A4A]/60 hover:text-[#1B2A4A] px-4 py-2 transition">
                    Batal
                </button>
                <button type="submit"
                    class="bg-red-600 text-white text-sm font-semibold px-6 py-2.5 rounded-full hover:bg-red-700 transition">
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>