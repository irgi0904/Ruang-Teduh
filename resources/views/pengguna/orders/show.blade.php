<x-user-layout>
    <div class="max-w-3xl mx-auto">
        
        <a href="{{ route('pengguna.orders.index') }}" class="inline-block mb-6 text-dim hover:text-gold transition">
            &larr; Kembali ke Riwayat
        </a>

        <div class="bg-surface rounded-xl border border-white/10 overflow-hidden shadow-2xl shadow-black/30">
            
            <div class="bg-void p-8 text-center border-b border-gold/30">
                <p class="text-dim uppercase text-xs tracking-widest mb-2">Invoice</p>
                <h1 class="text-3xl font-mono text-gold font-bold mb-4">{{ $order->invoice_code ?? '#INV-000' . $order->id }}</h1>
                
                <div class="inline-block px-4 py-2 rounded-full text-sm font-bold uppercase 
                    {{ $order->status == 'completed' ? 'bg-green-600/10 text-green-400' : 'bg-yellow-600/10 text-yellow-400' }} border border-current/50">
                    Status: {{ $order->status }}
                </div>
            </div>

            <div class="p-8">
                <p class="text-center text-dim mb-8 italic font-light">
                    "Terima kasih telah berbagi cerita di Ruang Teduh."
                </p>

                <div class="grid grid-cols-2 gap-4 text-xs text-dim border-b border-white/5 pb-6 mb-6">
                    <div>
                        <span class="block uppercase tracking-widest text-gold mb-1">Dibuat Oleh</span>
                        {{ $order->customer_name ?? Auth::user()->name }}
                    </div>
                    <div>
                        <span class="block uppercase tracking-widest text-gold mb-1">Nomor Meja</span>
                        {{ $order->table_number ?? 'Bawa Pulang' }}
                    </div>
                </div>

                <div class="space-y-4 mb-8">
                    @forelse($order->items as $item)
                    <div class="flex justify-between items-center border-b border-white/5 pb-4 last:border-0">
                        <div>
                            <p class="text-moon font-serif text-lg">{{ $item->product_name }}</p>
                            <p class="text-sm text-dim">
                                {{ $item->quantity }} x Rp {{ number_format($item->product_price) }}
                                @if($item->notes)
                                    <span class="text-xs italic block mt-1">"Catatan: {{ $item->notes }}"</span>
                                @endif
                            </p>
                        </div>
                        <div class="text-moon font-mono text-lg font-bold">
                            Rp {{ number_format($item->subtotal) }}
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-dim italic">Item pesanan tidak ditemukan.</p>
                    @endforelse
                </div>

                <div class="bg-void/50 p-6 rounded-lg flex flex-col space-y-2 border border-white/5">
                    
                    <div class="flex justify-between text-dim text-sm">
                        <span>Subtotal</span>
                        <span class="font-mono">Rp {{ number_format($order->subtotal ?? ($order->total_amount / 1.1) ?? 0) }}</span>
                    </div>

                    <div class="flex justify-between text-dim text-sm border-b border-white/5 pb-3">
                        <span>Pajak (10%)</span>
                        <span class="font-mono">Rp {{ number_format($order->tax ?? (($order->total_amount ?? $order->total) - ($order->subtotal ?? 0)) ?? 0) }}</span>
                    </div>

                    <div class="flex justify-between items-end pt-3">
                        <span class="text-moon uppercase tracking-widest text-sm">Total Akhir</span>
                        <span class="text-3xl font-serif text-gold font-bold italic">
                            Rp {{ number_format($order->total_amount ?? $order->total) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-void p-6 text-center border-t border-gold/30">
                <p class="text-xs text-dim">
                    Pesanan dibuat pada: {{ $order->created_at->format('d F Y, H:i') }}
                </p>
            </div>
        </div>
    </div>
</x-user-layout>