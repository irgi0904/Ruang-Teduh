<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Kasir' }} - Ruang Teduh</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-gradient-to-b from-[#3B2F2F] to-[#2a2020] text-white fixed h-screen overflow-y-auto">
            <div class="p-6 border-b border-white/10">
                <h1 class="text-2xl font-bold text-[#E6D3B1]">Ruang Teduh</h1>
                <p class="text-xs text-[#C2A25D] mt-1">Kasir Panel</p>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('kasir.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('kasir.dashboard') ? 'bg-white/10 text-[#C2A25D]' : 'text-gray-300' }}">
                    <span>📊 Dashboard</span>
                </a>
                <a href="{{ route('kasir.orders.create') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('kasir.orders.create') ? 'bg-white/10 text-[#C2A25D]' : 'text-gray-300' }}">
                    <span>➕ Buat Pesanan</span>
                </a>
                <a href="{{ route('kasir.orders.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('kasir.orders.index') || request()->routeIs('kasir.orders.show') ? 'bg-white/10 text-[#C2A25D]' : 'text-gray-300' }}">
                    <span>📋 Daftar Pesanan</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 ml-64">
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
                <div class="px-8 py-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-[#3B2F2F]">{{ $title ?? 'Dashboard' }}</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-[#3B2F2F] text-white rounded-lg hover:bg-[#2a2020] transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="p-8">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif
                
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>