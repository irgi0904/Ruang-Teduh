<x-user-layout>
    <div class="max-w-2xl mx-auto">
        
        <div class="text-center mb-10">
            <span class="text-xs text-gold uppercase tracking-[0.3em]">Langkah Terakhir</span>
            <h1 class="text-3xl font-serif italic text-moon mt-2">Konfirmasi Pesanan</h1>
        </div>

        <div class="bg-surface border border-white/10 rounded-xl overflow-hidden shadow-2xl">
            <div class="p-8">
                <form action="{{ route('pengguna.checkout.process') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-dim uppercase tracking-widest mb-2">Atas Nama</label>
                        <input type="text" name="customer_name" value="{{ auth()->user()->name }}" readonly 
                            class="block w-full bg-void border border-white/10 rounded text-dim cursor-not-allowed focus:ring-0">
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-dim uppercase tracking-widest mb-2">Nomor Meja</label>
                            <input type="text" name="table_number" placeholder="Cth: 08" required
                                class="block w-full bg-void border border-white/10 rounded text-moon focus:border-gold focus:ring-gold/50 placeholder-white/10 transition">
                            <p class="text-[10px] text-dim mt-1">*Lihat stiker di atas meja</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-dim uppercase tracking-widest mb-2">Pembayaran</label>
                            <select name="payment_method" class="block w-full bg-void border border-white/10 rounded text-moon focus:border-gold focus:ring-gold/50 transition">
                                <option value="cash">Kasir (Tunai)</option>
                                <option value="qris">QRIS (Scan)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-dim uppercase tracking-widest mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" rows="2" placeholder="Jangan terlalu manis, es batu dikit aja..."
                            class="block w-full bg-void border border-white/10 rounded text-moon focus:border-gold focus:ring-gold/50 placeholder-white/10 transition"></textarea>
                    </div>

                    <div class="bg-void/50 p-4 rounded border border-white/5 flex justify-between items-center mt-6">
                        <span class="text-xs text-dim uppercase tracking-widest">Total Tagihan</span>
                        <span class="font-serif text-xl text-gold italic">
                            Rp {{ number_format($cartTotal['total'], 0, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" class="w-full bg-gold hover:bg-white text-void font-bold py-4 rounded shadow-lg transition duration-300 uppercase tracking-widest text-xs mt-6 transform hover:-translate-y-1">
                        Buat Pesanan Sekarang
                    </button>
                    
                    <div class="text-center">
                        <a href="{{ route('pengguna.cart.index') }}" class="text-xs text-dim hover:text-gold transition underline decoration-dim hover:decoration-gold underline-offset-4">
                            Kembali ke Keranjang
                        </a>
                    </div>
                </form>
            </div>
            
            <div class="h-2 bg-gradient-to-r from-void via-gold to-void opacity-30"></div>
        </div>
    </div>
</x-user-layout>