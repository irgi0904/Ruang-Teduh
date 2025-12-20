<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan #{{ $order->order_number }} | Ruang Teduh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 'void': '#0F0F0F', 'surface': '#1A1A1A', 'moon': '#E0E0E0', 'gold': '#C69C6D', 'dim': '#888888', 'accent': '#3C824E' },
                    fontFamily: { 'serif': ['Lora', 'serif'], 'sans': ['DM Sans', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-void text-moon font-sans overflow-hidden flex h-screen">
    
    <aside class="w-64 bg-void border-r border-surface flex flex-col shadow-2xl">
        <div class="p-6 font-serif italic text-xl text-center border-b border-surface text-gold">ruang teduh.</div>
        <nav class="flex-1 p-4 space-y-2 text-sm text-dim">
            <a href="{{ route('kasir.dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-surface hover:text-gold transition">
                <i class="fas fa-home w-5"></i> Dashboard
            </a>
            <a href="{{ route('kasir.orders.create') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg hover:bg-surface hover:text-gold transition">
                <i class="fas fa-plus-circle w-5"></i> Tambah Pesanan
            </a>
            <a href="{{ route('kasir.orders.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-surface border-l-4 border-gold text-moon">
                <i class="fas fa-history w-5 text-gold"></i> Daftar Pesanan
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col overflow-y-auto">
        <header class="bg-surface/50 backdrop-blur-md px-8 py-4 flex justify-between items-center border-b border-surface sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <a href="{{ route('kasir.orders.index') }}" class="text-dim hover:text-gold transition text-xs uppercase tracking-widest font-bold">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <h2 class="text-lg font-serif italic text-gold">Rincian Pesanan #{{ $order->order_number }}</h2>
            </div>
            <div class="flex gap-3">
                @if($order->status == 'completed')
                    <a href="{{ route('kasir.orders.receipt', $order) }}" target="_blank" class="bg-white/5 border border-white/10 hover:border-gold text-moon px-4 py-2 rounded text-xs font-bold transition">
                        <i class="fas fa-print mr-2"></i> CETAK STRUK
                    </a>
                @endif
            </div>
        </header>

        <main class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-surface rounded-xl border border-white/5 shadow-xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-white/5 bg-void/30 flex justify-between">
                            <span class="text-[10px] uppercase tracking-[0.2em] text-dim font-bold">Item yang Dipesan</span>
                            <span class="text-[10px] uppercase tracking-[0.2em] text-gold font-bold">{{ $order->items->count() }} Macam</span>
                        </div>
                        <div class="p-0">
                            <table class="w-full text-left text-sm">
                                <tbody class="divide-y divide-white/5">
                                    @foreach($order->items as $item)
                                    <tr class="hover:bg-white/[0.01] transition">
                                        <td class="px-6 py-4">
                                            <div class="text-moon font-serif italic">{{ $item->product->name }}</div>
                                            <div class="text-[10px] text-dim">Rp {{ number_format($item->price, 0, ',', '.') }} per unit</div>
                                        </td>
                                        <td class="px-6 py-4 text-center text-dim font-mono">x {{ $item->quantity }}</td>
                                        <td class="px-6 py-4 text-right font-bold text-gold font-mono">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 bg-void/20 border-t border-white/5 flex justify-between items-center">
                            <span class="text-xs text-dim italic">Catatan: {{ $order->notes ?? 'Tidak ada catatan khusus.' }}</span>
                        </div>
                    </div>

                    <div class="bg-surface rounded-xl border border-white/5 p-6 flex justify-between items-center shadow-lg">
                        <div>
                            <p class="text-[10px] text-dim uppercase tracking-widest font-bold">Status Pesanan Saat Ini</p>
                            <p class="text-xl font-serif italic text-moon mt-1">{{ ucfirst($order->status) }}</p>
                        </div>
                        @if($order->status != 'completed' && $order->status != 'cancelled')
                        <form action="{{ route('kasir.orders.markAsPaid', $order) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="bg-accent hover:bg-green-500 text-white px-6 py-3 rounded-lg font-bold text-xs uppercase tracking-widest transition shadow-lg shadow-green-900/20">
                                Tandai Selesai & Bayar
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-surface rounded-xl border border-white/5 p-6 shadow-xl">
                        <h4 class="text-gold font-serif italic mb-6 border-b border-white/5 pb-2">Informasi Pelanggan</h4>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[10px] text-dim uppercase tracking-widest">Nama Pemesan</p>
                                <p class="text-moon font-medium">{{ $order->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-dim uppercase tracking-widest">Meja / Lokasi</p>
                                <p class="text-moon font-bold font-mono text-gold">{{ $order->table_number ?? 'Bawa Pulang' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-dim uppercase tracking-widest">Waktu Transaksi</p>
                                <p class="text-moon text-sm">{{ $order->created_at->format('d M Y') }} • {{ $order->created_at->format('H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-surface rounded-xl border border-gold/20 p-6 shadow-xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-5 text-4xl">
                            <i class="fas fa-wallet text-gold"></i>
                        </div>
                        <h4 class="text-gold font-serif italic mb-6 border-b border-white/5 pb-2 text-center">Ringkasan Biaya</h4>
                        <div class="space-y-3 font-sans">
                            <div class="flex justify-between text-sm">
                                <span class="text-dim">Subtotal</span>
                                <span class="text-moon">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-dim">Pajak / Layanan</span>
                                <span class="text-moon">Rp 0</span>
                            </div>
                            <div class="border-t border-white/10 pt-4 flex justify-between items-center">
                                <span class="text-xs uppercase text-gold font-bold tracking-widest">Total Akhir</span>
                                <span class="text-2xl font-serif text-gold font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if($order->payment)
                        <div class="mt-6 pt-6 border-t border-dashed border-white/10 space-y-2">
                            <div class="flex justify-between text-[10px] uppercase font-bold">
                                <span class="text-dim">Metode:</span>
                                <span class="text-moon">{{ strtoupper($order->payment->payment_method) }}</span>
                            </div>
                            <div class="flex justify-between text-[10px] uppercase font-bold">
                                <span class="text-dim">Diterima:</span>
                                <span class="text-moon">Rp {{ number_format($order->payment->amount ?? $order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>