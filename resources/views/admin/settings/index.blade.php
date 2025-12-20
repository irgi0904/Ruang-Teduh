<x-admin-layout>
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center border-b border-white/10 pb-4 gap-4">
        <div>
            <h2 class="text-3xl font-serif italic text-gold">System Settings</h2>
            <p class="text-dim text-sm">Konfigurasi akun pengelola dan identitas operasional.</p>
        </div>
        <div class="w-full md:w-auto">
            <button type="submit" form="settings-form" class="w-full bg-gold text-void text-[10px] font-bold uppercase tracking-[0.2em] px-8 py-3 rounded-xl hover:bg-moon transition duration-500 shadow-lg shadow-gold/10">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </div>

    <form id="settings-form" action="#" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-10">
        @csrf
        @method('PUT')

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-surface rounded-xl shadow-xl shadow-black/40 p-6 border-l-4 border-gold border-y border-r border-white/5">
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-gold/10 rounded-full text-gold border border-gold/30">
                        <i class="fas fa-user-shield text-xl"></i>
                    </div>
                    <h3 class="text-xl font-serif italic text-moon font-bold">Profil Administrator</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label class="text-dim text-[10px] font-bold uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" 
                            class="w-full px-4 py-2.5 bg-void/50 border border-white/10 rounded-xl text-moon text-sm focus:border-gold outline-none transition duration-300">
                    </div>
                    <div class="space-y-1">
                        <label class="text-dim text-[10px] font-bold uppercase tracking-widest ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" 
                            class="w-full px-4 py-2.5 bg-void/50 border border-white/10 rounded-xl text-moon text-sm focus:border-gold outline-none transition duration-300">
                    </div>
                    <div class="md:col-span-2 space-y-1">
                        <label class="text-dim text-[10px] font-bold uppercase tracking-widest ml-1">Update Password (Kosongkan jika tidak diganti)</label>
                        <input type="password" name="password" placeholder="••••••••" 
                            class="w-full px-4 py-2.5 bg-void/50 border border-white/10 rounded-xl text-moon text-sm focus:border-gold outline-none transition duration-300">
                    </div>
                </div>
            </div>

            <div class="bg-surface rounded-xl shadow-xl shadow-black/40 p-6 border-l-4 border-purple-500 border-y border-r border-white/5">
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-purple-600/10 rounded-full text-purple-400 border border-purple-600/30">
                        <i class="fas fa-store text-xl"></i>
                    </div>
                    <h3 class="text-xl font-serif italic text-moon font-bold">Identitas Ruang Teduh</h3>
                </div>

                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-dim text-[10px] font-bold uppercase tracking-widest ml-1">Nama Brand</label>
                        <input type="text" name="shop_name" value="Ruang Teduh." 
                            class="w-full px-4 py-2.5 bg-void/50 border border-white/10 rounded-xl text-sm font-serif italic text-gold focus:border-gold outline-none transition duration-300">
                    </div>
                    <div class="space-y-1">
                        <label class="text-dim text-[10px] font-bold uppercase tracking-widest ml-1">Alamat Lengkap</label>
                        <textarea name="address" rows="3" 
                            class="w-full px-4 py-2.5 bg-void/50 border border-white/10 rounded-xl text-moon text-sm focus:border-gold outline-none transition duration-300 leading-relaxed">Jl. Teratai No. 12, Binjai Kota, Sumatera Utara.</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-surface rounded-xl shadow-xl shadow-black/40 p-6 border-l-4 border-green-500 border-y border-r border-white/5">
                <div class="flex items-center justify-between mb-6">
                    <p class="text-dim text-[10px] font-bold uppercase tracking-widest">Sistem Kontrol</p>
                    <div class="p-2 bg-green-600/10 rounded-full text-green-400 border border-green-600/30">
                        <i class="fas fa-shield-alt text-lg"></i>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-void/30 rounded-xl border border-white/5">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-moon">Backup Cloud</span>
                            <span class="text-[9px] text-dim uppercase tracking-tighter">Automatic daily sync</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-10 h-5 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-dim after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-gold peer-checked:after:bg-void"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-void/30 rounded-xl border border-white/5">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-moon">Maintenance</span>
                            <span class="text-[9px] text-dim uppercase tracking-tighter">Lock cashier panel</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-10 h-5 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-dim after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-500 peer-checked:after:bg-white"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-surface rounded-xl shadow-xl shadow-black/40 p-6 border-l-4 border-blue-500 border-y border-r border-white/5">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-dim text-[10px] font-bold uppercase tracking-widest">Environment</p>
                    <div class="p-2 bg-blue-600/10 rounded-full text-blue-400 border border-blue-600/30">
                        <i class="fas fa-server text-lg"></i>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center border-b border-white/5 pb-2">
                        <span class="text-[10px] text-dim font-medium uppercase tracking-tighter">Versi Aplikasi</span>
                        <span class="text-xs font-mono font-bold text-moon tracking-widest">v1.0.4</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-white/5 pb-2">
                        <span class="text-[10px] text-dim font-medium uppercase tracking-tighter">PHP Version</span>
                        <span class="text-xs font-mono font-bold text-moon tracking-widest">8.2.12</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] text-dim font-medium uppercase tracking-tighter">Database</span>
                        <span class="text-xs font-mono font-bold text-blue-400 uppercase tracking-widest">SQLite</span>
                    </div>
                </div>
            </div>

        </div>
    </form>
</x-admin-layout>