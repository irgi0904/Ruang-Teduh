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
        <aside class="w-64 bg-gradient-to-b from-[#3B2F2F] to-[#2a2020] text-white fixed h-screen overflow-y-auto z-50">

            <div class="p-6 border-b border-white/10">
                <h1 class="text-2xl font-bold text-[#E6D3B1]">☕ Ruang Teduh</h1>
                <p class="text-xs text-[#C2A25D] mt-1">Kasir Panel</p>
            </div>

            <div class="p-4 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#C2A25D] rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#E6D3B1]">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#C2A25D]">Kasir</p>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1">
 
                <a href="{{ route('kasir.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                   {{ request()->routeIs('kasir.dashboard') 
                      ? 'bg-white/10 text-[#C2A25D] shadow-lg' 
                      : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-xl">📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('kasir.orders.create') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                   {{ request()->routeIs('kasir.orders.create') 
                      ? 'bg-white/10 text-[#C2A25D] shadow-lg' 
                      : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-xl">➕</span>
                    <span class="font-medium">Buat Pesanan</span>
                </a>

                <a href="{{ route('kasir.orders.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                   {{ request()->routeIs('kasir.orders.index') || request()->routeIs('kasir.orders.show') || request()->routeIs('kasir.orders.receipt')
                      ? 'bg-white/10 text-[#C2A25D] shadow-lg' 
                      : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-xl">📋</span>
                    <span class="font-medium">Daftar Pesanan</span>
                </a>

               
                <div class="h-px bg-white/10 my-4"></div>

           
                <div class="px-4 py-2">
                    <p class="text-xs text-[#E6D3B1]/60 uppercase tracking-wider mb-2">Quick Actions</p>
                </div>

       
                @php
                    $pendingCount = \App\Models\Order::where('status', 'pending')->count();
                @endphp
                <a href="{{ route('kasir.orders.index', ['status' => 'pending']) }}" 
                   class="flex items-center justify-between gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">⏳</span>
                        <span class="font-medium">Pending</span>
                    </div>
                    @if($pendingCount > 0)
                        <span class="px-2 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

    
                @php
                    $processingCount = \App\Models\Order::where('status', 'processing')->count();
                @endphp
                <a href="{{ route('kasir.orders.index', ['status' => 'processing']) }}" 
                   class="flex items-center justify-between gap-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-white/5 hover:text-white transition">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">⚙️</span>
                        <span class="font-medium">Processing</span>
                    </div>
                    @if($processingCount > 0)
                        <span class="px-2 py-1 bg-blue-500 text-white text-xs font-bold rounded-full">
                            {{ $processingCount }}
                        </span>
                    @endif
                </a>
            </nav>

   
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10">
                <div class="bg-white/5 rounded-lg p-3 mb-3">
                    <p class="text-xs text-[#E6D3B1]/80 mb-1">Shift Hari Ini</p>
                    <p class="text-lg font-bold text-[#C2A25D]">{{ \App\Models\Order::whereDate('created_at', today())->count() }} Pesanan</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center justify-center gap-2 font-medium">
                        <span>🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

   
        <div class="flex-1 ml-64">
  
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
                <div class="px-8 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-[#3B2F2F]">{{ $title ?? 'Dashboard' }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                    </div>
                    <div class="flex items-center gap-4">

                        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg shadow-lg">
                            <p class="text-xs opacity-90">Pendapatan Hari Ini</p>
                            <p class="text-lg font-bold">
                                Rp {{ number_format(\App\Models\Order::where('status', 'completed')->whereDate('created_at', today())->sum('total'), 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-[#C2A25D] rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">Kasir</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>


            <main class="p-8">

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg shadow-sm flex items-start gap-3">
                        <span class="text-2xl">✅</span>
                        <div>
                            <p class="font-semibold">Berhasil!</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-lg shadow-sm flex items-start gap-3">
                        <span class="text-2xl">❌</span>
                        <div>
                            <p class="font-semibold">Error!</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-800 rounded-lg shadow-sm flex items-start gap-3">
                        <span class="text-2xl">ℹ️</span>
                        <div>
                            <p class="font-semibold">Info</p>
                            <p class="text-sm">{{ session('info') }}</p>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>

            <footer class="bg-white border-t border-gray-200 py-4 px-8 mt-8">
                <div class="flex items-center justify-between text-sm text-gray-600">
                    <p>© {{ date('Y') }} Ruang Teduh. All rights reserved.</p>
                    <p>Made with ❤️ and ☕</p>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>