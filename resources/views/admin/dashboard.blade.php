<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Ruang Teduh</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;400;500;700&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'void': '#0F0F0F', 'surface': '#1A1A1A', 
                        'gold': '#C69C6D', 'moon': '#E0E0E0', 
                        'dim': '#888888', 'accent': '#3C824E' 
                    },
                    fontFamily: {
                        'serif': ['"Lora"', 'serif'],
                        'sans': ['"DM Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #0F0F0F; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 5px; }
    </style>
</head>
<body class="bg-void text-moon flex h-screen overflow-hidden font-sans">

    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/80 z-40 hidden md:hidden backdrop-blur-sm transition-opacity"></div>

    <aside id="sidebar" class="fixed md:relative w-64 h-full bg-surface border-r border-white/5 flex flex-col shadow-2xl z-50 transform -translate-x-full md:translate-x-0 sidebar-transition">
        <div class="p-8 text-center border-b border-white/5 flex justify-between items-center md:block">
            <div>
                <h1 class="font-serif italic text-2xl text-gold">Ruang Teduh.</h1>
                <p class="text-[10px] text-dim uppercase tracking-[0.3em] mt-1">Administrator</p>
            </div>
            <button onclick="toggleSidebar()" class="md:hidden text-dim hover:text-white"><i class="fas fa-times"></i></button>
        </div>
        
        <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
            <p class="px-4 text-[10px] text-dim uppercase tracking-widest font-bold mb-2 mt-2">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg bg-void border-l-4 border-gold text-moon text-sm font-medium shadow-lg">
                <i class="fas fa-chart-line w-6 text-center text-gold"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-void/50 text-dim hover:text-gold transition text-sm font-medium">
                <i class="fas fa-coffee w-6 text-center"></i> Produk & Menu
            </a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-void/50 text-dim hover:text-gold transition text-sm font-medium">
                <i class="fas fa-clipboard-list w-6 text-center"></i> Semua Pesanan
            </a>
            
            <p class="px-4 text-[10px] text-dim uppercase tracking-widest font-bold mb-2 mt-6">Manajemen</p>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-void/50 text-dim hover:text-gold transition text-sm font-medium">
                <i class="fas fa-users w-6 text-center"></i> Staff / User
            </a>

            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-void/50 text-dim hover:text-gold transition text-sm font-medium">
                <i class="fas fa-file-invoice-dollar w-6 text-center"></i> Laporan Keuangan
            </a>
        </nav>

        <div class="p-4 border-t border-white/5 bg-void/30">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 p-3 w-full rounded-lg text-red-400 hover:bg-red-500/10 transition text-xs font-bold uppercase tracking-widest border border-red-500/20 hover:border-red-500">
                    <i class="fas fa-power-off w-5"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative bg-void">
        
        <header class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-void/80 backdrop-blur-md sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="md:hidden text-gold text-2xl hover:text-white transition">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h2 class="text-lg md:text-xl font-serif italic text-gold">Dashboard Overview</h2>
                    <p class="text-[10px] text-dim hidden md:block">Halo, {{ auth()->user()->name }}. Selamat bekerja.</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="bg-surface border border-white/10 px-4 py-1 rounded-full text-[10px] font-mono text-dim shadow-inner">
                    {{ now()->format('d M Y') }}
                </span>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8 pb-20">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-surface rounded-xl p-5 border-l-4 border-gold shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-[10px] text-dim uppercase tracking-widest font-bold">Total Omzet</p>
                        <h3 class="text-xl font-serif italic text-moon mt-1">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center text-gold border border-gold/20">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
                <div class="bg-surface rounded-xl p-5 border-l-4 border-green-500 shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-[10px] text-dim uppercase tracking-widest font-bold">Hari Ini</p>
                        <h3 class="text-xl font-serif italic text-moon mt-1">Rp {{ number_format($todayRevenue ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center text-green-500 border border-green-500/20">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
                <div class="bg-surface rounded-xl p-5 border-l-4 border-blue-500 shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-[10px] text-dim uppercase tracking-widest font-bold">Total Pesanan</p>
                        <h3 class="text-xl font-serif italic text-moon mt-1">{{ number_format($totalOrders ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500 border border-blue-500/20">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
                <div class="bg-surface rounded-xl p-5 border-l-4 border-purple-500 shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-[10px] text-dim uppercase tracking-widest font-bold">Total Staff</p>
                        <h3 class="text-xl font-serif italic text-moon mt-1">{{ number_format($staffCount ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-purple-500/10 flex items-center justify-center text-purple-500 border border-purple-500/20">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="w-full bg-surface rounded-xl border border-white/5 overflow-hidden shadow-xl">
                <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center bg-void/30">
                    <h3 class="font-serif italic text-gold text-sm md:text-base">Order Terbaru</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-[10px] text-dim hover:text-white uppercase tracking-wider">Lihat Semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead class="bg-void/50 text-dim text-[10px] uppercase font-bold border-b border-white/5">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Pelanggan</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recentOrders ?? [] as $order)
                            <tr class="hover:bg-white/[0.02] transition cursor-pointer" onclick="window.location='{{ route('admin.orders.show', $order->id) }}'">
                                <td class="px-6 py-4 font-mono text-gold text-xs">#{{ $order->order_number }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-moon font-medium">{{ $order->customer_name }}</div>
                                    <div class="text-[10px] text-dim">{{ $order->kasir->name ?? 'System' }}</div>
                                </td>
                                <td class="px-6 py-4 font-bold text-moon">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-[9px] font-bold uppercase tracking-wider 
                                        {{ $order->status == 'completed' ? 'bg-green-500/10 text-green-400' : 
                                          ($order->status == 'processing' ? 'bg-blue-500/10 text-blue-400' : 'bg-yellow-500/10 text-yellow-500') }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-dim text-xs italic">Belum ada pesanan hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
</body>
</html>