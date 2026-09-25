<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Konfirmasi Pesanan</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-200 divide-y divide-gray-100">
                @foreach ($books as $book)
                    <div class="flex items-center justify-between p-5">
                        <h3 class="font-semibold text-[#1B2A4A]">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-500">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex items-center justify-between bg-white rounded-2xl border border-gray-200 p-5">
                <span class="font-semibold text-[#1B2A4A]">Total Pembayaran</span>
                <span class="text-xl font-bold text-[#C9A24B]">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <form action="{{ route('user.checkout.store') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="bg-[#1B2A4A] text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-[#13203a]">
                    Buat Pesanan
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
