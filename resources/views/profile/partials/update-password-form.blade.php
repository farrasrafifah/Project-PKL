<section>
    <header>
        <h2 class="font-display text-lg font-semibold text-[#1B2A4A]">Ubah Password</h2>
        <p class="mt-1 text-sm text-[#1B2A4A]/50">Gunakan password yang panjang dan acak biar akunmu tetap aman.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="text-sm font-medium text-[#1B2A4A]">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="mt-1.5 w-full rounded-xl border-[#E7E0D2] focus:ring-[#1B2A4A] focus:border-[#1B2A4A] text-sm">
            @error('current_password', 'updatePassword')
                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="text-sm font-medium text-[#1B2A4A]">Password Baru</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="mt-1.5 w-full rounded-xl border-[#E7E0D2] focus:ring-[#1B2A4A] focus:border-[#1B2A4A] text-sm">
            @error('password', 'updatePassword')
                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="text-sm font-medium text-[#1B2A4A]">Konfirmasi Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="mt-1.5 w-full rounded-xl border-[#E7E0D2] focus:ring-[#1B2A4A] focus:border-[#1B2A4A] text-sm">
            @error('password_confirmation', 'updatePassword')
                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="bg-[#1B2A4A] text-white text-sm font-semibold px-6 py-2.5 rounded-full hover:bg-[#13203a] transition">
                Simpan
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-700 font-medium">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>