<x-user-layout>
    <div class="max-w-4xl mx-auto">
        
        <div class="mb-10 text-center border-b border-white/5 pb-4">
            <i class="fas fa-history text-gold text-2xl mb-2"></i>
            <h1 class="text-3xl font-serif italic text-moon">Jejak Pesanan</h1>
            <p class="text-dim text-xs mt-2 uppercase tracking-widest">Riwayat pesanan yang telah kamu buat</p>
        </div>

        <div class="space-y-6">
            @forelse($orders as $order)
            <div class="bg-surface p-6 rounded-xl border border-white/10 shadow-lg shadow-black/20 hover:border-gold/30 transition duration-300">
                
                <div class="flex justify-between items-start mb-4 border-b border-white/5 pb-4">
                    <div>
                        <span class="text-xs text-gold uppercase tracking-widest border border-gold/30 px-2 py-1 rounded font-mono">
                            {{ $order->invoice_code ?? '#INV-000' . $order->id }} 
                            </span>
                        <p class="text-dim text-sm mt-2">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div class="text-right">
                        <span class="block font-serif text-2xl text-moon font-bold italic">
                            Rp {{ number_format($order->total_amount ?? $order->total) }}
                        </span>
                        
                        <span class="text-xs uppercase font-bold px-2 py-0.5 rounded-full mt-1 inline-block 
                            {{ 
                                $order->status == 'completed' ? 'text-green-400 bg-green-600/10' : 
                                ($order->status == 'pending' ? 'text-yellow-400 bg-yellow-600/10' : 
                                'text-blue-400 bg-blue-600/10') 
                            }}">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <div class="space-y-2 pt-2">
                    @forelse($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-moon font-sans">
                            {{ $item->product_name }} 
                            <span class="text-dim font-bold">x{{ $item->quantity }}</span>
                        </span>
                        <span class="text-dim font-mono">Rp {{ number_format($item->subtotal) }}</span>
                    </div>
                    @empty
                    <div class="text-xs text-dim italic">Detail pesanan tidak tersedia.</div>
                    @endforelse
                </div>
                
                <div class="text-right pt-4 mt-2 border-t border-white/5">
                    <a href="{{ route('pengguna.orders.show', $order->id) }}" 
                       class="text-xs text-gold hover:text-moon transition uppercase tracking-widest hover:underline underline-offset-4">
                        Lihat Detail →
                    </a>
                </div>
            </div>
            @empty
            <div class="bg-surface rounded-xl p-12 text-center border border-dashed border-white/10">
                <div class="text-dim text-4xl mb-4 opacity-20"><i class="fas fa-wind"></i></div>
                <p class="text-dim text-sm">Belum ada cerita yang terukir.</p>
                <a href="{{ route('pengguna.menu.index') }}" class="text-xs font-bold text-gold hover:text-white mt-4 inline-block transition uppercase tracking-wide">
                    Mulai Pesan Sekarang
                </a>
            </div>
            @endforelse
        </div>
    </div>
</x-user-layout>