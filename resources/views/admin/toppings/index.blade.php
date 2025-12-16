<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Daftar Topping / Extra</h2>
        <a href="{{ route('admin.toppings.create') }}" 
           class="bg-gold hover:bg-white text-void font-bold py-2 px-4 rounded shadow-lg transition transform hover:scale-[1.01]">
            <i class="fas fa-plus mr-2"></i> Tambah Topping
        </a>
    </div>

    <div class="bg-surface shadow-xl shadow-black/20 rounded-lg overflow-hidden border border-white/5">
        
        <table class="min-w-full leading-normal text-moon">
            <thead class="bg-void/50 border-b border-white/10">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Nama Topping</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Harga Tambahan</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($toppings as $topping)
                <tr class="hover:bg-void/50 transition">
                    <td class="px-5 py-4 text-sm font-bold text-moon">
                        {{ $topping->name }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gold font-mono font-semibold">
                        + Rp {{ number_format($topping->price, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-4 text-sm">
                        @if($topping->is_available ?? true)
                            <span class="bg-green-600/10 text-green-400 text-xs font-bold px-2 py-1 rounded-full border border-green-600/30">Tersedia</span>
                        @else
                            <span class="bg-red-600/10 text-red-400 text-xs font-bold px-2 py-1 rounded-full border border-red-600/30">Habis</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm flex space-x-3">
                        <a href="{{ route('admin.toppings.edit', $topping->id) }}" class="text-gold hover:text-white transition duration-150" title="Edit Topping">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        
                        <form action="{{ route('admin.toppings.destroy', $topping->id) }}" method="POST" onsubmit="return confirm('Hapus topping {{ $topping->name }}? Data tidak bisa dikembalikan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 transition duration-150" title="Hapus Topping">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-8 text-center text-dim italic">
                        Belum ada data topping. Silakan tambah topping baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if ($toppings instanceof \Illuminate\Contracts\Pagination\Paginator)
        <div class="px-5 py-5 bg-surface border-t border-white/10 text-dim">
            {{ $toppings->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>