<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Kasir | Ruang Teduh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'void': '#0F0F0F', 'surface': '#1A1A1A', 'gold': '#C69C6D', 'moon': '#E0E0E0', 'dim': '#888888', 'accent': '#3C824E' } } }
        }
    </script>
</head>
<body class="bg-void text-moon flex h-screen overflow-hidden font-sans">

    <aside class="w-64 bg-void border-r border-surface flex flex-col shadow-2xl">
        <div class="p-8 text-gold italic font-serif text-2xl text-center border-b border-surface">ruang teduh.</div>
        
        <nav class="p-4 space-y-2 flex-1">
            <a href="{{ route('kasir.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg bg-surface border-l-4 border-gold text-moon text-sm">
                <i class="fas fa-home w-5 text-gold"></i> Dashboard
            </a>
            <a href="{{ route('kasir.orders.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface text-dim hover:text-gold transition text-sm font-medium">
                <i class="fas fa-cart-plus w-5"></i> Tambahkan Pesanan
            </a>
            <a href="{{ route('kasir.orders.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface text-dim hover:text-gold transition text-sm">
                <i class="fas fa-history w-5"></i> Daftar Pesanan
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

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="p-6 border-b border-surface flex justify-between items-center bg-surface/30 sticky top-0 z-10 backdrop-blur-md">
            <div class="flex flex-col">
                <h1 class="text-xl font-serif italic text-gold">Pusat Kendali Kasir</h1>
                <p class="text-[10px] text-dim font-mono tracking-tighter uppercase">Operator: {{ auth()->user()->name }}</p>
            </div>
            <div class="text-[10px] text-dim font-mono tracking-widest uppercase">
                {{ date('d M Y') }} | <span id="clock">{{ date('H:i') }}</span> WIB
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div class="bg-surface p-6 rounded-2xl border border-white/5 shadow-xl">
                    <p class="text-[10px] text-dim uppercase tracking-widest font-bold mb-2">Pendapatan Hari Ini</p>
                    <p class="text-2xl font-bold text-gold font-mono">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-surface p-6 rounded-2xl border border-white/5 shadow-xl">
                    <p class="text-[10px] text-dim uppercase tracking-widest font-bold mb-2">Total Pesanan</p>
                    <p class="text-2xl font-bold text-moon font-mono">{{ $recentOrders->count() }} <span class="text-xs text-dim">Nota</span></p>
                </div>
                <div class="bg-surface p-6 rounded-2xl border border-yellow-500/20 shadow-xl">
                    <p class="text-[10px] text-yellow-500 uppercase tracking-widest font-bold mb-2">Pesanan Aktif</p>
                    <p class="text-2xl font-bold text-yellow-500 font-mono">{{ $pendingOrders + $processingOrders }}</p>
                </div>
                <div class="bg-surface p-6 rounded-2xl border border-accent/20 shadow-xl">
                    <p class="text-[10px] text-accent uppercase tracking-widest font-bold mb-2">Selesai</p>
                    <p class="text-2xl font-bold text-accent font-mono">{{ $completedToday }}</p>
                </div>
            </div>

            <div class="bg-surface rounded-2xl border border-white/5 overflow-hidden shadow-2xl">
                <div class="p-6 border-b border-white/5 bg-void/20 flex justify-between items-center">
                    <h3 class="font-serif italic text-gold text-lg">Kelola Status Pesanan Terkini</h3>
                    <a href="{{ route('kasir.orders.create') }}" class="bg-gold text-void px-5 py-2 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-white transition duration-300 shadow-lg shadow-gold/20">
                        <i class="fas fa-plus mr-2"></i> Pesanan Baru
                    </a>
                </div>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] text-dim uppercase tracking-widest border-b border-white/5 bg-void/50 font-bold">
                            <th class="px-6 py-5 text-center">Order</th>
                            <th class="px-6 py-5">Pelanggan</th>
                            <th class="px-6 py-5">Total</th>
                            <th class="px-6 py-5">Update Status</th>
                            <th class="px-6 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($recentOrders as $order)
                        <tr class="hover:bg-white/[0.02] transition group">
                            <td class="px-6 py-5 font-mono text-gold text-xs italic text-center">#{{ $order->order_number }}</td>
                            <td class="px-6 py-5">
                                <div class="text-moon font-medium">{{ $order->customer_name }}</div>
                                <div class="text-[9px] text-dim uppercase tracking-tighter">Meja: {{ $order->table_number ?? '-' }} • {{ $order->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-5 font-bold text-moon">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-5">
                                <form action="{{ route('kasir.orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="bg-void border border-white/10 rounded-lg px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest outline-none focus:border-gold transition-colors
                                        {{ $order->status == 'completed' ? 'text-accent border-accent/30' : ($order->status == 'processing' ? 'text-blue-400 border-blue-400/30' : 'text-yellow-500 border-yellow-500/30') }}">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <a href="{{ route('kasir.orders.show', $order) }}" class="text-dim hover:text-gold transition bg-void/50 p-2.5 rounded-lg border border-white/5 inline-flex items-center group-hover:border-gold/30">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        setInterval(() => {
            const now = new Date();
            document.getElementById('clock').innerText = now.getHours().toString().padStart(2, '0') + ":" + now.getMinutes().toString().padStart(2, '0');
        }, 1000);
    </script>
</body>
</html>