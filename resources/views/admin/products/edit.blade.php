<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Edit Produk: {{ $product->name }}</h2>
        <a href="{{ route('admin.products.index') }}" class="text-dim hover:text-moon transition">
            &larr; Kembali ke Daftar Produk
        </a>
    </div>

    <div class="bg-surface shadow-xl shadow-black/20 rounded-xl p-8 border border-white/5 max-w-2xl mx-auto">
        
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-moon text-sm font-medium mb-2">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                       class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition" 
                       required>
                @error('name')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-5">
                <label class="block text-moon text-sm font-medium mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3" 
                          class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div class="mb-5">
                    <label class="block text-moon text-sm font-medium mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" 
                           class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold transition" 
                           required min="0">
                    @error('price')
                        <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-moon text-sm font-medium mb-2">Stok Tersedia</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" 
                           class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold transition" 
                           required min="0">
                    @error('stock')
                        <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-moon text-sm font-medium mb-2">Kategori</label>
                <select name="category_id" required
                        class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold transition">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-moon text-sm font-medium mb-2">Status Produk</label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="is_active" value="1" 
                                class="form-radio h-4 w-4 text-gold bg-void border-white/30 focus:ring-gold"
                                {{ old('is_active', $product->is_active ?? true) == 1 ? 'checked' : '' }}>
                        <span class="ml-2 text-moon">Aktif (Tampilkan di Menu)</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="is_active" value="0" 
                                class="form-radio h-4 w-4 text-gold bg-void border-white/30 focus:ring-gold"
                                {{ old('is_active', $product->is_active ?? false) == 0 ? 'checked' : '' }}>
                        <span class="ml-2 text-moon">Nonaktif (Sembunyikan)</span>
                    </label>
                </div>
                @error('is_active')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-4 border-t border-white/10">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-dim/30 hover:bg-dim/50 text-moon font-bold py-2 px-4 rounded-lg mr-3 shadow-sm transition duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-gold hover:bg-white text-void font-bold py-2 px-4 rounded-lg shadow-lg shadow-gold/20 transition duration-200 transform hover:scale-[1.01]">
                    <i class="fas fa-sync-alt mr-2"></i> Update Produk
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>