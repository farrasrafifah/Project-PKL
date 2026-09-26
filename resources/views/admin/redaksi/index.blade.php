<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Redaksi</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.redaksi.create') }}"
                    class="bg-[#C9A24B] text-white text-sm font-medium px-4 py-2 rounded-lg hover:opacity-90">
                    + Tambah Akun Redaksi
                </a>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-[#F7F3EA] text-[#1B2A4A]">
                        <tr>
                            <th class="text-left px-5 py-3 font-semibold">Nama</th>
                            <th class="text-left px-5 py-3 font-semibold">Email</th>
                            <th class="text-right px-5 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($redaksiList as $redaksi)
                            <tr>
                                <td class="px-5 py-4 font-medium text-[#1B2A4A]">{{ $redaksi->name }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $redaksi->email }}</td>
                                <td class="px-5 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.redaksi.edit', $redaksi) }}" class="text-[#1B2A4A] hover:underline">Edit</a>
                                    <form action="{{ route('admin.redaksi.destroy', $redaksi) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus akun redaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-8 text-center text-gray-500">Belum ada akun redaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $redaksiList->links() }}
        </div>
    </div>
</x-app-layout>