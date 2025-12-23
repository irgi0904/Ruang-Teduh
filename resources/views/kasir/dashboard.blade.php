<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir | Ruang Teduh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'void': '#0F0F0F', 'surface': '#1A1A1A', 'gold': '#C69C6D', 'moon': '#E0E0E0', 'dim': '#888888', 'accent': '#3C824E' } } }
        }
    </script>
    <style>
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-void text-moon flex h-screen overflow-hidden font-sans">

    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden backdrop-blur-sm"></div>

    <aside id="sidebar" class="fixed md:relative w-64 h-full bg-void border-r border-surface flex flex-col shadow-2xl z-50 transform -translate-x-full md:translate-x-0 sidebar-transition">
        <div class="p-8 text-gold italic font-serif text-2xl text-center border-b border-surface flex justify-between items-center md:block">
            <span>ruang teduh.</span>
            <button onclick="toggleSidebar()" class="md:hidden text-dim hover:text-white">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
            <a href="{{ route('kasir.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg bg-surface border-l-4 border-gold text-moon text-sm">
                <i class="fas fa-home w-5 text-gold"></i> Dashboard
            </a>
            <a href="{{ route('kasir.orders.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface text-dim hover:text-gold transition text-sm font-medium">
                <i class="fas fa-cart-plus w-5"></i> Tambah Pesanan
            </a>
            <a href="{{ route('kasir.orders.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface text-dim hover:text-gold transition text-sm">
                <i class="fas fa-history w-5"></i> Riwayat
            </a>
        </nav>

        <div class="p-4 border-t border-surface">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 p-3 w-full rounded-lg text-red-400 hover:bg-red-500/10 transition text-sm font-bold uppercase tracking-widest">
                    <i class="fas fa-power-off w-5"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <header class="p-4 md:p-6 border-b border-surface flex justify-between items-center bg-surface/30 sticky top-0 z-10 backdrop-blur-md">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="md:hidden text-gold text-2xl">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="flex flex-col">
                    <h1 class="text-lg md:text-xl font-serif italic text-gold">Kasir Area</h1>
                    <p class="text-[10px] text-dim font-mono tracking-tighter uppercase hidden md:block">Operator: {{ auth()->user()->name }}</p>
                </div>
            </div>

            <div class="text-[10px] text-dim font-mono tracking-widest uppercase">
                <span id="clock">{{ date('H:i') }}</span> WIB
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-4 md:p-8 pb-20">
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-surface p-4 rounded-xl border border-white/5 shadow-xl">
                    <p class="text-[9px] md:text-[10px] text-dim uppercase tracking-widest font-bold mb-1">Omzet Hari Ini</p>
                    <p class="text-lg md:text-2xl font-bold text-gold font-mono">
                        Rp {{ number_format($todayRevenue ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-surface p-4 rounded-xl border border-white/5 shadow-xl">
                    <p class="text-[9px] md:text-[10px] text-dim uppercase tracking-widest font-bold mb-1">Pesanan Aktif</p>
                    <p class="text-lg md:text-2xl font-bold text-moon font-mono">
                        {{ isset($recentOrders) ? $recentOrders->count() : 0 }} <span class="text-xs text-dim">Nota</span>
                    </p>
                </div>
            </div>

            <div class="bg-surface rounded-2xl border border-white/5 overflow-hidden shadow-2xl">
                <div class="p-4 md:p-6 border-b border-white/5 bg-void/20 flex justify-between items-center">
                    <h3 class="font-serif italic text-gold text-sm md:text-lg">Antrian Pesanan</h3>
                    <a href="{{ route('kasir.orders.create') }}" class="bg-gold text-void px-3 py-2 md:px-5 rounded-lg text-[9px] md:text-[10px] font-bold uppercase tracking-widest hover:bg-white transition shadow-lg">
                        <i class="fas fa-plus md:mr-2"></i> <span class="hidden md:inline">Baru</span>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                        <thead>
                            <tr class="text-[10px] text-dim uppercase tracking-widest border-b border-white/5 bg-void/50 font-bold">
                                <th class="px-4 py-4 md:px-6">Order</th>
                                <th class="px-4 py-4 md:px-6">Pelanggan</th>
                                <th class="px-4 py-4 md:px-6">Total</th>
                                <th class="px-4 py-4 md:px-6">Status (Update)</th>
                                <th class="px-4 py-4 md:px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recentOrders ?? [] as $order)
                            <tr class="hover:bg-white/[0.02] transition">
                                <td class="px-4 py-4 md:px-6 font-mono text-gold text-xs">#{{ $order->order_number }}</td>
                                <td class="px-4 py-4 md:px-6">
                                    <div class="font-bold text-moon">{{ $order->customer_name }}</div>
                                    <div class="text-[10px] text-dim">Meja: {{ $order->table_number ?? 'TA' }}</div>
                                </td>
                                <td class="px-4 py-4 md:px-6 font-mono">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-4 py-4 md:px-6">
                                    <form action="{{ route('kasir.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="bg-void border rounded px-2 py-1 text-[10px] uppercase font-bold outline-none cursor-pointer
                                            {{ $order->status == 'completed' ? 'text-accent border-accent/50' : ($order->status == 'processing' ? 'text-blue-400 border-blue-400/50' : 'text-yellow-500 border-yellow-500/50') }}">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai (Lunas)</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-4 py-4 md:px-6 text-right flex justify-end gap-2">
                                    <a href="{{ route('kasir.orders.receipt', $order->id) }}" target="_blank" class="text-dim hover:text-gold bg-void border border-white/10 p-2 rounded" title="Cetak Struk">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('kasir.orders.show', $order->id) }}" class="text-dim hover:text-white bg-void border border-white/10 p-2 rounded" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-dim text-xs italic">Belum ada pesanan aktif.</td>
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

        setInterval(() => {
            const now = new Date();
            document.getElementById('clock').innerText = now.getHours().toString().padStart(2, '0') + ":" + now.getMinutes().toString().padStart(2, '0');
        }, 1000);
    </script>
</body>
</html>