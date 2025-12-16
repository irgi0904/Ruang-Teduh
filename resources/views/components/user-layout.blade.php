<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Teduh</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
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
        body { background-color: #0F0F0F; color: #E0E0E0; }

        .noise {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 0; opacity: 0.05;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0F0F0F; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #C69C6D; }
    </style>
</head>
<body class="font-sans antialiased pb-20 selection:bg-gold selection:text-void">
    <div class="noise"></div>

    <nav class="fixed top-0 w-full z-50 px-6 py-4 flex justify-between items-center bg-void/90 backdrop-blur-md border-b border-white/5 transition-all duration-300">
        <a href="/" class="font-serif font-bold text-lg italic text-gold hover:text-moon transition">
            ruang teduh.
        </a>
        
        <div class="flex gap-6 font-sans text-xs font-medium lowercase tracking-widest text-dim items-center">
            
            <a href="{{ route('pengguna.menu.index') }}" 
               class="hover:text-gold transition {{ request()->routeIs('pengguna.menu.*') ? 'text-gold border-b border-gold pb-1' : '' }}">
               Menu
            </a>
            
            <a href="{{ route('pengguna.cart.index') }}" 
               class="hover:text-gold transition relative group {{ request()->routeIs('pengguna.cart.*') ? 'text-gold' : '' }}">
                <i class="fas fa-shopping-bag text-sm mb-0.5"></i>
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-2 -right-3 bg-gold text-void text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center animate-pulse">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="hover:text-white transition ml-2 border border-dim/30 px-3 py-1 rounded-full hover:border-white/50">
                    (logout)
                </button>
            </form>
        </div>
    </nav>

    <main class="relative z-10 pt-24 px-4 md:px-8 lg:px-12 max-w-7xl mx-auto min-h-screen">
        
        @if(session('success'))
            <div class="mb-8 bg-surface border-l-4 border-gold text-moon px-6 py-4 rounded-r shadow-lg flex items-center animate-fade-in-up">
                <i class="fas fa-check-circle text-gold mr-3"></i> 
                <span class="text-sm font-light">{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-8 bg-surface border-l-4 border-red-500 text-moon px-6 py-4 rounded-r shadow-lg flex items-center animate-fade-in-up">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span class="text-sm font-light">{{ session('error') }}</span>
            </div>
        @endif

        {{ $slot }}

    </main>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
    </style>
</body>
</html>