<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail User</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-2xl border border-gray-200 p-6">
                <p class="text-lg font-semibold text-[#1B2A4A]">{{ $user->name }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
                <p class="text-xs text-gray-400 mt-1">Bergabung {{ $user->created_at->format('d M Y') }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200">
                <div class="p-6 pb-0">
                    <h3 class="font-semibold text-[#1B2A4A]">Naskah Terbaru</h3>
                </div>
                <div class="divide-y divide-gray-100 mt-4">
                    @forelse ($naskahList as $naskah)
                        <div class="flex items-center justify-between p-5">
                            <div>
                                <p class="text-sm font-medium text-[#1B2A4A]">{{ $naskah->title }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $naskah->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <span class="text-xs capitalize bg-[#F7F3EA] text-[#1B2A4A] px-2.5 py-1 rounded-full">
                                {{ str_replace('_', ' ', $naskah->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 p-6">Belum ada naskah.</p>
                    @endforelse
                </div>
            </div>

            <a href="{{ route('admin.users.index') }}" class="text-sm text-[#1B2A4A] hover:underline">&larr; Kembali ke daftar user</a>
        </div>
    </div>
</x-app-layout>