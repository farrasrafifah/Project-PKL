<x-redaksi-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Tim Redaksi</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Naskah Masuk</p>
                    <p class="font-display text-3xl font-bold text-[#1B2A4A] mt-1">{{ $naskahMasuk }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Sedang Editing</p>
                    <p class="font-display text-3xl font-bold text-[#1B2A4A] mt-1">{{ $sedangEditing }}</p>
                </div>
                <div class="bg-[#1B2A4A] rounded-2xl p-6">
                    <p class="text-sm text-white/70">Sudah Terbit</p>
                    <p class="font-display text-3xl font-bold text-white mt-1">{{ $sudahTerbit }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-display font-semibold text-[#1B2A4A]">Naskah Menunggu Review</h3>
                    <a href="{{ route('redaksi.naskah.index') }}" class="text-sm text-[#C9A24B] font-medium hover:underline">Lihat semua</a>
                </div>

                @if ($antrianTerbaru->isEmpty())
                    <div class="text-center py-10">
                        <div class="w-14 h-14 rounded-full bg-[#F7F3EA] flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#C9A24B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">Tidak ada naskah yang menunggu review saat ini.</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach ($antrianTerbaru as $naskah)
                            <div class="flex items-center justify-between py-4 hover:bg-[#F7F3EA]/50 -mx-2 px-2 rounded-lg transition-colors">
                                <div class="min-w-0">
                                    <p class="font-medium text-sm text-[#1B2A4A] truncate">{{ $naskah->title }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">oleh {{ $naskah->author->name ?? '-' }} · {{ $naskah->genre->name ?? '-' }}</p>
                                </div>
                                <a href="{{ route('redaksi.naskah.show', $naskah) }}"
                                    class="text-sm text-white bg-[#1B2A4A] font-medium px-4 py-2 rounded-full hover:bg-[#13203a] transition flex-shrink-0 ml-4">
                                    Review
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-redaksi-layout>