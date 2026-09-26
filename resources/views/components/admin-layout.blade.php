<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} — Lovrinz Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700|inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-display { font-family: 'Fraunces', serif; }
        .font-body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-body bg-[#F7F3EA] antialiased">
    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-[#1B2A4A] text-white flex-shrink-0 flex flex-col shadow-xl">
            <div class="px-6 py-6 border-b border-white/10">
                <p class="font-display text-2xl font-bold tracking-tight text-white">LOVRINZ</p>
                <p class="text-[11px] text-[#C9A24B] font-semibold tracking-widest uppercase mt-1">Admin</p>
            </div>

            <nav class="flex-1 px-3 py-5 space-y-1">
                @php
                    $menu = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'active' => 'admin.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['route' => 'admin.books.index', 'label' => 'Kelola Buku', 'active' => 'admin.books.*', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                        ['route' => 'admin.genres.index', 'label' => 'Kelola Genre', 'active' => 'admin.genres.*', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                        ['route' => 'admin.users.index', 'label' => 'Kelola User', 'active' => 'admin.users.*', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                        ['route' => 'admin.redaksi.index', 'label' => 'Kelola Redaksi', 'active' => 'admin.redaksi.*', 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4'],
                        ['route' => 'admin.orders.index', 'label' => 'Transaksi', 'active' => 'admin.orders.*', 'icon' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M17 21l-5-5-5 5V5a2 2 0 012-2h6a2 2 0 012 2v16z'],
                    ];
                @endphp

                @foreach ($menu as $item)
                    <a href="{{ route($item['route']) }}"
                        @class([
                            'flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all',
                            'bg-[#C9A24B] text-[#1B2A4A] font-semibold shadow-md shadow-black/10' => request()->routeIs($item['active']),
                            'text-white/60 hover:bg-white/10 hover:text-white' => !request()->routeIs($item['active']),
                        ])>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="px-3 py-4 border-t border-white/10">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-2 py-2 mb-2 rounded-xl hover:bg-white/10 transition-all">
                    <div class="w-9 h-9 rounded-full bg-[#C9A24B] flex items-center justify-center flex-shrink-0 overflow-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#1B2A4A" class="w-6 h-6">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4.418 3.582-8 8-8s8 3.582 8 8v1H4v-1z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-white/50 truncate">{{ auth()->user()->email ?? '' }}</p>
                    </div>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-white/60 hover:bg-white/10 hover:text-white transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col min-w-0">
            @isset($header)
                <header class="bg-white border-b border-gray-200 px-8 py-5">
                    <div class="font-display">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>