<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Karya Saya</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('user.menulis.create') }}" class="inline-block bg-[#1B2A4A] text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-[#13203a] mb-8">
                + Buat Naskah Baru
            </a>

            @if ($naskahList->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 p-10 text-center text-gray-500">
                    Kamu belum punya naskah. Yuk mulai menulis!
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-200 divide-y divide-gray-100">
                    @foreach ($naskahList as $naskah)
                        <div class="flex items-center justify-between p-5">
                            <div>
                                <h3 class="font-semibold text-[#1B2A4A]">{{ $naskah->title }}</h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $naskah->genre->name ?? '-' }} ·
                                    <span class="capitalize">{{ str_replace('_', ' ', $naskah->status) }}</span>
                                </p>
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('user.menulis.status', $naskah) }}" class="text-sm text-gray-500 hover:underline">
                                    Status
                                </a>
                                <a href="{{ route('user.menulis.edit', $naskah) }}" class="text-sm text-[#C9A24B] font-medium hover:underline">
                                    Kelola
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
