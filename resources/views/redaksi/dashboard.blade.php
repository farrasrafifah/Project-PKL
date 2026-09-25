<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard Tim Redaksi</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Naskah Masuk</p>
                    <p class="text-3xl font-bold text-[#1B2A4A]">{{ $naskahMasuk }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Sedang Editing</p>
                    <p class="text-3xl font-bold text-[#1B2A4A]">{{ $sedangEditing }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <p class="text-sm text-gray-500">Sudah Terbit</p>
                    <p class="text-3xl font-bold text-[#1B2A4A]">{{ $sudahTerbit }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-[#1B2A4A]">Naskah Menunggu Review</h3>
                    <a href="{{ route('redaksi.naskah.index') }}" class="text-sm text-[#C9A24B] font-medium hover:underline">Lihat semua</a>
                </div>

                @if ($antrianTerbaru->isEmpty())
                    <p class="text-sm text-gray-500">Tidak ada naskah yang menunggu review saat ini.</p>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach ($antrianTerbaru as $naskah)
                            <div class="flex items-center justify-between py-3">
                                <div>
                                    <p class="font-medium text-sm text-[#1B2A4A]">{{ $naskah->title }}</p>
                                    <p class="text-xs text-gray-500">oleh {{ $naskah->author->name }} · {{ $naskah->genre->name ?? '-' }}</p>
                                </div>
                                <a href="{{ route('redaksi.naskah.show', $naskah) }}" class="text-sm text-[#1B2A4A] font-medium hover:underline">Review →</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
