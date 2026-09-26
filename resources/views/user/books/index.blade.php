<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jelajah Buku — Lovrinz</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700|inter:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-display { font-family: 'Fraunces', serif; }
        .font-body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-body bg-[#F7F3EA] text-[#1B2A4A]">

    {{-- ===================== NAVBAR ===================== --}}
    <header class="bg-white border-b border-[#E7E0D2] sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="font-display text-2xl font-bold tracking-tight text-[#1B2A4A]">
                LOVRINZ
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-[#1B2A4A]/80">
                <a href="{{ route('home') }}" class="hover:text-[#1B2A4A]">Home</a>
                <a href="{{ route('user.buku.index') }}" class="text-[#1B2A4A] font-semibold">Buku</a>
                @auth
                    <a href="{{ route('user.library.index') }}" class="hover:text-[#1B2A4A]">Library</a>
                    <a href="{{ route('user.menulis.index') }}" class="hover:text-[#1B2A4A]">Menulis</a>
                @endauth
            </nav>

            <div class="flex items-center gap-5">
                @auth
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
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium border border-[#1B2A4A]/20 rounded-full px-4 py-1.5 hover:bg-[#1B2A4A] hover:text-white transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-sm font-medium bg-[#1B2A4A] text-white rounded-full px-4 py-1.5 hover:bg-[#13203a] transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- ===================== KONTEN ===================== --}}
    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="mb-8">
            <p class="text-xs font-semibold tracking-widest text-[#C9A24B] uppercase mb-2">Perpustakaan Digital</p>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-[#1B2A4A]">Jelajah Buku</h1>
        </div>

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('user.buku.index') }}"
            class="flex flex-col md:flex-row gap-3 mb-10 bg-white p-3 rounded-2xl border border-[#E7E0D2]">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-[#1B2A4A]/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari judul buku..."
                    class="w-full border-0 focus:ring-0 text-sm pl-9 py-2 bg-transparent"
                >
            </div>
            <select name="genre" class="border border-[#E7E0D2] rounded-xl text-sm focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                <option value="">Semua Genre</option>
                @foreach ($genres as $g)
                    <option value="{{ $g->slug }}" @selected(request('genre') == $g->slug)>
                        {{ $g->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-[#1B2A4A] text-white text-sm font-medium px-6 py-2.5 rounded-xl hover:bg-[#13203a] transition">
                Cari
            </button>
        </form>

        @if (isset($genre))
            <div class="flex items-center gap-2 mb-6">
                <p class="text-sm text-[#1B2A4A]/60">Menampilkan genre:</p>
                <span class="text-sm font-semibold bg-[#F7F3EA] border border-[#E7E0D2] text-[#1B2A4A] px-3 py-1 rounded-full">
                    {{ $genre->name }}
                </span>
            </div>
        @endif

        {{-- Grid Buku --}}
        @if ($books->isEmpty())
            <div class="bg-white rounded-2xl border border-[#E7E0D2] p-14 text-center">
                <p class="font-display text-lg text-[#1B2A4A] mb-1">Belum ada buku yang cocok</p>
                <p class="text-sm text-[#1B2A4A]/50">Coba kata kunci atau genre lain.</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($books as $book)
                    <a href="{{ route('user.buku.show', $book) }}"
                        class="group bg-white rounded-2xl overflow-hidden border border-[#E7E0D2] hover:shadow-lg hover:-translate-y-1 transition-all duration-200 block">
                        <div class="h-56 bg-gradient-to-br from-[#1B2A4A] to-[#3A4D77] flex items-center justify-center relative overflow-hidden">
                            <span class="font-display text-white/30 text-sm">Cover</span>
                            @if ($book->genre)
                                <span class="absolute top-3 left-3 text-[10px] font-semibold bg-white/90 text-[#1B2A4A] px-2.5 py-1 rounded-full">
                                    {{ $book->genre->name }}
                                </span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-sm text-[#1B2A4A] leading-snug line-clamp-2 group-hover:text-[#C9A24B] transition-colors">
                                {{ $book->title }}
                            </h3>
                            <p class="text-xs text-[#1B2A4A]/50 mt-1">{{ $book->author->name ?? '-' }}</p>
                            <p class="text-sm font-bold text-[#1B2A4A] mt-3">
                                Rp{{ number_format($book->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $books->links() }}
            </div>
        @endif
    </div>

    <footer class="bg-[#1B2A4A] text-white/60 text-sm py-8 text-center mt-10">
        © {{ date('Y') }} LovRinz — Platform Buku Digital
    </footer>

</body>
</html>