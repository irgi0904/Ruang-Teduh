<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Riwayat Transaksi | Ruang Teduh</title>
    
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
</head>
<body class="bg-void font-sans">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-void border-r border-white/10 text-white hidden md:block flex-shrink-0 shadow-2xl shadow-black/50">
            <div class="p-4 font-serif italic text-xl text-center border-b border-white/10 text-gold">
                ruang teduh.
            </div>
            
            <div class="p-4 flex items-center justify-center flex-col border-b border-white/10">
                <div class="w-16 h-16 bg-gold/20 text-gold rounded-full flex items-center justify-center text-2xl font-bold mb-2 border border-gold/50">
                    {{ substr(Auth::user()->name ?? 'K', 0, 1) }}
                </div>
                <p class="font-bold text-moon">{{ Auth::user()->name ?? 'Kasir' }}</p>
                <span class="text-xs text-dim uppercase tracking-widest">{{ Auth::user()->role->name ?? 'Kasir' }}</span>
            </div>
            
            <ul class="mt-4 space-y-2 px-4">
                <li>
                    <a href="{{ route('kasir.dashboard') }}" class="block py-2 px-4 rounded-lg hover:bg-surface text-dim hover:text-gold transition">
                        <i class="fas fa-home w-6"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.orders.index') }}" class="block py-2 px-4 rounded-lg bg-surface border-l-4 border-gold text-white shadow-inner shadow-black/10">
                        <i class="fas fa-history w-6"></i> Riwayat Transaksi
                    </a>
                </li>
                <li>
                    <a href="{{ route('kasir.orders.create') }}" class="block py-2 px-4 rounded-lg hover:bg-surface text-dim hover:text-gold transition">
                        <i class="fas fa-cash-register w-6"></i> Transaksi Baru
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
                <h2 class="text-xl font-serif italic text-moon">Riwayat Penjualan</h2>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-dim">Halo, {{ Auth::user()->name ?? 'Kasir' }}</span>
                    <div class="h-8 w-8 rounded-full bg-gold/50 flex items-center justify-center text-moon font-bold border border-gold">K</div>
                </div>
            </header>

            <main class="w-full flex-grow p-6">
                <div class="mb-6 flex justify-between items-center">
                    <h3 class="text-lg font-serif italic text-gold">Transaksi Hari Ini</h3>
                    <a href="{{ route('kasir.orders.create') }}" class="bg-gold hover:bg-white text-void font-bold py-2 px-4 rounded shadow-lg transition transform hover:scale-[1.01]">
                        <i class="fas fa-plus mr-2"></i> Transaksi Baru
                    </a>
                </div>

                <div class="bg-surface rounded-lg shadow-xl shadow-black/20 overflow-hidden border border-white/5">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="bg-void/50 text-dim uppercase text-xs leading-normal border-b border-white/10">
                                <th class="py-3 px-6 text-left">No. Order</th>
                                <th class="py-3 px-6 text-left">Waktu</th>
                                <th class="py-3 px-6 text-center">Total</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-moon text-sm font-light divide-y divide-white/5">
                            {{-- @forelse($orders as $order) --}}
                            <tr class="border-b border-white/5 hover:bg-void/50">
                                <td class="py-3 px-6 text-left font-bold text-gold font-mono">#ORD-001</td>
                                <td class="py-3 px-6 text-left text-dim">10:45 WIB</td>
                                <td class="py-3 px-6 text-center font-mono">Rp 150.000</td>
                                <td class="py-3 px-6 text-center">
                                    <span class="bg-green-600/10 text-green-400 py-1 px-3 rounded-full text-xs border border-green-600/30">Completed</span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex item-center justify-center space-x-3">
                                        <a href="{{ route('kasir.orders.show', 1) }}" class="text-dim hover:text-gold transition" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('kasir.orders.receipt', 1) }}" target="_blank" class="text-dim hover:text-moon transition" title="Cetak Struk">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                     
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>