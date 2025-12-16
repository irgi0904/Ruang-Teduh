<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Edit Kategori</h2>
        <a href="{{ route('admin.categories.index') }}" class="text-dim hover:text-moon transition">
            &larr; Kembali ke Daftar Kategori
        </a>
    </div>

    <div class="max-w-3xl mx-auto bg-surface shadow-xl shadow-black/20 rounded-xl p-8 border border-white/5">
        
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-moon mb-2">Nama Kategori</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $category->name) }}" 
                       required 
                       placeholder="Contoh: Minuman Kopi"
                       class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition">
                
                @error('name')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="description" class="block text-sm font-medium text-moon mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" 
                          id="description" 
                          rows="3" 
                          placeholder="Jelaskan jenis produk di kategori ini..."
                          class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition">{{ old('description', $category->description) }}</textarea>
                
                @error('description')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.categories.index') }}" 
                   class="bg-dim/30 hover:bg-dim/50 text-moon font-bold py-3 px-6 rounded-lg shadow-sm transition duration-200">
                    Batal
                </a>
                
                <button type="submit" 
                        class="bg-gold hover:bg-white text-void font-bold py-3 px-6 rounded-lg shadow-lg shadow-gold/20 transition duration-200 transform hover:scale-[1.01]">
                    <i class="fas fa-sync-alt mr-2"></i> Update Kategori
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>