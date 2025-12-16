<x-admin-layout>
    <div class="container px-6 mx-auto grid">
        
        <div class="mt-6">
            <a href="{{ route('admin.orders.index') }}" class="flex items-center text-sm text-dim hover:text-moon transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pesanan
            </a>
        </div>

        <h2 class="my-6 text-3xl font-serif italic text-gold border-b border-white/10 pb-4">
            Detail Transaksi #{{ $order->id }}
        </h2>

        <div class="grid gap-6 mb-8 md:grid-cols-3">
            
            <div class="min-w-0 p-6 bg-surface rounded-lg shadow-xl shadow-black/20 border border-white/5 md:col-span-2">
                <h4 class="mb-4 font-serif text-moon border-b border-white/10 pb-2">Rincian Item</h4>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-dim">
                        <thead class="text-xs text-dim uppercase bg-void/50 border-b border-white/10">
                            <tr>
                                <th class="px-4 py-2">Produk</th>
                                <th class="px-4 py-2 text-center">Qty</th>
                                <th class="px-4 py-2 text-right">Harga Satuan</th>
                                <th class="px-4 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($order->items as $item)
                            <tr class="hover:bg-void/50 transition">
                                <td class="px-4 py-3 font-medium text-moon">
                                    {{ $item->product_name }}
                                    @if($item->notes)
                                        <div class="text-xs text-dim italic">Catatan: {{ $item->notes }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-moon">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-right text-dim font-mono">Rp {{ number_format($item->product_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-bold text-moon font-mono">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-void/50 border-t border-gold">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-bold text-moon">Total Akhir</td>
                                <td class="px-4 py-3 text-right font-bold text-2xl text-gold font-serif italic">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                
                <div class="min-w-0 p-6 bg-surface rounded-lg shadow-xl shadow-black/20 border border-white/5">
                    <h4 class="mb-4 font-serif text-moon border-b border-white/10 pb-2">Informasi Transaksi</h4>
                    <div class="text-sm space-y-3">
                        <div>
                            <span class="text-dim block">Nama Pelanggan:</span>
                            <span class="font-bold text-moon">{{ $order->user->name ?? $order->customer_name ?? 'Guest' }}</span>
                        </div>
                        <div>
                            <span class="text-dim block">Tipe Pesanan:</span>
                            <span class="font-bold text-gold uppercase bg-gold/10 px-2 py-1 rounded text-xs border border-gold/30">{{ $order->order_type }}</span>
                        </div>
                        @if($order->table_number)
                        <div>
                            <span class="text-dim block">Nomor Meja:</span>
                            <span class="font-bold text-moon">{{ $order->table_number }}</span>
                        </div>
                        @endif
                        <div>
                            <span class="text-dim block">Metode Pembayaran:</span>
                            <span class="font-bold text-moon uppercase">{{ $order->payment->payment_method ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-dim block">Waktu Pesan:</span>
                            <span class="text-moon">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>

                <div class="min-w-0 p-6 bg-surface rounded-lg shadow-xl shadow-black/20 border-l-4 border-gold">
                    <h4 class="mb-4 font-serif text-moon">Update Status Pesanan</h4>
                    
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm text-dim mb-2">Status Saat Ini:
                                @php
                                    $statusBadge = match($order->status) {
                                        'completed' => '🟢 Selesai',
                                        'processing' => '🔵 Dimasak',
                                        'pending' => '🟡 Menunggu',
                                        'cancelled' => '🔴 Dibatalkan',
                                        default => '⚪ Lainnya',
                                    };
                                @endphp
                                <span class="font-bold text-moon">{{ $statusBadge }}</span>
                            </label>

                            <select name="status" class="block w-full mt-1 text-sm bg-void border border-white/10 text-moon rounded-md focus:border-gold focus:outline-none focus:ring-gold transition">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>🟡 Menunggu (Pending)</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>🔵 Sedang Dimasak (Processing)</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>🟢 Selesai (Completed)</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>🔴 Batalkan (Cancelled)</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium leading-5 text-void transition-colors duration-150 bg-gold border border-transparent rounded-lg active:bg-gold hover:bg-white focus:outline-none focus:shadow-outline-gold shadow-md shadow-gold/20">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>