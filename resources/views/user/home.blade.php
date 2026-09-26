<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lovrinz — Home</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700|inter:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-display { font-family: 'Fraunces', serif; }
        .font-body { font-family: 'Inter', sans-serif; }

        /* ===== Hero Carousel ===== */
        .hero-carousel {
            position: relative;
            overflow: hidden;
        }
        .hero-carousel .slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        .hero-carousel .slide.active {
            opacity: 1;
        }
        .hero-carousel .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .hero-carousel .slide::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(27,42,74,0) 40%, rgba(27,42,74,0.55) 100%);
        }
        .hero-carousel .dots {
            position: absolute;
            bottom: 16px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 8px;
            z-index: 10;
        }
        .hero-carousel .dot {
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            border: none;
            padding: 0;
            transition: background .3s, width .3s;
        }
        .hero-carousel .dot.active {
            background: #C9A24B;
            width: 22px;
        }
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
                @auth
                    <a href="{{ route('user.library.index') }}" class="hover:text-[#1B2A4A]">Library</a>
                    <a href="{{ route('user.menulis.index') }}" class="hover:text-[#1B2A4A]">Menulis</a>
                @endauth
            </nav>

            <div class="flex items-center gap-5">
                <a href="{{ route('user.buku.index') }}" aria-label="Cari buku" class="text-[#1B2A4A]/70 hover:text-[#1B2A4A]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                    </svg>
                </a>

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

    {{-- ===================== HERO ===================== --}}
    <section class="max-w-7xl mx-auto px-6 py-14 grid md:grid-cols-2 gap-10 items-center">
        <div>
            <p class="text-xs font-semibold tracking-widest text-[#C9A24B] uppercase mb-4">Baca. Tulis. Terbitkan.</p>
            <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight text-[#1B2A4A]">
                Dunia LovRinz<br> untuk Membaca & Menulis
            </h1>
            <p class="mt-5 text-[#1B2A4A]/70 max-w-md">
                Jelajahi ribuan ebook, simpan ke library pribadimu, atau mulai tulis naskahmu sendiri — semuanya dalam satu akun.
            </p>
            <div class="mt-8 flex gap-3">
                <a href="{{ route('user.buku.index') }}" class="bg-[#1B2A4A] text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-[#13203a] transition">
                    Jelajahi Buku
                </a>
                @auth
                    <a href="{{ route('user.menulis.index') }}" class="border border-[#1B2A4A]/20 text-[#1B2A4A] text-sm font-medium px-6 py-3 rounded-full hover:bg-white transition">
                        Mulai Menulis
                    </a>
                @else
                    <a href="{{ route('register') }}" class="border border-[#1B2A4A]/20 text-[#1B2A4A] text-sm font-medium px-6 py-3 rounded-full hover:bg-white transition">
                        Daftar & Mulai Menulis
                    </a>
                @endauth
            </div>
        </div>

        {{-- Hero Carousel (foto rak buku, auto-slide) --}}
        <div class="hero-carousel rounded-3xl h-72 md:h-96" id="heroCarousel">
            <div class="slide active">
                <img src="{{ asset('images/hero/hero-1.jpg') }}" alt="Rak buku Gramedia">
            </div>
            <div class="slide">
                <img src="{{ asset('images/hero/hero-2.jpg') }}" alt="Rak novel">
            </div>
            <div class="slide">
                <img src="{{ asset('images/hero/hero-3.jpg') }}" alt="Rak buku koleksi">
            </div>

            <div class="dots">
                <button class="dot active" data-index="0" aria-label="Slide 1"></button>
                <button class="dot" data-index="1" aria-label="Slide 2"></button>
                <button class="dot" data-index="2" aria-label="Slide 3"></button>
            </div>
        </div>
    </section>

    {{-- ===================== LANJUTKAN MEMBACA (hanya untuk user login) ===================== --}}
    @auth
        <section class="max-w-7xl mx-auto px-6 py-10">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-display text-2xl font-semibold text-[#1B2A4A]">Lanjutkan Membaca</h2>
                <a href="{{ route('user.library.index') }}" class="text-sm text-[#C9A24B] font-medium hover:underline">Lihat semua</a>
            </div>

            @if ($recentBooks->isEmpty())
                <div class="bg-white rounded-2xl border border-[#E7E0D2] p-8 text-center text-gray-500 text-sm">
                    Belum ada ebook di library kamu.
                    <a href="{{ route('user.buku.index') }}" class="text-[#C9A24B] font-medium hover:underline">Jelajah buku sekarang</a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($recentBooks as $book)
                        <a href="{{ route('user.buku.read', $book) }}" class="bg-white rounded-2xl overflow-hidden border border-[#E7E0D2] hover:shadow-md transition block">
                            <div class="h-48 bg-gradient-to-br from-[#1B2A4A] to-[#3A4D77] flex items-center justify-center">
                                <span class="text-white/40 font-display text-xs">Cover</span>
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-sm text-[#1B2A4A] leading-snug line-clamp-2">{{ $book->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- ===================== KARYA SAYA (hanya untuk user login) ===================== --}}
        <section class="max-w-7xl mx-auto px-6 py-10">
            <div class="bg-[#1B2A4A] rounded-3xl p-10">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs font-semibold tracking-widest text-[#C9A24B] uppercase mb-2">Karya Saya</p>
                        <h3 class="font-display text-2xl font-bold text-white">Naskah yang Sedang Kamu Tulis</h3>
                    </div>
                    <a href="{{ route('user.menulis.index') }}" class="text-sm text-white/70 hover:text-white font-medium">
                        Lihat semua →
                    </a>
                </div>

                @if ($recentBooks_written->isEmpty())
                    <div class="bg-white/10 rounded-2xl p-6 text-center text-white/70 text-sm">
                        Kamu belum punya naskah.
                        <a href="{{ route('user.menulis.create') }}" class="text-[#C9A24B] font-medium hover:underline">Mulai menulis sekarang</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($recentBooks_written as $naskah)
                            <a href="{{ route('user.menulis.edit', $naskah) }}" class="bg-white/10 rounded-2xl p-5 hover:bg-white/20 transition block">
                                <h4 class="font-semibold text-white text-sm mb-1">{{ $naskah->title }}</h4>
                                <p class="text-xs text-white/60 capitalize">{{ str_replace('_', ' ', $naskah->status) }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif

                <a href="{{ route('user.menulis.create') }}" class="inline-block mt-6 bg-[#C9A24B] text-[#1B2A4A] text-sm font-semibold px-6 py-3 rounded-full hover:bg-[#dbb35e] transition">
                    + Buat Naskah Baru
                </a>
            </div>
        </section>
    @else
        {{-- ===================== AJAKAN GABUNG (buat guest) ===================== --}}
        <section class="max-w-7xl mx-auto px-6 py-10">
            <div class="bg-[#1B2A4A] rounded-3xl p-10 text-center">
                <p class="text-xs font-semibold tracking-widest text-[#C9A24B] uppercase mb-2">Gabung Sekarang</p>
                <h3 class="font-display text-2xl font-bold text-white mb-4">
                    Punya Cerita? Simpan Bacaanmu?
                </h3>
                <p class="text-white/70 text-sm max-w-md mx-auto mb-6">
                    Daftar buat mulai baca, simpan ke library, dan tulis naskahmu sendiri di LovRinz.
                </p>
                <a href="{{ route('register') }}" class="inline-block bg-[#C9A24B] text-[#1B2A4A] text-sm font-semibold px-6 py-3 rounded-full hover:bg-[#dbb35e] transition">
                    Daftar Sekarang
                </a>
            </div>
        </section>
    @endauth

    {{-- ===================== SHOP BY GENRE ===================== --}}
    <section class="max-w-7xl mx-auto px-6 py-10 pb-20">
        <h2 class="font-display text-2xl font-semibold text-[#1B2A4A] mb-6">Jelajahi Genre</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach (\App\Models\Genre::orderBy('name')->get() as $genre)
                <a href="{{ route('user.buku.genre', $genre) }}" class="flex items-center justify-between bg-white border border-[#E7E0D2] rounded-2xl px-5 py-4 hover:border-[#C9A24B] transition">
                    <span class="text-sm font-semibold text-[#1B2A4A]">{{ $genre->name }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#C9A24B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @endforeach
        </div>
    </section>

    <footer class="bg-[#1B2A4A] text-white/60 text-sm py-8 text-center">
        © {{ date('Y') }} LovRinz — Platform Buku Digital
    </footer>

    {{-- ===================== Script Hero Carousel ===================== --}}
    <script>
        (function () {
            const carousel = document.getElementById('heroCarousel');
            if (!carousel) return;

            const slides = carousel.querySelectorAll('.slide');
            const dots = carousel.querySelectorAll('.dot');
            let current = 0;
            let timer;

            function goTo(index) {
                slides[current].classList.remove('active');
                dots[current].classList.remove('active');
                current = index;
                slides[current].classList.add('active');
                dots[current].classList.add('active');
            }

            function next() {
                goTo((current + 1) % slides.length);
            }

            function startAutoplay() {
                timer = setInterval(next, 4000);
            }

            dots.forEach((dot) => {
                dot.addEventListener('click', () => {
                    clearInterval(timer);
                    goTo(parseInt(dot.dataset.index, 10));
                    startAutoplay();
                });
            });

            startAutoplay();
        })();
    </script>

</body>
</html>