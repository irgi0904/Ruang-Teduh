<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Manajemen Produk</h2>
        <a href="{{ route('admin.products.create') }}" 
           class="bg-gold hover:bg-white text-void font-bold py-2 px-4 rounded shadow-lg transition transform hover:scale-[1.01]">
            <i class="fas fa-plus mr-2"></i> Tambah Produk
        </a>
    </div>

    <div class="bg-surface shadow-xl shadow-black/20 rounded-lg overflow-hidden border border-white/5">
        
        <table class="min-w-full leading-normal text-moon">
            <thead class="bg-void/50 border-b border-white/10">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-bold text-dim uppercase tracking-wider">Nama Produk</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-dim uppercase tracking-wider">Kategori</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-dim uppercase tracking-wider">Harga</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-dim uppercase tracking-wider">Stok</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-dim uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($products as $product)
                <tr class="hover:bg-void/50 transition">
                    <td class="px-5 py-4 text-sm font-bold text-moon">
                        {{ $product->name }}
                        @if ($product->is_active ?? true)
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-semibold bg-green-600/10 text-green-400 border border-green-600/30">Aktif</span>
                        @else
                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-semibold bg-red-600/10 text-red-400 border border-red-600/30">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-sm text-dim">
                        {{ $product->category->name ?? 'Tanpa Kategori' }}
                    </td>
                    <td class="px-5 py-4 text-sm text-moon font-mono">Rp {{ number_format($product->price) }}</td>
                    <td class="px-5 py-4 text-sm font-bold {{ ($product->stock ?? 0) < 5 ? 'text-red-400' : 'text-moon' }}">
                        {{ $product->stock ?? 0 }}
                    </td>
                    <td class="px-5 py-4 text-sm flex space-x-3">
                        <a href="{{ route('admin.products.edit', $product->id) }}" 
                           class="text-gold hover:text-white transition" title="Edit Produk">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk {{ $product->name }}? Data tidak bisa dikembalikan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 transition" title="Hapus Produk">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-dim italic">
                        Belum ada produk. Silakan tambah produk baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if ($products instanceof \Illuminate\Contracts\Pagination\Paginator)
        <div class="p-4 bg-surface border-t border-white/10 text-dim">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>