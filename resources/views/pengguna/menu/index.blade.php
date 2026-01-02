<x-user-layout>
    <div class="text-center py-10 mb-8 border-b border-white/5 relative">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gold/5 rounded-full blur-3xl -z-10"></div>
        
        <span class="text-xs font-sans font-bold text-dim tracking-[0.3em] uppercase mb-4 block">Katalog Rasa</span>
        <h1 class="font-serif text-4xl md:text-5xl text-moon italic mb-4">
            Pilih Teman <span class="text-gold">Melamun.</span>
        </h1>
        <p class="text-dim text-sm max-w-lg mx-auto font-light leading-relaxed">
            Dari biji kopi pilihan hingga hidangan penenang jiwa. 
            Silakan pilih, tidak perlu terburu-buru.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 pb-20">
        @forelse($products as $product)
        <div class="group relative bg-surface rounded-xl overflow-hidden border border-white/5 hover:border-gold/30 transition duration-500 hover:-translate-y-1 flex flex-col h-full shadow-lg shadow-black/20">
            
            <div class="relative h-60 overflow-hidden bg-void">
                @if($product->image)
                    {{-- Di sini perubahan utamanya: Langsung memanggil path dari database --}}
                    <img src="{{ asset($product->image) }}" 
                         class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-110 transition duration-1000 ease-in-out grayscale group-hover:grayscale-0" 
                         alt="{{ $product->name }}">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-dim bg-white/5">
                        <i class="fas fa-mug-hot text-3xl mb-2 opacity-30"></i>
                        <span class="text-[10px] uppercase tracking-widest">No Image</span>
                    </div>
                @endif
                
                @if(!$product->is_available)
                    <div class="absolute inset-0 bg-void/80 backdrop-blur-sm flex items-center justify-center z-20">
                        <span class="text-red-400 font-bold uppercase tracking-[0.2em] border border-red-400/50 px-4 py-2 text-xs rounded">
                            Habis
                        </span>
                    </div>
                @endif
            </div>

            <div class="p-5 flex flex-col flex-1 relative">
                <div class="mb-3">
                    <h3 class="font-serif text-lg text-moon group-hover:text-gold transition-colors duration-300">
                        {{ $product->name }}
                    </h3>
                    <p class="text-[10px] text-dim uppercase tracking-wider mt-1">
                        {{ $product->category->name ?? 'Menu Spesial' }}
                    </p>
                </div>
                
                <p class="text-dim text-xs leading-relaxed mb-6 line-clamp-2 flex-1 font-light border-l border-white/10 pl-3">
                    {{ $product->description ?? 'Sebuah rasa yang sulit dijelaskan kata-kata.' }}
                </p>
                
                <div class="flex items-center justify-between mt-auto pt-4 border-t border-white/5">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-dim uppercase">Harga</span>
                        <span class="text-gold font-bold font-sans text-lg">
                            {{ number_format($product->price, 0, ',', '.') }}<span class="text-xs text-dim font-normal">k</span>
                        </span>
                    </div>
                    
                    @if($product->is_available)
                        <form action="{{ route('pengguna.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            
                            <button type="submit" class="w-10 h-10 rounded-full bg-white/5 hover:bg-gold text-gold hover:text-void border border-gold/30 hover:border-gold flex items-center justify-center transition-all duration-300 shadow-lg shadow-gold/5 group-hover:shadow-gold/20" title="Tambah ke Keranjang">
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>
                    @else
                        <button disabled class="w-10 h-10 rounded-full border border-white/5 text-dim flex items-center justify-center cursor-not-allowed opacity-50">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center border border-dashed border-white/10 rounded-xl">
            <div class="text-dim text-4xl mb-4 opacity-20"><i class="fas fa-wind"></i></div>
            <h3 class="text-moon font-serif text-xl italic">Menu Sedang Kosong</h3>
            <p class="text-dim text-xs mt-2 uppercase tracking-widest">Dapur sedang istirahat.</p>
        </div>
        @endforelse
    </div>
</x-user-layout>