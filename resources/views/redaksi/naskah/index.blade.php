<x-app-layout>
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
                       class="px-4 py-2 rounded-full border {{ $status === $key ? 'bg-[#1B2A4A] text-white border-[#1B2A4A]' : 'border-gray-200 text-gray-600' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if ($naskahList->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 p-10 text-center text-gray-500">
                    Tidak ada naskah di kategori ini.
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-200 divide-y divide-gray-100">
                    @foreach ($naskahList as $naskah)
                        <div class="flex items-center justify-between p-5">
                            <div>
                                <h3 class="font-semibold text-[#1B2A4A]">{{ $naskah->title }}</h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    oleh {{ $naskah->author->name }} · {{ $naskah->genre->name ?? '-' }} ·
                                    <span class="capitalize">{{ str_replace('_', ' ', $naskah->status) }}</span>
                                </p>
                            </div>
                            <a href="{{ route('redaksi.naskah.show', $naskah) }}" class="text-sm text-[#C9A24B] font-medium hover:underline">Detail →</a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6">{{ $naskahList->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
