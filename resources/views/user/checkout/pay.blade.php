<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pembayaran</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center">
                <p class="text-sm text-gray-500">Nomor Pesanan</p>
                <p class="font-semibold text-[#1B2A4A] mb-4">{{ $order->order_number }}</p>

                <p class="text-sm text-gray-500">Total yang harus dibayar</p>
                <p class="text-3xl font-bold text-[#C9A24B] mb-8">Rp {{ number_format($order->total, 0, ',', '.') }}</p>

                <form action="{{ route('user.checkout.confirm', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-[#1B2A4A] text-white text-sm font-medium px-8 py-3 rounded-full hover:bg-[#13203a]">
                        Konfirmasi Pembayaran (Simulasi)
                    </button>
                </form>

                <p class="text-xs text-gray-400 mt-4">
                    *Ini simulasi pembayaran untuk development.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
