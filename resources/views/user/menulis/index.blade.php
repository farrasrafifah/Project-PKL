<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Karya Saya — Lovrinz</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700|inter:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-display { font-family: 'Fraunces', serif; }
        .font-body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-body bg-[#F7F3EA] text-[#1B2A4A] min-h-screen flex flex-col">

    {{-- ===================== NAVBAR ===================== --}}
    <header class="bg-white border-b border-[#E7E0D2] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-display text-2xl font-bold tracking-tight text-[#1B2A4A]">
                LOVRINZ
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-[#1B2A4A]/80">
                <a href="{{ route('home') }}" class="hover:text-[#1B2A4A]">Home</a>
                <a href="{{ route('user.buku.index') }}" class="hover:text-[#1B2A4A]">Buku</a>
                <a href="{{ route('user.library.index') }}" class="hover:text-[#1B2A4A]">Library</a>
                <a href="{{ route('user.menulis.index') }}" class="text-[#1B2A4A] font-semibold">Menulis</a>
            </nav>

            <div class="flex items-center gap-5">
                <a href="{{ route('user.keranjang.index') }}" aria-label="Keranjang" class="relative text-[#1B2A4A]/70 hover:text-[#1B2A4A]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </a>
                <a href="{{ route('profile.edit') }}" aria-label="Profil Saya"
                    class="w-9 h-9 rounded-full bg-[#1B2A4A]/10 hover:bg-[#1B2A4A] flex items-center justify-center transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-[#1B2A4A] group-hover:text-white transition">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M4 20c0-4.418 3.582-8 8-8s8 3.582 8 8v1H4v-1z" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    {{-- ===================== KONTEN ===================== --}}
    <div class="max-w-5xl mx-auto px-6 py-12 flex-1 w-full">

        <div class="flex items-center justify-between flex-wrap gap-4 mb-10">
            <div>
                <p class="text-xs font-semibold tracking-widest text-[#C9A24B] uppercase mb-2">Ruang Penulis</p>
                <h1 class="font-display text-3xl md:text-4xl font-bold text-[#1B2A4A]">Karya Saya</h1>
            </div>
            <a href="{{ route('user.menulis.create') }}"
                class="inline-flex items-center gap-2 bg-[#1B2A4A] text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-[#13203a] transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Buat Naskah Baru
            </a>
        </div>

        @if ($naskahList->isEmpty())
            <div class="bg-white rounded-2xl border border-[#E7E0D2] p-16 text-center">
                <div class="w-16 h-16 rounded-full bg-[#F7F3EA] flex items-center justify-center mx-auto mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#C9A24B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h3 class="font-display font-semibold text-lg text-[#1B2A4A]">Kamu belum punya naskah</h3>
                <p class="text-sm text-[#1B2A4A]/50 mt-2">Yuk mulai menulis dan wujudkan ceritamu!</p>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-[#E7E0D2] divide-y divide-[#E7E0D2] overflow-hidden">
                @foreach ($naskahList as $naskah)
                    <div class="flex items-center justify-between p-5 hover:bg-[#F7F3EA]/50 transition-colors">
                        <div class="min-w-0">
                            <h3 class="font-display font-semibold text-[#1B2A4A] truncate">{{ $naskah->title }}</h3>
                            <div class="flex items-center gap-2 mt-1.5">
                                @if ($naskah->genre)
                                    <span class="text-xs bg-[#F7F3EA] text-[#1B2A4A]/70 px-2.5 py-0.5 rounded-full">
                                        {{ $naskah->genre->name }}
                                    </span>
                                @endif
                                <span @class([
                                    'text-xs capitalize px-2.5 py-0.5 rounded-full',
                                    'bg-green-50 text-green-700' => $naskah->status === 'terbit',
                                    'bg-amber-50 text-amber-700' => $naskah->status === 'menunggu_review',
                                    'bg-gray-100 text-gray-500' => !in_array($naskah->status, ['terbit', 'menunggu_review']),
                                ])>
                                    {{ str_replace('_', ' ', $naskah->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 flex-shrink-0 ml-4">
                            <a href="{{ route('user.menulis.status', $naskah) }}" class="text-sm text-[#1B2A4A]/50 hover:text-[#1B2A4A] transition">
                                Status
                            </a>
                            <a href="{{ route('user.menulis.edit', $naskah) }}"
                                class="text-sm text-white bg-[#C9A24B] font-medium px-4 py-2 rounded-full hover:bg-[#dbb35e] transition">
                                Kelola
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <footer class="bg-[#1B2A4A] text-white/60 text-sm py-8 text-center">
        © {{ date('Y') }} LovRinz — Platform Buku Digital
    </footer>

</body>
</html>