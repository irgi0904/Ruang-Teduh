<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Edit Topping</h2>
        <a href="{{ route('admin.toppings.index') }}" class="text-dim hover:text-moon transition">
            &larr; Kembali ke Daftar Topping
        </a>
    </div>

    <div class="bg-surface shadow-xl shadow-black/20 rounded-xl p-8 border border-white/5 max-w-2xl mx-auto">
        
        <form action="{{ route('admin.toppings.update', $topping->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-moon text-sm font-medium mb-2">Nama Topping</label>
                <input type="text" name="name" value="{{ old('name', $topping->name) }}" 
                       class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition" 
                       required>
                @error('name')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-moon text-sm font-medium mb-2">Harga Tambahan (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $topping->price) }}" 
                       class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold transition" 
                       required min="0">
                @error('price')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-moon text-sm font-medium mb-2">Status Stok</label>
                <select name="is_available" 
                        class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold transition">
                    <option value="1" {{ old('is_available', $topping->is_available) == 1 ? 'selected' : '' }}>🟢 Tersedia</option>
                    <option value="0" {{ old('is_available', $topping->is_available) == 0 ? 'selected' : '' }}>🔴 Habis / Kosong</option>
                </select>
                @error('is_available')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-white/10">
                <a href="{{ route('admin.toppings.index') }}" 
                   class="bg-dim/30 hover:bg-dim/50 text-moon font-bold py-3 px-6 rounded-lg shadow-sm transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-gold hover:bg-white text-void font-bold py-3 px-6 rounded-lg shadow-lg shadow-gold/20 transition duration-200 transform hover:scale-[1.01]">
                    <i class="fas fa-sync-alt mr-2"></i> Update Topping
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>