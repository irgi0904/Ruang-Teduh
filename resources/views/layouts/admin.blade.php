<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin' }} - Cafe Teduh</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-void { background-color: #0f0f11; }
        .bg-surface { background-color: #18181b; }
        .text-gold { color: #d4af37; }
        .bg-gold { background-color: #d4af37; }
        .text-moon { color: #e4e4e7; }
        .text-dim { color: #a1a1aa; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="font-sans antialiased bg-void text-moon selection:bg-gold selection:text-white">
    
    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-surface border-r border-white/5 hidden md:flex flex-col relative z-20">
            <div class="h-20 flex flex-col justify-center px-8 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-serif italic font-bold text-gold tracking-wide">
                    Cafe Teduh
                </a>
                <p class="text-xs text-dim mt-1">Admin Panel</p>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 space-y-1">
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-8 py-3 transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'text-gold border-r-2 border-gold bg-white/5' : 'text-dim hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-chart-pie w-6 {{ request()->routeIs('admin.dashboard') ? 'text-gold' : 'text-gray-500 group-hover:text-white' }}"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <div class="px-8 mt-6 mb-2 text-xs font-bold text-gold/60 uppercase tracking-widest">
                    Produk & Menu
                </div>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center px-8 py-3 transition-all duration-200 group {{ request()->routeIs('admin.orders.*') ? 'text-gold border-r-2 border-gold bg-white/5' : 'text-dim hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-receipt w-6 {{ request()->routeIs('admin.orders.*') ? 'text-gold' : 'text-gray-500 group-hover:text-white' }}"></i>
                    <span class="font-medium">Semua Pesanan</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center px-8 py-3 transition-all duration-200 group {{ request()->routeIs('admin.categories.*') ? 'text-gold border-r-2 border-gold bg-white/5' : 'text-dim hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-tags w-6 {{ request()->routeIs('admin.categories.*') ? 'text-gold' : 'text-gray-500 group-hover:text-white' }}"></i>
                    <span class="font-medium">Kategori</span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center px-8 py-3 transition-all duration-200 group {{ request()->routeIs('admin.products.*') ? 'text-gold border-r-2 border-gold bg-white/5' : 'text-dim hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-coffee w-6 {{ request()->routeIs('admin.products.*') ? 'text-gold' : 'text-gray-500 group-hover:text-white' }}"></i>
                    <span class="font-medium">Produk</span>
                </a>

                <a href="{{ route('admin.toppings.index') }}" 
                   class="flex items-center px-8 py-3 transition-all duration-200 group {{ request()->routeIs('admin.toppings.*') ? 'text-gold border-r-2 border-gold bg-white/5' : 'text-dim hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-cookie w-6 {{ request()->routeIs('admin.toppings.*') ? 'text-gold' : 'text-gray-500 group-hover:text-white' }}"></i>
                    <span class="font-medium">Topping</span>
                </a>

                <a href="{{ route('admin.variants.index') }}" 
                   class="flex items-center px-8 py-3 transition-all duration-200 group {{ request()->routeIs('admin.variants.*') ? 'text-gold border-r-2 border-gold bg-white/5' : 'text-dim hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-sliders-h w-6 {{ request()->routeIs('admin.variants.*') ? 'text-gold' : 'text-gray-500 group-hover:text-white' }}"></i>
                    <span class="font-medium">Varian</span>
                </a>

                <div class="px-8 mt-6 mb-2 text-xs font-bold text-gold/60 uppercase tracking-widest">
                    Manajemen
                </div>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center px-8 py-3 transition-all duration-200 group {{ request()->routeIs('admin.users.*') ? 'text-gold border-r-2 border-gold bg-white/5' : 'text-dim hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-users w-6 {{ request()->routeIs('admin.users.*') ? 'text-gold' : 'text-gray-500 group-hover:text-white' }}"></i>
                    <span class="font-medium">Staff / User</span>
                </a>

                <a href="{{ route('admin.reports.index') }}" 
                   class="flex items-center px-8 py-3 transition-all duration-200 group {{ request()->routeIs('admin.reports.*') ? 'text-gold border-r-2 border-gold bg-white/5' : 'text-dim hover:text-white hover:bg-white/5' }}">
                    <i class="fas fa-file-invoice-dollar w-6 {{ request()->routeIs('admin.reports.*') ? 'text-gold' : 'text-gray-500 group-hover:text-white' }}"></i>
                    <span class="font-medium">Laporan Keuangan</span>
                </a>

            </nav>

            <div class="border-t border-white/5 p-4">
                <div class="flex items-center gap-3 mb-4 px-4">
                    <div class="w-10 h-10 rounded-full bg-gold/20 flex items-center justify-center text-gold font-bold font-serif">
                        {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-dim">Administrator</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-white/10 rounded text-sm text-dim hover:text-white hover:border-red-500 hover:text-red-400 hover:bg-red-500/10 transition">
                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-void relative">
            <header class="md:hidden h-16 bg-surface border-b border-white/5 flex items-center justify-between px-4">
                <span class="text-xl font-serif italic text-gold">Cafe Teduh</span>
                <button class="text-dim hover:text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 md:p-10 relative">
                <div class="absolute top-0 left-0 w-full h-96 bg-gold/5 blur-[100px] rounded-full pointer-events-none -translate-y-1/2"></div>
                
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-900/20 border border-green-500/30 text-green-400 rounded shadow-lg backdrop-blur-sm relative z-10 flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 bg-red-900/20 border border-red-500/30 text-red-400 rounded shadow-lg backdrop-blur-sm relative z-10 flex items-center">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        {{ session('error') }}
                    </div>
                @endif
                
                {{ $slot }}
                
            </main>
        </div>

    </div>
</body>
</html>