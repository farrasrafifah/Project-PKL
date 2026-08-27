<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="font-serif italic text-2xl text-[#1F2430] leading-tight">
                Halo, {{ auth()->user()->name }}
            </h2>
            <p class="text-sm text-[#6B7280] mt-0.5">
                Satu akun, dua peran — baca, beli, dan tulis di rak yang sama.
            </p>
        </div>
    </x-slot>

    {{-- Font: Fraunces (display/serif) untuk judul, Inter untuk UI --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;1,9..144,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .font-serif { font-family: 'Fraunces', serif; }
        body, .font-ui { font-family: 'Inter', ui-sans-serif, system-ui; }
    </style>

    <div class="py-8 bg-[#F7F6F2] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            {{-- ================= RINGKASAN ================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-2xl border border-[#E8E5DE] shadow-sm p-5 flex items-center gap-4">
                    <span class="flex items-center justify-center w-12 h-12 rounded-full bg-[#3A5A6B]/10 text-2xl">📚</span>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-[#9CA3AF]">Buku di Library</p>
                        <p class="text-2xl font-serif font-semibold text-[#1F2430]">{{ auth()->user()->libraries()->count() }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-[#E8E5DE] shadow-sm p-5 flex items-center gap-4">
                    <span class="flex items-center justify-center w-12 h-12 rounded-full bg-[#B08D57]/10 text-2xl">🛒</span>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-[#9CA3AF]">Item di Keranjang</p>
                        <p class="text-2xl font-serif font-semibold text-[#1F2430]">{{ count(session('cart', [])) }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-[#E8E5DE] shadow-sm p-5 flex items-center gap-4">
                    <span class="flex items-center justify-center w-12 h-12 rounded-full bg-[#8B4A3C]/10 text-2xl">✍️</span>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-[#9CA3AF]">Naskah Saya</p>
                        <p class="text-2xl font-serif font-semibold text-[#1F2430]">{{ auth()->user()->books()->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- ================= AKTIVITAS PELANGGAN ================= --}}
            <div class="relative bg-white rounded-2xl border border-[#E8E5DE] shadow-sm p-6 overflow-hidden">
                {{-- ribbon aksen --}}
                <div class="absolute top-0 left-6 w-2 h-8 bg-[#3A5A6B] rounded-b-sm"></div>

                <p class="text-xs font-ui font-semibold tracking-widest text-[#3A5A6B] uppercase mb-1">Untuk Pembaca</p>
                <h3 class="text-xl font-serif font-semibold text-[#1F2430] mb-1">Aktivitas Pelanggan</h3>
                <p class="text-sm text-[#6B7280] mb-6">Cari, beli, dan baca ebook favoritmu.</p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <a href="{{ route('user.buku.index') }}"
                       class="group flex flex-col items-center justify-center p-4 rounded-xl border border-[#E8E5DE] hover:border-[#3A5A6B] hover:bg-[#3A5A6B]/5 transition">
                        <span class="text-2xl mb-2">🔍</span>
                        <span class="text-sm font-ui font-medium text-[#374151] group-hover:text-[#3A5A6B] text-center">Cari / Jelajah Buku</span>
                    </a>

                    <a href="{{ route('user.keranjang.index') }}"
                       class="group flex flex-col items-center justify-center p-4 rounded-xl border border-[#E8E5DE] hover:border-[#3A5A6B] hover:bg-[#3A5A6B]/5 transition">
                        <span class="text-2xl mb-2">🛒</span>
                        <span class="text-sm font-ui font-medium text-[#374151] group-hover:text-[#3A5A6B] text-center">Keranjang</span>
                    </a>

                    <a href="{{ route('user.library.index') }}"
                       class="group flex flex-col items-center justify-center p-4 rounded-xl border border-[#E8E5DE] hover:border-[#3A5A6B] hover:bg-[#3A5A6B]/5 transition">
                        <span class="text-2xl mb-2">📖</span>
                        <span class="text-sm font-ui font-medium text-[#374151] group-hover:text-[#3A5A6B] text-center">Library Saya</span>
                    </a>

                    <a href="{{ route('user.buku.index') }}?genre=populer"
                       class="group flex flex-col items-center justify-center p-4 rounded-xl border border-[#E8E5DE] hover:border-[#3A5A6B] hover:bg-[#3A5A6B]/5 transition">
                        <span class="text-2xl mb-2">🏷️</span>
                        <span class="text-sm font-ui font-medium text-[#374151] group-hover:text-[#3A5A6B] text-center">Jelajah Genre</span>
                    </a>
                </div>

                @if(isset($recentBooks) && $recentBooks->count())
                    <div class="mt-6">
                        <p class="text-sm font-ui font-medium text-[#6B7280] mb-3">Lanjutkan membaca</p>
                        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4">
                            @foreach($recentBooks as $book)
                                <a href="{{ route('user.buku.show', $book) }}" class="block group">
                                    <div class="aspect-[2/3] bg-gradient-to-br from-[#3A5A6B]/15 to-[#3A5A6B]/5 rounded-lg mb-2 group-hover:from-[#3A5A6B]/25 transition"></div>
                                    <p class="text-xs font-ui text-[#374151] truncate">{{ $book->title }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- ================= AKTIVITAS PENULIS ================= --}}
            <div class="relative bg-white rounded-2xl border border-[#E8E5DE] shadow-sm p-6 overflow-hidden">
                {{-- ribbon aksen --}}
                <div class="absolute top-0 left-6 w-2 h-8 bg-[#8B4A3C] rounded-b-sm"></div>

                <p class="text-xs font-ui font-semibold tracking-widest text-[#8B4A3C] uppercase mb-1">Untuk Penulis</p>
                <h3 class="text-xl font-serif font-semibold text-[#1F2430] mb-1">Aktivitas Penulis</h3>
                <p class="text-sm text-[#6B7280] mb-6">Tulis naskahmu dan kirim ke redaksi untuk diterbitkan.</p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <a href="{{ route('user.menulis.index') }}"
                       class="group flex flex-col items-center justify-center p-4 rounded-xl border border-[#E8E5DE] hover:border-[#8B4A3C] hover:bg-[#8B4A3C]/5 transition">
                        <span class="text-2xl mb-2">🗂️</span>
                        <span class="text-sm font-ui font-medium text-[#374151] group-hover:text-[#8B4A3C] text-center">Karya Saya</span>
                    </a>

                    <a href="{{ route('user.menulis.create') }}"
                       class="group flex flex-col items-center justify-center p-4 rounded-xl border border-[#E8E5DE] hover:border-[#8B4A3C] hover:bg-[#8B4A3C]/5 transition">
                        <span class="text-2xl mb-2">➕</span>
                        <span class="text-sm font-ui font-medium text-[#374151] group-hover:text-[#8B4A3C] text-center">Buat Naskah Baru</span>
                    </a>
                </div>

                @if(isset($recentBooks_written) && $recentBooks_written->count())
                    <div class="mt-6 divide-y divide-[#E8E5DE]">
                        @foreach($recentBooks_written as $naskah)
                            @php
                                $statusStyles = [
                                    'draft' => 'bg-gray-100 text-gray-600',
                                    'dikirim' => 'bg-[#B08D57]/15 text-[#8B6A34]',
                                    'review' => 'bg-[#B08D57]/15 text-[#8B6A34]',
                                    'revisi' => 'bg-red-50 text-red-600',
                                    'terbit' => 'bg-emerald-50 text-emerald-600',
                                ];
                                $badge = $statusStyles[strtolower($naskah->status)] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <div class="flex items-center justify-between py-3">
                                <div>
                                    <p class="text-sm font-ui font-medium text-[#1F2430]">{{ $naskah->title }}</p>
                                    <span class="inline-block mt-1 text-xs font-ui px-2 py-0.5 rounded-full {{ $badge }}">
                                        {{ ucfirst($naskah->status) }}
                                    </span>
                                </div>
                                <a href="{{ route('user.menulis.status', $naskah) }}"
                                   class="text-sm font-ui font-medium text-[#8B4A3C] hover:underline">Lihat Status</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 rounded-xl border border-dashed border-[#E8E5DE] p-6 text-center">
                        <p class="text-sm font-ui text-[#9CA3AF]">Belum ada naskah. Mulai tulis karya pertamamu.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>