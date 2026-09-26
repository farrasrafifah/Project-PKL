<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang — Lovrinz</title>
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
                <a href="{{ route('user.buku.index') }}" class="hover:text-[#1B2A4A]">Buku</a>
                <a href="{{ route('user.library.index') }}" class="hover:text-[#1B2A4A]">Library</a>
                <a href="{{ route('user.menulis.index') }}" class="hover:text-[#1B2A4A]">Menulis</a>
            </nav>

            <div class="flex items-center gap-5">
                <a href="{{ route('user.keranjang.index') }}" aria-label="Keranjang" class="relative text-[#1B2A4A]">
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
    <div class="max-w-4xl mx-auto px-6 py-12">

        <div class="mb-8">
            <p class="text-xs font-semibold tracking-widest text-[#C9A24B] uppercase mb-2">Sebelum Checkout</p>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-[#1B2A4A]">Keranjang</h1>
        </div>

        @if (session('status'))
            <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                {{ session('status') }}
            </div>
        @endif

        @if ($books->isEmpty())
            <div class="bg-white rounded-2xl border border-[#E7E0D2] p-16 text-center">
                <div class="w-16 h-16 rounded-full bg-[#F7F3EA] flex items-center justify-center mx-auto mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#C9A24B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="font-display font-semibold text-lg text-[#1B2A4A]">Keranjang kamu masih kosong</h3>
                <p class="text-sm text-[#1B2A4A]/50 mt-2 mb-6">Yuk cari buku favoritmu dan mulai membaca.</p>
                <a href="{{ route('user.buku.index') }}"
                    class="inline-block bg-[#1B2A4A] text-white px-6 py-3 rounded-full text-sm font-semibold hover:bg-[#13203a] transition">
                    Jelajah Buku
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-[#E7E0D2] divide-y divide-[#E7E0D2] overflow-hidden">
                @foreach ($books as $book)
                    <div class="flex items-center gap-4 p-5">
                        <div class="w-16 h-20 rounded-lg bg-gradient-to-br from-[#1B2A4A] to-[#3A4D77] flex-shrink-0 flex items-center justify-center">
                            <span class="text-white/30 text-[10px] font-display">Cover</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-display font-semibold text-[#1B2A4A] truncate">{{ $book->title }}</h3>
                            <p class="text-sm text-[#1B2A4A]/50 mt-1">Rp{{ number_format($book->price, 0, ',', '.') }}</p>
                        </div>
                        <form action="{{ route('user.keranjang.remove', $book) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-medium transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex items-center justify-between bg-white rounded-2xl border border-[#E7E0D2] p-6">
                <span class="font-display font-semibold text-[#1B2A4A]">Total</span>
                <span class="text-2xl font-bold text-[#1B2A4A]">Rp{{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <a href="{{ route('user.checkout.create') }}"
                class="mt-6 block text-center bg-[#C9A24B] text-[#1B2A4A] text-sm font-bold px-6 py-4 rounded-full hover:bg-[#dbb35e] transition">
                Lanjut ke Checkout
            </a>
        @endif
    </div>

    <footer class="bg-[#1B2A4A] text-white/60 text-sm py-8 text-center mt-10">
        © {{ date('Y') }} LovRinz — Platform Buku Digital
    </footer>

</body>
</html>