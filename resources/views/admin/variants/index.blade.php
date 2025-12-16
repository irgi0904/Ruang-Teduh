<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Daftar Varian Produk</h2>
    </div>

    <div class="bg-surface shadow-xl shadow-black/20 rounded-lg overflow-hidden border border-white/5">
        
        <table class="min-w-full leading-normal text-moon">
            <thead class="bg-void/50 border-b border-white/10">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Nama Varian</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Harga Tambahan</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($variants as $variant)
                <tr class="hover:bg-void/50 transition">
                    <td class="px-5 py-4 text-sm font-bold text-moon">
                        {{ $variant->name }}
                    </td>
                    <td class="px-5 py-4 text-sm text-gold font-mono font-semibold">
                        @if(($variant->additional_price ?? 0) > 0)
                            + Rp {{ number_format($variant->additional_price, 0, ',', '.') }}
                        @else
                            Gratis <span class="text-dim/80">(Rp 0)</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm flex space-x-3">
                        <a href="{{ route('admin.variants.edit', $variant->id) }}" class="text-gold hover:text-white transition duration-150" title="Edit Varian">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        
                        <form action="{{ route('admin.variants.destroy', $variant->id) }}" method="POST" onsubmit="return confirm('Hapus varian {{ $variant->name }}? Data tidak bisa dikembalikan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 transition duration-150" title="Hapus Varian">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-5 py-8 text-center text-dim italic">
                        Belum ada data varian (Contoh: Large, Medium, Ice, Hot). Silakan tambah baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if ($variants instanceof \Illuminate\Contracts\Pagination\Paginator)
        <div class="px-5 py-5 bg-surface border-t border-white/10 text-dim">
            {{ $variants->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>