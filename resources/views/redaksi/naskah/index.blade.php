<x-redaksi-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Naskah Masuk</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex gap-2 mb-6 text-sm flex-wrap">
                @foreach (['menunggu_review' => 'Menunggu Review', 'editing' => 'Editing', 'revisi' => 'Revisi', 'finalisasi' => 'Finalisasi', 'semua' => 'Semua'] as $key => $label)
                    <a href="{{ route('redaksi.naskah.index', ['status' => $key]) }}"
                       @class([
                           'px-4 py-2 rounded-full border font-medium transition',
                           'bg-[#1B2A4A] text-white border-[#1B2A4A]' => $status === $key,
                           'border-gray-200 text-gray-600 hover:border-[#1B2A4A]/30' => $status !== $key,
                       ])>
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if ($naskahList->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 p-14 text-center">
                    <div class="w-14 h-14 rounded-full bg-[#F7F3EA] flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#C9A24B]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l4 4v10a2 2 0 01-2 2H7a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="font-display font-semibold text-[#1B2A4A]">Tidak ada naskah</p>
                    <p class="text-sm text-gray-500 mt-1">Belum ada naskah di kategori ini.</p>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-200 divide-y divide-gray-100">
                    @foreach ($naskahList as $naskah)
                        <div class="flex items-center justify-between p-5 hover:bg-[#F7F3EA]/50 transition-colors">
                            <div class="min-w-0">
                                <h3 class="font-display font-semibold text-[#1B2A4A] truncate">{{ $naskah->title }}</h3>
                                <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                                    <span class="text-xs text-gray-500">oleh {{ $naskah->author->name ?? '-' }}</span>
                                    @if ($naskah->genre)
                                        <span class="text-xs bg-[#F7F3EA] text-[#1B2A4A]/70 px-2.5 py-0.5 rounded-full">
                                            {{ $naskah->genre->name }}
                                        </span>
                                    @endif
                                    <span @class([
                                        'text-xs capitalize px-2.5 py-0.5 rounded-full',
                                        'bg-green-50 text-green-700' => $naskah->status === 'terbit',
                                        'bg-amber-50 text-amber-700' => $naskah->status === 'menunggu_review',
                                        'bg-blue-50 text-blue-700' => $naskah->status === 'editing',
                                        'bg-red-50 text-red-700' => $naskah->status === 'revisi',
                                        'bg-gray-100 text-gray-500' => !in_array($naskah->status, ['terbit', 'menunggu_review', 'editing', 'revisi']),
                                    ])>
                                        {{ str_replace('_', ' ', $naskah->status) }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('redaksi.naskah.show', $naskah) }}"
                                class="text-sm text-white bg-[#C9A24B] font-medium px-4 py-2 rounded-full hover:bg-[#dbb35e] transition flex-shrink-0 ml-4">
                                Detail
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $naskahList->links() }}</div>
            @endif
        </div>
    </div>
</x-redaksi-layout>