<x-admin-layout>
    
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-3xl font-serif italic text-gold border-b border-white/10 pb-4">
            Daftar Pesanan Masuk
        </h2>

        <div class="w-full overflow-hidden rounded-lg shadow-xl shadow-black/20 border border-white/5">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-dim uppercase border-b border-white/10 bg-void/50">
                            <th class="px-4 py-3">ID Order</th>
                            <th class="px-4 py-3">Pelanggan</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-surface divide-y divide-white/5">
                        @forelse($orders as $order)
                        <tr class="text-moon hover:bg-void/50 transition">
                            <td class="px-4 py-3 font-bold text-gold font-mono">
                                #{{ $order->id }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <div>
                                        <p class="font-semibold">{{ $order->user->name ?? $order->customer_name ?? 'Guest' }}</p>
                                        <p class="text-xs text-dim">{{ $order->order_type }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm font-bold text-moon font-mono">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-xs">
                                @php

                                    $statusColor = match($order->status) {
                                        'completed' => 'bg-green-600/10 text-green-400 border border-green-600/30',
                                        'processing' => 'bg-blue-600/10 text-blue-400 border border-blue-600/30',
                                        'pending' => 'bg-yellow-600/10 text-yellow-400 border border-yellow-600/30',
                                        'cancelled' => 'bg-red-600/10 text-red-400 border border-red-600/30',
                                        default => 'bg-dim/10 text-dim border border-dim/30',
                                    };
                                    
                                    $statusLabel = match($order->status) {
                                        'completed' => 'Selesai',
                                        'processing' => 'Diproses',
                                        'pending' => 'Menunggu',
                                        'cancelled' => 'Dibatalkan',
                                        default => ucfirst($order->status),
                                    };
                                @endphp
                                <span class="px-2 py-1 font-semibold leading-tight rounded-full {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-dim">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="px-3 py-1 text-sm font-medium leading-5 text-void transition-colors duration-150 bg-gold border border-transparent rounded-md active:bg-gold hover:bg-white focus:outline-none focus:shadow-outline-gold">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-dim italic">
                                Belum ada pesanan masuk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if ($orders instanceof \Illuminate\Contracts\Pagination\Paginator)
            <div class="px-4 py-3 border-t border-white/10 bg-surface text-dim">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>