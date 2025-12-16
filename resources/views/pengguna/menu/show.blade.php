<x-user-layout>
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl overflow-hidden my-6">
        <div class="grid grid-cols-1 md:grid-cols-2">
            
            <div class="h-64 md:h-auto bg-gray-200 relative">
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                <button onclick="history.back()" class="absolute top-4 left-4 bg-white/50 backdrop-blur p-2 rounded-full hover:bg-white transition">
                    <i class="fas fa-arrow-left text-gray-800"></i>
                </button>
            </div>

            <div class="p-8 flex flex-col justify-between h-full">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-extrabold text-gray-800 mb-2">{{ $product->name }}</h1>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-wide">
                                {{ $product->category->name ?? 'Menu' }}
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <p class="text-gray-500 leading-relaxed mb-6">
                        {{ $product->description }}
                        Rasakan kenikmatan bumbu rahasia yang meresap sempurna. Cocok dimakan selagi hangat.
                    </p>
                    
                    <div class="h-px bg-gray-100 my-6"></div>

                    <form action="{{ route('pengguna.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex items-center justify-between mb-8">
                            <span class="font-bold text-gray-700">Jumlah Porsi</span>
                            <div class="flex items-center border border-gray-300 rounded-full px-2 py-1">
                                <button type="button" class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200" onclick="decrement()">-</button>
                                <input type="number" name="quantity" id="qty" value="1" class="w-12 text-center border-none focus:ring-0 font-bold" readonly>
                                <button type="button" class="w-8 h-8 rounded-full bg-green-500 text-white hover:bg-green-600 shadow" onclick="increment()">+</button>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Khusus</label>
                            <textarea name="note" rows="2" class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500 text-sm" placeholder="Contoh: Jangan pedas, bawang dipisah..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-4 rounded-xl shadow-lg transform active:scale-95 transition flex justify-between px-8 items-center group">
                            <span>Tambah ke Keranjang</span>
                            <i class="fas fa-shopping-bag group-hover:animate-bounce"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function increment() {
            let qty = document.getElementById('qty');
            qty.value = parseInt(qty.value) + 1;
        }
        function decrement() {
            let qty = document.getElementById('qty');
            if (qty.value > 1) qty.value = parseInt(qty.value) - 1;
        }
    </script>
</x-user-layout>