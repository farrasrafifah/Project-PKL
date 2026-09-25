<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $book->title }}</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if ($book->chapters->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 p-10 text-center text-gray-500">
                    Naskah ini belum memiliki chapter.
                </div>
            @else
                @foreach ($book->chapters as $chapter)
                    <div class="bg-white rounded-2xl border border-gray-200 p-8 mb-6">
                        <p class="text-xs text-[#C9A24B] font-semibold mb-1">Bab {{ $chapter->chapter_number }}</p>
                        <h2 class="font-bold text-xl text-[#1B2A4A] mb-4">{{ $chapter->title }}</h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($chapter->content)) !!}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
