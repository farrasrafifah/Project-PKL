<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola User</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="GET" class="flex gap-2 max-w-sm">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama / email..."
                    class="rounded-lg border-gray-300 text-sm focus:ring-[#1B2A4A] focus:border-[#1B2A4A]">
                <button type="submit" class="bg-[#1B2A4A] text-white text-sm px-4 py-2 rounded-lg">Cari</button>
            </form>

            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-[#F7F3EA] text-[#1B2A4A]">
                        <tr>
                            <th class="text-left px-5 py-3 font-semibold">Nama</th>
                            <th class="text-left px-5 py-3 font-semibold">Email</th>
                            <th class="text-left px-5 py-3 font-semibold">Bergabung</th>
                            <th class="text-right px-5 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-5 py-4 font-medium text-[#1B2A4A]">
                                    <a href="{{ route('admin.users.show', $user) }}" class="hover:underline">{{ $user->name }}</a>
                                </td>
                                <td class="px-5 py-4 text-gray-600">{{ $user->email }}</td>
                                <td class="px-5 py-4 text-gray-600">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-5 py-4 text-right">
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Hapus akun user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-gray-500">Belum ada user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>