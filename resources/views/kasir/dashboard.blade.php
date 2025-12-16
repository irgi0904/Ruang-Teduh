<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Dashboard | Ruang Teduh</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'void': '#0F0F0F',     
                        'surface': '#1A1A1A', 
                        'moon': '#E0E0E0',    /
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
</head>
<body class="bg-void font-sans leading-normal tracking-normal text-moon">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-void border-r border-white/10 text-white hidden md:block flex-shrink-0 shadow-2xl shadow-black/50">
            <div class="p-4 font-serif italic text-xl text-center border-b border-white/10 text-gold">
                ruang teduh.
            </div>
            <div class="p-4 flex items-center justify-center flex-col border-b border-white/10">
                <div class="w-16 h-16 bg-gold/20 text-gold rounded-full flex items-center justify-center text-2xl font-bold mb-2 border border-gold/50">
                    {{ substr(Auth::user()->name ?? 'K', 0, 1) }}
                </div>
                <p class="text-sm text-dim">Selamat Bekerja,</p>
                <p class="font-bold text-moon">{{ Auth::user()->name ?? 'Kasir' }}</p>
            </div>
            <ul class="mt-4 space-y-2 px-4">
                <li>
                    <a href="{{ route('kasir.dashboard') }}" class="block py-2 px-4 rounded-lg bg-surface border-l-4 border-gold text-white shadow-inner shadow-black/10">
                        <i class="fas fa-home w-6"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.orders.create') }}" class="block py-2 px-4 rounded-lg hover:bg-surface text-dim hover:text-gold transition">
                        <i class="fas fa-cash-register w-6"></i> Mesin Kasir (POS)
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.orders.index') }}" class="block py-2 px-4 rounded-lg hover:bg-surface text-dim hover:text-gold transition">
                        <i class="fas fa-history w-6"></i> Riwayat Transaksi
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block py-2 px-4 rounded-lg hover:bg-red-900/50 text-dim hover:text-red-400 transition duration-200">
                            <i class="fas fa-sign-out-alt w-6"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            
            <header class="bg-surface shadow-lg shadow-black/10 px-6 py-4 flex justify-between items-center border-b border-white/10">
                <h2 class="text-xl font-bold text-moon">Overview Hari Ini</h2>
                <div class="text-sm text-dim">
                    <i class="far fa-calendar-alt text-gold"></i> {{ date('d M Y') }}
                </div>
            </header>

            <main class="w-full flex-grow p-6">

                <div class="mb-8">
                    <a href="{{ route('kasir.orders.create') }}" class="block w-full bg-gold hover:bg-white text-void rounded-lg shadow-xl shadow-black/30 p-6 text-center transition transform hover:scale-[1.01]">
                        <i class="fas fa-cart-plus text-4xl mb-2"></i>
                        <h3 class="text-2xl font-bold">BUKA TRANSAKSI BARU</h3>
                        <p class="text-void/80 font-medium">Klik di sini untuk mulai melayani pelanggan</p>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    
                    <div class="bg-surface rounded-lg shadow-xl shadow-black/20 p-5 border-l-4 border-gold">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-dim text-sm font-bold uppercase">Omset Saya Hari Ini</p>
                                <h3 class="text-3xl font-serif text-moon italic">Rp {{ number_format($todayRevenue ?? 0, 0, ',', '.') }}</h3>
                            </div>
                            <div class="bg-gold/10 text-gold p-3 rounded-full border border-gold/30">
                                <i class="fas fa-wallet fa-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-surface rounded-lg shadow-xl shadow-black/20 p-5 border-l-4 border-moon/50">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-dim text-sm font-bold uppercase">Pelanggan Dilayani</p>
                                <h3 class="text-3xl font-serif text-moon italic">{{ $todayTransactionCount ?? 0 }}</h3>
                            </div>
                            <div class="bg-moon/10 text-moon p-3 rounded-full border border-white/10">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-surface rounded-lg shadow-xl shadow-black/20 overflow-hidden border border-white/5">
                    <div class="px-6 py-4 border-b border-white/10 flex justify-between items-center bg-void/30">
                        <h3 class="font-bold text-moon">Transaksi Terakhir Anda</h3>
                        <a href="{{ route('kasir.orders.index') }}" class="text-sm text-gold hover:text-white transition">Lihat Semua →</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm whitespace-nowrap">
                            <thead class="bg-surface/50 text-dim uppercase text-xs border-b border-white/5">
                                <tr>
                                    <th class="px-6 py-3">ID Order</th>
                                    <th class="px-6 py-3">Total</th>
                                    <th class="px-6 py-3">Waktu</th>
                                    <th class="px-6 py-3 text-center">Struk</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($recentOrders as $order)
                                <tr class="hover:bg-void/50 transition">
                                    <td class="px-6 py-4 font-bold text-gold font-mono">#{{ $order->id }}</td>
                                    <td class="px-6 py-4 text-moon font-mono">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-dim">{{ $order->created_at->format('H:i') }} WIB</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('kasir.orders.receipt', $order->id) }}" target="_blank" class="text-dim hover:text-gold transition">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-6 text-center text-dim italic">
                                        Belum ada transaksi hari ini. Semangat!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>