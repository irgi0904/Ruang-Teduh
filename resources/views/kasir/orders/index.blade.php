<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan | Ruang Teduh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'void': '#0F0F0F', 'surface': '#1A1A1A', 'gold': '#C69C6D', 'moon': '#E0E0E0', 'dim': '#888888' } } }
        }
    </script>
</head>
<body class="bg-void text-moon flex h-screen overflow-hidden font-sans">
    <aside class="w-64 bg-void border-r border-surface flex flex-col shadow-2xl">
        <div class="p-8 text-gold italic font-serif text-2xl text-center border-b border-surface">ruang teduh.</div>
        <nav class="p-4 space-y-2">
            <a href="{{ route('kasir.dashboard') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface text-dim hover:text-gold transition text-sm">
                <i class="fas fa-home w-5"></i> Dashboard
            </a>
            <a href="{{ route('kasir.orders.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface text-dim hover:text-gold transition text-sm">
                <i class="fas fa-plus-circle w-5"></i> Tambahkan Pesanan
            </a>
            <a href="{{ route('kasir.orders.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-surface border-l-4 border-gold text-moon text-sm">
                <i class="fas fa-history w-5 text-gold"></i> Daftar Pesanan
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto">
        <header class="p-6 border-b border-surface flex justify-between items-center bg-surface/30 sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('kasir.dashboard') }}" class="text-dim hover:text-gold"><i class="fas fa-arrow-left"></i></a>
                <h1 class="text-xl font-serif italic text-gold">Daftar Pesanan</h1>
            </div>
            <form action="{{ route('kasir.orders.index') }}" method="GET" class="flex gap-2">
                <input type="date" name="date" value="{{ request('date') }}" class="bg-void border border-white/10 rounded-lg px-3 py-1 text-xs text-dim outline-none focus:border-gold">
                <button type="submit" class="bg-surface border border-white/10 px-3 py-1 rounded-lg text-xs hover:text-gold transition">Filter</button>
            </form>
        </header>

        <div class="p-8">
            <div class="bg-surface rounded-xl border border-white/5 overflow-hidden shadow-2xl">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-[10px] text-dim uppercase tracking-widest border-b border-white/5 bg-void/50">
                            <th class="px-6 py-5">Order #</th>
                            <th class="px-6 py-5">Pelanggan</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5">Total</th>
                            <th class="px-6 py-5">Waktu</th>
                            <th class="px-6 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($orders as $order)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="px-6 py-5 font-mono text-gold text-xs italic tracking-tighter">#{{ $order->order_number }}</td>
                            <td class="px-6 py-5">
                                <div class="text-moon font-medium">{{ $order->customer_name }}</div>
                                <div class="text-[10px] text-dim">Meja: {{ $order->table_number ?? 'Takeaway' }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest 
                                    {{ $order->status == 'completed' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-yellow-500/10 text-yellow-400 border border-yellow-500/20' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-5 font-bold text-moon font-mono">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-5 text-dim text-xs">{{ $order->created_at->format('H:i') }} WIB</td>
                            <td class="px-6 py-5 text-right space-x-3">
                                <a href="{{ route('kasir.orders.show', $order) }}" class="text-dim hover:text-gold transition"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('kasir.orders.receipt', $order) }}" target="_blank" class="text-dim hover:text-moon transition"><i class="fas fa-print"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center text-dim italic">Belum ada pesanan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </main>
</body>
</html>