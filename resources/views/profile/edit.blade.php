<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Saya — Lovrinz</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700|inter:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-display { font-family: 'Fraunces', serif; }
        .font-body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-body bg-[#F7F3EA] text-[#1B2A4A] min-h-screen flex flex-col">

    @php
        $backRoute = match (auth()->user()->role ?? null) {
            'admin'   => route('admin.dashboard'),
            'redaksi' => route('redaksi.dashboard'),
            default   => route('home'),
        };
    @endphp

   {{-- ===================== NAVBAR ===================== --}}
<header class="bg-white border-b border-[#E7E0D2] sticky top-0 z-50">
    <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ $backRoute }}" class="inline-flex items-center gap-2 text-sm font-medium text-[#1B2A4A]/70 hover:text-[#1B2A4A] transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <span class="font-display text-xl font-bold tracking-tight text-[#1B2A4A]">LOVRINZ</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-red-600 hover:text-red-700 transition">
                Logout
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </form>
    </div>
</header>

    {{-- ===================== KONTEN ===================== --}}
    <div class="max-w-2xl mx-auto px-6 py-12 flex-1 w-full">

        <div class="flex items-center gap-4 mb-10">
            <div class="w-14 h-14 rounded-full bg-[#1B2A4A]/10 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-[#1B2A4A]">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-4.418 3.582-8 8-8s8 3.582 8 8v1H4v-1z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold tracking-widest text-[#C9A24B] uppercase mb-1">Pengaturan Akun</p>
                <h1 class="font-display text-2xl md:text-3xl font-bold text-[#1B2A4A]">Profil Saya</h1>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-[#E7E0D2] p-6 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="bg-white rounded-2xl border border-[#E7E0D2] p-6 sm:p-8">
                @include('profile.partials.update-password-form')
            </div>

            <div class="bg-white rounded-2xl border border-red-100 p-6 sm:p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    <footer class="bg-[#1B2A4A] text-white/60 text-sm py-8 text-center">
        © {{ date('Y') }} LovRinz — Platform Buku Digital
    </footer>

</body>
</html>