<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Review Naskah</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <span class="inline-block text-xs bg-[#F7F3EA] text-[#1B2A4A] px-3 py-1 rounded-full mb-3 capitalize">
                    {{ str_replace('_', ' ', $naskah->status) }}
                </span>
                <h1 class="font-bold text-xl text-[#1B2A4A]">{{ $naskah->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">oleh {{ $naskah->author->name }} · {{ $naskah->genre->name ?? '-' }}</p>
                <p class="text-gray-600 text-sm mt-4 leading-relaxed">{{ $naskah->synopsis }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <h3 class="font-semibold text-[#1B2A4A] mb-4">Isi Naskah ({{ $naskah->chapters->count() }} chapter)</h3>
                @forelse ($naskah->chapters as $chapter)
                    <div class="border border-gray-100 rounded-xl p-4 mb-3">
                        <p class="text-xs text-gray-500 mb-1">Bab {{ $chapter->chapter_number }}</p>
                        <p class="font-medium text-sm mb-2">{{ $chapter->title }}</p>
                        <p class="text-sm text-gray-600 whitespace-pre-line">{{ $chapter->content }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada chapter.</p>
                @endforelse
            </div>

            @if ($naskah->reviews->isNotEmpty())
                <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
                    <h3 class="font-semibold text-sm text-yellow-800 mb-3">Riwayat Review</h3>
                    @foreach ($naskah->reviews as $review)
                        <p class="text-sm text-yellow-700 mb-2">
                            <span class="font-medium capitalize">{{ str_replace('_', ' ', $review->keputusan) }}:</span>
                            {{ $review->catatan }}
                        </p>
                    @endforeach
                </div>
            @endif

            @if ($naskah->status === 'menunggu_review')
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-[#1B2A4A] mb-4">Keputusan Review</h3>

                    <form action="{{ route('redaksi.naskah.editing', $naskah) }}" method="POST" class="mb-4">
                        @csrf
                        <button type="submit" class="bg-[#1B2A4A] text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-[#13203a]">
                            Setujui → Lanjut Editing
                        </button>
                    </form>

                    <form action="{{ route('redaksi.naskah.revisi', $naskah) }}" method="POST" class="space-y-3">
                        @csrf
                        <textarea name="catatan" rows="3" placeholder="Tulis catatan revisi untuk penulis..." class="block w-full border-gray-300 rounded-lg text-sm" required></textarea>
                        <button type="submit" class="border border-red-300 text-red-600 text-sm font-medium px-6 py-2.5 rounded-full hover:bg-red-50">
                            Kirim Balik untuk Revisi
                        </button>
                    </form>
                </div>
            @elseif ($naskah->status === 'editing')
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-[#1B2A4A] mb-4">Proses Editing</h3>
                    <form action="{{ route('redaksi.naskah.finalisasi', $naskah) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-[#1B2A4A] text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-[#13203a]">
                            Selesai Editing → Finalisasi
                        </button>
                    </form>
                </div>
            @elseif ($naskah->status === 'finalisasi')
                <div class="bg-white rounded-2xl border border-gray-200 p-6">
                    <h3 class="font-semibold text-[#1B2A4A] mb-4">Terbitkan Ebook</h3>
                    <form action="{{ route('redaksi.naskah.terbit', $naskah) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                            <input type="number" name="price" min="0" step="1000" class="mt-1 block w-full border-gray-300 rounded-lg" required>
                        </div>
                        <button type="submit" class="bg-[#C9A24B] text-[#1B2A4A] text-sm font-semibold px-6 py-3 rounded-full hover:bg-[#dbb35e]">
                            Terbitkan ke Marketplace
                        </button>
                    </form>
                </div>
            @elseif ($naskah->status === 'revisi')
                <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 text-sm text-blue-700">
                    Naskah sedang menunggu penulis melakukan revisi.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
