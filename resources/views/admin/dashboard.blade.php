<x-admin-layout>
    
    <div class="mb-8 flex justify-between items-center border-b border-white/10 pb-4">
        <div>
            <h2 class="text-3xl font-serif italic text-gold">Dashboard Overview</h2>
            <p class="text-dim text-sm">Ringkasan aktivitas toko hari ini.</p>
        </div>
        <div class="text-right">
            <span class="bg-gold/20 text-gold text-xs font-semibold px-3 py-1 rounded-full border border-gold/30">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-surface rounded-xl shadow-xl shadow-black/20 p-6 border-l-4 border-gold flex items-center justify-between transition transform hover:scale-[1.01]">
            <div>
                <p class="text-dim text-xs font-bold uppercase tracking-wider">Total Pendapatan</p>
                <h3 class="text-2xl font-serif italic text-moon mt-1">
                    Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                </h3>
            </div>
            <div class="p-3 bg-gold/10 rounded-full text-gold border border-gold/30">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
        </div>

        <div class="bg-surface rounded-xl shadow-xl shadow-black/20 p-6 border-l-4 border-green-500 flex items-center justify-between transition transform hover:scale-[1.01]">
            <div>
                <p class="text-dim text-xs font-bold uppercase tracking-wider">Pendapatan Hari Ini</p>
                <h3 class="text-2xl font-serif italic text-moon mt-1">
                    Rp {{ number_format($todayRevenue ?? 0, 0, ',', '.') }}
                </h3>
            </div>
            <div class="p-3 bg-green-600/10 rounded-full text-green-400 border border-green-600/30">
                <i class="fas fa-calendar-day text-xl"></i>
            </div>
        </div>

        <div class="bg-surface rounded-xl shadow-xl shadow-black/20 p-6 border-l-4 border-blue-500 flex items-center justify-between transition transform hover:scale-[1.01]">
            <div>
                <p class="text-dim text-xs font-bold uppercase tracking-wider">Total Pesanan</p>
                <h3 class="text-2xl font-serif italic text-moon mt-1">
                    {{ number_format($totalOrders ?? 0, 0, ',', '.') }}
                </h3>
            </div>
            <div class="p-3 bg-blue-600/10 rounded-full text-blue-400 border border-blue-600/30">
                <i class="fas fa-shopping-bag text-xl"></i>
            </div>
        </div>

        <div class="bg-surface rounded-xl shadow-xl shadow-black/20 p-6 border-l-4 border-purple-500 flex items-center justify-between transition transform hover:scale-[1.01]">
            <div>
                <p class="text-dim text-xs font-bold uppercase tracking-wider">Total Produk</p>
                <h3 class="text-2xl font-serif italic text-moon mt-1">
                    {{ number_format($totalProducts ?? 0, 0, ',', '.') }}
                </h3>
            </div>
            <div class="p-3 bg-purple-600/10 rounded-full text-purple-400 border border-purple-600/30">
                <i class="fas fa-box-open text-xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-surface rounded-xl shadow-xl shadow-black/20 overflow-hidden border border-white/5">
            <div class="px-6 py-4 border-b border-white/10 flex justify-between items-center bg-void/30">
                <h3 class="font-serif italic text-gold">Order Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-dim hover:text-moon transition">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-void/50 text-dim uppercase text-xs font-semibold border-b border-white/10">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Pelanggan</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($recentOrders ?? [] as $order)
                        <tr class="hover:bg-void/50 transition cursor-pointer" onclick="window.location='{{ route('admin.orders.show', $order->id) }}'">
                            <td class="px-6 py-4 font-bold text-gold font-mono">#{{ $order->id }}</td>
                            <td class="px-6 py-4 text-dim">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="px-6 py-4 text-moon font-mono">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($order->status) {
                                        'completed' => 'bg-green-600/10 text-green-400 border border-green-600/30',
                                        'processing' => 'bg-blue-600/10 text-blue-400 border border-blue-600/30',
                                        'pending' => 'bg-yellow-600/10 text-yellow-400 border border-yellow-600/30',
                                        default => 'bg-dim/10 text-dim border border-dim/30',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-bold {{ $statusClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-dim italic">
                                Belum ada transaksi terbaru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-surface rounded-xl shadow-xl shadow-black/20 overflow-hidden h-fit border border-white/5">
            <div class="px-6 py-4 border-b border-white/10 bg-void/30">
                <h3 class="font-serif italic text-gold">Produk Terlaris (Top 5)</h3>
            </div>
            <div class="p-0">
                <ul class="divide-y divide-white/5">
                    @forelse($topProducts ?? [] as $index => $product)
                    <li class="flex items-center px-6 py-4 hover:bg-void/50 transition">
                        <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-gold/10 text-gold border border-gold/30 rounded-full font-bold text-xs mr-4">
                            {{ $index + 1 }}
                        </span>
                        
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-moon truncate">
                                {{ $product->name }}
                            </p>
                            <p class="text-xs text-dim">
                                Terjual: <span class="font-bold text-moon">{{ $product->order_items_count ?? 0 }}</span>
                            </p>
                        </div>

                        <div class="text-sm font-semibold text-moon font-mono">
                            Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                        </div>
                    </li>
                    @empty
                    <li class="px-6 py-8 text-center text-dim text-sm italic">
                        Belum ada data penjualan produk.
                    </li>
                    @endforelse
                </ul>
            </div>
            <div class="px-6 py-3 bg-void/30 border-t border-white/10 text-center">
                <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-gold hover:text-moon uppercase tracking-wide">
                    Kelola Produk →
                </a>
            </div>
        </div>

    </div>

</x-admin-layout>