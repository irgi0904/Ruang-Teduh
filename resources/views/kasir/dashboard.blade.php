<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir POS | Ruang Teduh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { 
                extend: { 
                    colors: { 
                        'primary': '#FFFFFF',
                        'surface': '#F8FAFC',
                        'gold': '#B68D40',
                        'slate': '#0F172A',
                        'dim': '#64748B'
                    } 
                } 
            }
        }
    </script>
</head>
<body class="bg-surface text-slate font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="fixed inset-0 bg-slate-900/50 z-40 lg:hidden" x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition opacity-0 ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 w-64 bg-primary border-r border-slate-200 z-50 transform lg:translate-x-0 lg:static lg:inset-0 transition duration-300 ease-in-out flex flex-col shadow-xl lg:shadow-none">
        <div class="p-6 text-gold italic font-serif text-2xl text-center border-b border-slate-100 flex justify-between items-center lg:justify-center">
            ruang teduh.
            <button @click="sidebarOpen = false" class="lg:hidden text-dim"><i class="fas fa-times"></i></button>
        </div>
        
        <nav class="p-4 space-y-1 flex-1">
            <a href="{{ route('kasir.dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl bg-orange-50 text-gold text-sm font-bold">
                <i class="fas fa-home w-5"></i> Dashboard
            </a>
            <a href="{{ route('kasir.orders.create') }}" class="flex items-center gap-3 p-3 rounded-xl text-dim hover:bg-slate-50 hover:text-slate transition text-sm font-medium">
                <i class="fas fa-cart-plus w-5"></i> Tambah Pesanan
            </a>
            <a href="{{ route('kasir.orders.index') }}" class="flex items-center gap-3 p-3 rounded-xl text-dim hover:bg-slate-50 hover:text-slate transition text-sm">
                <i class="fas fa-history w-5"></i> Daftar Pesanan
            </a>
        </nav>

        <div class="p-4 border-t border-slate-100 space-y-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 p-3 w-full rounded-xl text-red-500 hover:bg-red-50 transition text-sm font-bold">
                    <i class="fas fa-power-off w-5"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen">
        <header class="p-4 md:p-6 bg-primary border-b border-slate-200 flex justify-between items-center sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-dim hover:text-slate"><i class="fas fa-bars text-xl"></i></button>
                <h1 class="text-lg md:text-xl font-serif italic text-slate font-bold tracking-tight">Pusat Kasir</h1>
            </div>
            <div class="text-[10px] text-dim font-mono tracking-widest uppercase text-right hidden sm:block">
                {{ date('d M Y') }} | <span id="clock" class="text-slate font-bold">{{ date('H:i') }}</span>
            </div>
        </header>

        <main class="p-4 md:p-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
                <div class="bg-primary p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-[10px] text-dim uppercase tracking-widest font-bold mb-2">Pendapatan</p>
                    <p class="text-xl md:text-2xl font-bold text-slate">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-primary p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <p class="text-[10px] text-dim uppercase tracking-widest font-bold mb-2">Total Nota</p>
                    <p class="text-xl md:text-2xl font-bold text-slate">{{ $recentOrders->count() }}</p>
                </div>
                <div class="bg-primary p-5 rounded-2xl border border-yellow-100 shadow-sm">
                    <p class="text-[10px] text-yellow-600 uppercase tracking-widest font-bold mb-2">Pesanan Aktif</p>
                    <p class="text-xl md:text-2xl font-bold text-yellow-600">{{ $pendingOrders + $processingOrders }}</p>
                </div>
                <div class="bg-primary p-5 rounded-2xl border border-emerald-100 shadow-sm">
                    <p class="text-[10px] text-emerald-600 uppercase tracking-widest font-bold mb-2">Selesai</p>
                    <p class="text-xl md:text-2xl font-bold text-emerald-600">{{ $completedToday }}</p>
                </div>
            </div>

            <div class="bg-primary rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-4 md:p-6 border-b border-slate-100 flex justify-between items-center bg-white">
                    <h3 class="font-serif italic text-slate text-lg font-bold">Status Pesanan</h3>
                    <a href="{{ route('kasir.orders.create') }}" class="bg-gold text-white px-4 py-2 rounded-xl text-[10px] font-bold uppercase hover:opacity-90 transition"><i class="fas fa-plus mr-1"></i> Baru</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm min-w-[600px]">
                        <thead class="bg-slate-50 text-[10px] text-dim uppercase tracking-widest font-bold border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">Nota</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-mono text-gold font-bold text-xs uppercase">#{{ $order->order_number }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-slate font-bold">{{ $order->customer_name }}</div>
                                    <div class="text-[9px] text-dim uppercase">Meja: {{ $order->table_number ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 font-bold text-slate">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('kasir.orders.show', $order) }}" class="text-dim hover:text-gold transition"><i class="fas fa-eye text-lg"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        setInterval(() => {
            const now = new Date();
            document.getElementById('clock').innerText = now.getHours().toString().padStart(2, '0') + ":" + now.getMinutes().toString().padStart(2, '0');
        }, 1000);
    </script>
</body>
</html>