<x-admin-layout>
    
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
            <h2 class="text-3xl font-serif italic text-gold">Pengaturan Toko</h2>
            <p class="text-dim text-sm">Kelola identitas dan informasi kontak toko.</p>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                 class="mb-6 bg-green-900/50 border-l-4 border-green-500 text-green-300 p-4 rounded shadow-sm flex justify-between items-center transition-all duration-500">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-green-300 hover:text-green-500 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') 
            
            <div class="bg-surface p-8 rounded-xl shadow-xl shadow-black/20 border border-white/5">
                
                <div class="mb-5">
                    <label class="block text-moon text-sm font-bold mb-2">Nama Toko</label>
                    <input type="text" name="shop_name" 
                        value="{{ old('shop_name', $setting->shop_name ?? 'Ruang Teduh') }}"
                        class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition">
                    @error('shop_name')
                        <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-moon text-sm font-bold mb-2">Email Resmi</label>
                    <input type="email" name="email" 
                        value="{{ old('email', $setting->email ?? 'admin@toko.com') }}"
                        class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition">
                    @error('email')
                        <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-moon text-sm font-bold mb-2">Nomor Telepon / WA</label>
                    <input type="text" name="phone" 
                        value="{{ old('phone', $setting->phone ?? '08123456789') }}"
                        class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition">
                    @error('phone')
                        <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-moon text-sm font-bold mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="3" 
                        class="w-full p-3 rounded-lg shadow-inner bg-void border border-white/10 text-moon placeholder-dim focus:ring-gold focus:border-gold transition">{{ old('address', $setting->address ?? 'Jl. Contoh No. 1, Jakarta') }}</textarea>
                    @error('address')
                        <p class="text-red-400 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="mb-6 border-white/10">

                <div class="flex justify-end">
                    <button type="submit" class="bg-gold hover:bg-white text-void font-bold py-3 px-6 rounded-lg shadow-lg shadow-gold/20 transition duration-200">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
            </form>
        
        @if(!isset($setting))
        <div class="mt-8 p-4 bg-red-900/50 rounded border border-red-500 text-red-300 text-sm">
            <i class="fas fa-exclamation-triangle mr-2"></i> Peringatan: Variabel `$setting` tidak didefinisikan di Controller. Data mungkin tidak muncul.
        </div>
        @endif
    </div>
</x-admin-layout>