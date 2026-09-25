<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Status Naskah
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl border border-gray-200 p-8">

                {{-- Judul dan Genre --}}
                <h1 class="font-bold text-xl text-[#1B2A4A] mb-1">
                    {{ $naskah->title }}
                </h1>

                <p class="text-sm text-gray-500 mb-6">
                    {{ $naskah->genre->name ?? '-' }}
                </p>

                @php
                    $steps = [
                        'draft',
                        'menunggu_review',
                        'dalam_proses_editing',
                        'revisi',
                        'finalisasi',
                        'siap_terbit',
                        'terbit'
                    ];

                    $currentIndex = array_search($naskah->status, $steps);

                    // Jika status tidak ditemukan, anggap masih tahap awal
                    if ($currentIndex === false) {
                        $currentIndex = 0;
                    }
                @endphp

                {{-- Status Progress --}}
                <div class="space-y-3">

                    @foreach ($steps as $i => $step)

                        <div class="flex items-center gap-3">

                            {{-- Titik Status --}}
                            <div
                                class="h-3 w-3 rounded-full
                                {{ $i <= $currentIndex
                                    ? 'bg-[#C9A24B]'
                                    : 'bg-gray-200' }}"
                            ></div>

                            {{-- Nama Status --}}
                            <span
                                class="text-sm capitalize
                                {{ $i === $currentIndex
                                    ? 'font-semibold text-[#1B2A4A]'
                                    : 'text-gray-500' }}"
                            >
                                {{ str_replace('_', ' ', $step) }}
                            </span>

                        </div>

                    @endforeach

                </div>

                {{-- Catatan Redaksi --}}
                @if ($naskah->reviews && $naskah->reviews->isNotEmpty())

                    <div class="mt-6 pt-6 border-t border-gray-100">

                        <h3 class="font-semibold text-sm text-[#1B2A4A] mb-3">
                            Catatan Redaksi
                        </h3>

                        @foreach ($naskah->reviews as $review)

                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-2">

                                <p class="text-sm text-gray-600">
                                    {{ $review->catatan ?? '-' }}
                                </p>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="mt-6 pt-6 border-t border-gray-100">

                        <p class="text-sm text-gray-400">
                            Belum ada catatan dari redaksi.
                        </p>

                    </div>

                @endif

                {{-- Tombol kembali --}}
                <div class="mt-6">

                    <a
                        href="{{ route('user.menulis.index') }}"
                        class="inline-block bg-[#1B2A4A] text-white text-sm px-5 py-2.5 rounded-full hover:bg-[#13203a]"
                    >
                        Kembali ke Karya Saya
                    </a>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
