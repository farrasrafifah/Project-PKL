<section>
    <header>
        <h2 class="font-display text-lg font-semibold text-[#1B2A4A]">Informasi Profil</h2>
        <p class="mt-1 text-sm text-[#1B2A4A]/50">Perbarui nama dan alamat email akunmu.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="text-sm font-medium text-[#1B2A4A]">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                class="mt-1.5 w-full rounded-xl border-[#E7E0D2] focus:ring-[#1B2A4A] focus:border-[#1B2A4A] text-sm">
            @error('name')
                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="text-sm font-medium text-[#1B2A4A]">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                class="mt-1.5 w-full rounded-xl border-[#E7E0D2] focus:ring-[#1B2A4A] focus:border-[#1B2A4A] text-sm">
            @error('email')
                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-amber-50 border border-amber-100 rounded-xl px-4 py-3">
                    <p class="text-xs text-amber-800">
                        Alamat email kamu belum diverifikasi.
                        <button form="send-verification" class="underline font-medium hover:text-amber-900">
                            Kirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-xs font-medium text-green-700">
                            Link verifikasi baru telah dikirim ke email kamu.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit"
                class="bg-[#1B2A4A] text-white text-sm font-semibold px-6 py-2.5 rounded-full hover:bg-[#13203a] transition">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-700 font-medium">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>