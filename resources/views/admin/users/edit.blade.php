<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Edit Pengguna: {{ $user->name }}</h2>
        <a href="{{ route('admin.users.index') }}" class="text-dim hover:text-moon transition">
            &larr; Kembali ke Daftar Pengguna
        </a>
    </div>

    <div class="bg-surface shadow-xl shadow-black/20 rounded-xl p-8 border border-white/5 max-w-2xl mx-auto">
        
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-moon text-sm font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                       class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition" required>
                @error('name')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-moon text-sm font-medium mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                       class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition" required>
                @error('email')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-moon text-sm font-medium mb-2">Role / Hak Akses</label>
                <select name="role" 
                        class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold transition">
                    <option value="pengguna" {{ old('role', $user->role->name ?? $user->role) == 'pengguna' ? 'selected' : '' }}>👤 Customer (Pelanggan)</option>
                    <option value="kasir" {{ old('role', $user->role->name ?? $user->role) == 'kasir' ? 'selected' : '' }}>🧑‍💼 Staff / Kasir</option>
                    <option value="admin" {{ old('role', $user->role->name ?? $user->role) == 'admin' ? 'selected' : '' }}>👑 Administrator</option>
                </select>
                @error('role')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 p-4 bg-void/50 rounded border border-white/10 border-l-4 border-yellow-500">
                <label class="block text-moon text-sm font-bold mb-2">Ganti Password (Opsional)</label>
                <input type="password" name="password" 
                       class="w-full px-3 py-2 border rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition" 
                       placeholder="Biarkan kosong jika tidak ingin mengganti password">
                <p class="text-xs text-dim mt-1">* Isi hanya jika ingin mereset password user ini.</p>
                @error('password')
                    <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-white/10">
                <a href="{{ route('admin.users.index') }}" 
                   class="bg-dim/30 hover:bg-dim/50 text-moon font-bold py-3 px-6 rounded-lg shadow-sm transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-gold hover:bg-white text-void font-bold py-3 px-6 rounded-lg shadow-lg shadow-gold/20 transition duration-200 transform hover:scale-[1.01]">
                    <i class="fas fa-sync-alt mr-2"></i> Update User
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>