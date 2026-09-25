<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Keranjang</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-6 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            @if ($books->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 p-10 text-center text-gray-500">
                    Keranjang kamu masih kosong.
                    <a href="{{ route('user.buku.index') }}" class="text-[#C9A24B] font-medium hover:underline">Jelajah buku</a>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-200 divide-y divide-gray-100">
                    @foreach ($books as $book)
                        <div class="flex items-center justify-between p-5">
                            <div>
                                <h3 class="font-semibold text-[#1B2A4A]">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-500">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                            </div>
                            <form action="{{ route('user.keranjang.remove', $book) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-500 hover:underline">Hapus</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex items-center justify-between bg-white rounded-2xl border border-gray-200 p-5">
                    <span class="font-semibold text-[#1B2A4A]">Total</span>
                    <span class="text-xl font-bold text-[#C9A24B]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <a href="{{ route('user.checkout.create') }}" class="mt-6 inline-block bg-[#1B2A4A] text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-[#13203a]">
                    Lanjut ke Checkout
                </a>
            @endif
        </div>
    </div>
</x-app-layout>
