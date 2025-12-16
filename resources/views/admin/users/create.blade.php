<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Tambah Pengguna Baru</h2>
        <a href="{{ route('admin.users.index') }}" class="text-dim hover:text-moon transition">
            &larr; Kembali ke Daftar Pengguna
        </a>
    </div>

    <div class="bg-surface shadow-xl shadow-black/20 rounded-xl p-8 border border-white/5 max-w-2xl mx-auto">
        
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-moon text-sm font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                       class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition" 
                       placeholder="Contoh: Budi Cahaya"
                       required>
                @error('name')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-moon text-sm font-medium mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition" 
                       placeholder="contoh@mail.com"
                       required>
                @error('email')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-moon text-sm font-medium mb-2">Role / Hak Akses</label>
                <select name="role" 
                        class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold transition">
                    <option value="pengguna" {{ old('role') == 'pengguna' ? 'selected' : '' }}>👤 Customer (Pelanggan)</option>
                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>🧑‍💼 Staff / Kasir</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>👑 Administrator</option>
                </select>
                @error('role')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 pt-4 border-t border-white/10">
                <div>
                    <label class="block text-moon text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" 
                           class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold transition" 
                           required>
                    @error('password')
                        <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-moon text-sm font-medium mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" 
                           class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold transition" 
                           required>
                    @error('password_confirmation')
                        <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-white/10">
                <button type="submit" 
                        class="bg-gold hover:bg-white text-void font-bold py-3 px-6 rounded-lg shadow-lg shadow-gold/20 transition duration-200 transform hover:scale-[1.01]">
                    <i class="fas fa-save mr-2"></i> Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>