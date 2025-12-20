<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }} | Ruang Teduh</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'void': '#0F0F0F',     
                        'surface': '#1A1A1A',  
                        'moon': '#E0E0E0',    
                        'gold': '#C69C6D',     
                        'dim': '#888888',      
                    },
                    fontFamily: { 
                        'serif': ['Lora', 'serif'], 
                        'sans': ['DM Sans', 'sans-serif'] 
                    }
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0F0F0F; } 
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #C69C6D; } 
    </style>
</head>
<body class="bg-void font-sans antialiased text-moon">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-void border-r border-white/10 hidden md:flex flex-col flex-shrink-0 transition-all duration-300 shadow-2xl shadow-black/50">
            
            <div class="h-16 flex items-center justify-center border-b border-gold/30 bg-void/50 shadow-md z-20">
                <h1 class="text-xl font-serif italic text-gold">
                    Ruang Teduh.
                </h1>
            </div>

            <div class="flex-1 overflow-y-auto py-4">
                <nav class="space-y-1 px-2">
                    
                    <a href="{{ route('admin.dashboard') }}" 
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-colors 
                        {{ request()->routeIs('admin.dashboard') ? 'bg-surface border-l-4 border-gold text-white shadow-inner shadow-black/10' : 'text-dim hover:bg-surface hover:text-gold' }}">
                        <i class="fas fa-tachometer-alt w-6 text-lg 
                        {{ request()->routeIs('admin.dashboard') ? 'text-gold' : 'text-dim group-hover:text-gold' }}"></i>
                        Dashboard
                    </a>

                    <div class="pt-4 pb-1 pl-4 text-xs font-semibold text-dim uppercase tracking-wider">
                        Data
                    </div>

                    <a href="{{ route('admin.products.index') }}" 
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-colors 
                        {{ request()->routeIs('admin.products*') ? 'bg-surface border-l-4 border-gold text-white shadow-inner shadow-black/10' : 'text-dim hover:bg-surface hover:text-gold' }}">
                        <i class="fas fa-box w-6 text-lg 
                        {{ request()->routeIs('admin.products*') ? 'text-gold' : 'text-dim group-hover:text-gold' }}"></i>
                        Produk
                    </a>

                    <a href="{{ route('admin.categories.index') }}" 
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-colors 
                        {{ request()->routeIs('admin.categories*') ? 'bg-surface border-l-4 border-gold text-white shadow-inner shadow-black/10' : 'text-dim hover:bg-surface hover:text-gold' }}">
                        <i class="fas fa-tags w-6 text-lg 
                        {{ request()->routeIs('admin.categories*') ? 'text-gold' : 'text-dim group-hover:text-gold' }}"></i>
                        Kategori
                    </a>

                    <a href="{{ route('admin.variants.index') }}" 
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-colors 
                        {{ request()->routeIs('admin.variants*') ? 'bg-surface border-l-4 border-gold text-white shadow-inner shadow-black/10' : 'text-dim hover:bg-surface hover:text-gold' }}">
                        <i class="fas fa-layer-group w-6 text-lg 
                        {{ request()->routeIs('admin.variants*') ? 'text-gold' : 'text-dim group-hover:text-gold' }}"></i>
                        Varian
                    </a>

                    <a href="{{ route('admin.toppings.index') }}" 
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-colors 
                        {{ request()->routeIs('admin.toppings*') ? 'bg-surface border-l-4 border-gold text-white shadow-inner shadow-black/10' : 'text-dim hover:bg-surface hover:text-gold' }}">
                        <i class="fas fa-cheese w-6 text-lg 
                        {{ request()->routeIs('admin.toppings*') ? 'text-gold' : 'text-dim group-hover:text-gold' }}"></i>
                        Topping
                    </a>

                    <div class="pt-4 pb-1 pl-4 text-xs font-semibold text-dim uppercase tracking-wider">
                        Transaksi & User
                    </div>

                    <a href="{{ route('admin.orders.index') }}" 
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-colors 
                        {{ request()->routeIs('admin.orders*') ? 'bg-surface border-l-4 border-gold text-white shadow-inner shadow-black/10' : 'text-dim hover:bg-surface hover:text-gold' }}">
                        <i class="fas fa-shopping-cart w-6 text-lg 
                        {{ request()->routeIs('admin.orders*') ? 'text-gold' : 'text-dim group-hover:text-gold' }}"></i>
                        Pesanan
                    </a>

                    <a href="{{ route('admin.users.index') }}" 
                        class="group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-colors 
                        {{ request()->routeIs('admin.users*') ? 'bg-surface border-l-4 border-gold text-white shadow-inner shadow-black/10' : 'text-dim hover:bg-surface hover:text-gold' }}">
                        <i class="fas fa-users w-6 text-lg 
                        {{ request()->routeIs('admin.users*') ? 'text-gold' : 'text-dim group-hover:text-gold' }}"></i>
                        Pengguna
                    </a>
                    
                    <div class="pt-4 border-t border-white/10 mt-4">
                        <a href="{{ route('admin.settings.index') }}" 
                            class="group flex items-center px-4 py-3 text-sm font-medium rounded-md transition-colors 
                            {{ request()->routeIs('admin.settings*') ? 'bg-surface border-l-4 border-gold text-white shadow-inner shadow-black/10' : 'text-dim hover:bg-surface hover:text-gold' }}">
                            <i class="fas fa-cog w-6 text-lg 
                            {{ request()->routeIs('admin.settings*') ? 'text-gold' : 'text-dim group-hover:text-gold' }}"></i>
                            Pengaturan
                        </a>
                        
                        </div>
                </nav>
            </div>
            
            <div class="p-4 bg-surface border-t border-white/10 flex-shrink-0">
                <div class="flex items-center">
                    <img class="h-8 w-8 rounded-full object-cover border border-dim" 
                            src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=C69C6D&color=0F0F0F" 
                            alt="Avatar">
                    <div class="ml-3">
                        <p class="text-sm font-medium text-moon">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-xs text-dim uppercase tracking-wider">{{ Auth::user()->role->name ?? 'Admin' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden bg-surface/50">
            
            <header class="bg-surface shadow-lg shadow-black/10 h-16 flex justify-between items-center px-6 z-10 border-b border-white/10">
                <button class="md:hidden text-dim focus:outline-none hover:text-gold">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                <div class="text-lg font-serif italic text-moon">
                    Sistem Manajemen Restoran
                </div>

                <div class="flex items-center space-x-4">
                    <button class="text-dim hover:text-gold relative">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-void transform translate-x-1/4 -translate-y-1/4 bg-gold rounded-full">3</span>
                    </button>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-sm font-medium text-red-400 hover:text-red-300 transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 scroll-smooth bg-void/50">
                
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                            class="mb-6 bg-green-900/50 border-l-4 border-green-500 text-green-300 p-4 rounded shadow-sm flex justify-between items-center transition-all duration-500">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-xl"></i>
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-green-300 hover:text-green-500 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-900/50 border-l-4 border-red-500 text-red-300 p-4 rounded shadow-sm">
                        <p class="font-bold">Terjadi Kesalahan:</p>
                        <ul class="list-disc list-inside mt-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}

                <div class="mt-8 border-t border-white/10 pt-4 text-center text-dim text-sm">
                    &copy; {{ date('Y') }} Ruang Teduh. All rights reserved.
                </div>
            </main>
        </div>
    </div>

</body>
</html>