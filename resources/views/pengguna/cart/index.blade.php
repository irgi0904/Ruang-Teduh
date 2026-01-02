<x-user-layout>
    <div class="max-w-5xl mx-auto">
        <div class="mb-8 flex items-center gap-3 border-b border-white/5 pb-4">
            <i class="fas fa-shopping-bag text-gold text-xl"></i>
            <h1 class="text-2xl font-serif italic text-moon">Keranjang Harapan</h1>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="flex-1">
                @if(session('cart') && count(session('cart')) > 0)
                    
                    @php $total = 0; @endphp

                    <div class="space-y-4">
                        @foreach(session('cart') as $id => $details)
                        
                            @php $total += $details['price'] * $details['quantity']; @endphp

                            <div class="bg-surface p-4 rounded-lg border border-white/5 flex gap-4 items-center group hover:border-gold/30 transition duration-300 relative overflow-hidden">
                                
                                <div class="absolute inset-0 bg-gold/5 opacity-0 group-hover:opacity-100 transition duration-500 pointer-events-none"></div>

                                <div class="w-20 h-20 bg-void rounded-lg overflow-hidden flex-shrink-0 border border-white/5">
                                    @if(isset($details['image']) && $details['image'])
                                        {{-- PERBAIKAN DI SINI: Menghapus 'storage/' karena path sudah ada di folder public --}}
                                        <img src="{{ asset($details['image']) }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-dim">
                                            <i class="fas fa-mug-hot"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1 z-10">
                                    <h3 class="font-serif text-lg text-moon">{{ $details['name'] }}</h3>
                                    <p class="text-xs text-dim mb-2">Rp {{ number_format($details['price'], 0, ',', '.') }} / item</p>
                                    
                                    <div class="text-[10px] text-dim bg-void/50 px-2 py-1 rounded inline-block border border-white/5">
                                        <i class="fas fa-pen mr-1"></i> {{ $details['note'] ?? 'Tanpa catatan' }}
                                    </div>
                                </div>

                                <div class="text-right z-10">
                                    <p class="font-bold text-gold mb-2 text-lg">
                                        Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                    </p>
                                    
                                    <div class="flex items-center justify-end gap-3">
                                        <span class="text-xs font-mono text-dim border border-white/10 px-2 py-1 rounded">x{{ $details['quantity'] }}</span>
                                        
                                        <form action="{{ route('pengguna.cart.remove', $id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="text-dim hover:text-red-400 text-sm p-2 transition" title="Hapus Kenangan Ini">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 text-right">
                         <form action="{{ route('pengguna.cart.clear') }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin melupakan semua pesanan?');">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-400/70 hover:text-red-400 hover:underline uppercase tracking-widest transition">
                                <i class="fas fa-eraser mr-1"></i> Kosongkan Keranjang
                            </button>
                        </form>
                    </div>

                @else
                    <div class="bg-surface rounded-xl p-12 text-center border border-dashed border-white/10">
                        <div class="w-20 h-20 bg-void rounded-full flex items-center justify-center mx-auto mb-6 text-dim border border-white/5">
                            <i class="fas fa-shopping-basket fa-2x opacity-50"></i>
                        </div>
                        <h3 class="text-lg font-serif italic text-moon mb-2">Keranjang Masih Sunyi</h3>
                        <p class="text-dim text-xs mb-8 max-w-xs mx-auto">
                            Belum ada rasa yang kamu pilih. Mari isi dengan sesuatu yang menghangatkan.
                        </p>
                        <a href="{{ route('pengguna.menu.index') }}" class="inline-block bg-gold hover:bg-white text-void font-bold px-8 py-3 rounded text-xs uppercase tracking-widest transition duration-300">
                            Jelajahi Menu
                        </a>
                    </div>
                @endif
            </div>

            @if(session('cart') && count(session('cart')) > 0)
            <div class="w-full lg:w-96">
                <div class="bg-surface rounded-xl p-6 sticky top-24 border border-gold/20 shadow-lg shadow-gold/5">
                    <h3 class="font-serif text-lg text-gold mb-6 italic border-b border-white/5 pb-2">Ringkasan</h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="justify-between flex text-dim text-sm">
                            <span>Subtotal</span>
                            <span class="text-moon font-mono">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="justify-between flex text-dim text-sm">
                            <span>Pajak (10%)</span>
                            <span class="text-moon font-mono">Rp {{ number_format($total * 0.1, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-dashed border-white/10 pt-4 flex justify-between items-end">
                            <span class="text-dim text-xs uppercase tracking-widest">Total Akhir</span>
                            <span class="text-2xl font-serif text-gold italic">Rp {{ number_format($total * 1.1, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('pengguna.cart.checkout') }}" class="block w-full bg-gold hover:bg-white text-void font-bold py-4 rounded-lg shadow-lg text-center transition duration-300 uppercase tracking-widest text-xs transform hover:-translate-y-1">
                        Lanjut Pembayaran
                    </a>
                    
                    <p class="text-[10px] text-dim text-center mt-4 opacity-50">
                        *Pastikan pesanan sudah sesuai suasana hati.
                    </p>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-user-layout>