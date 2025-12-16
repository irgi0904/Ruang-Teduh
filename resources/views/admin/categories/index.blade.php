<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Manajemen Kategori</h2>
        <a href="{{ route('admin.categories.create') }}" 
           class="bg-gold hover:bg-white text-void font-bold py-2 px-4 rounded shadow-lg transition transform hover:scale-[1.01]">
            <i class="fas fa-plus mr-2"></i> Tambah Kategori
        </a>
    </div>

    <div class="bg-surface shadow-xl shadow-black/20 rounded-lg overflow-hidden border border-white/5">
        
        <table class="min-w-full leading-normal text-moon">
            <thead class="bg-void/50 border-b border-white/10">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Nama Kategori</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Deskripsi</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Jumlah Produk</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($categories as $category)
                <tr class="hover:bg-void/50 transition">
                    <td class="px-5 py-4 text-sm font-bold text-moon">
                        {{ $category->name }}
                    </td>
                    <td class="px-5 py-4 text-sm text-dim">
                        {{ $category->description ?? '-' }}
                    </td>
                    <td class="px-5 py-4 text-sm">
                        <span class="bg-green-600/10 text-green-400 text-xs font-semibold px-2 py-1 rounded-full border border-green-600/30">
                            {{ $category->products_count ?? 0 }} Item
                        </span>
                    </td>
                    <td class="px-5 py-4 text-sm flex space-x-3">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-blue-400 hover:text-blue-300 transition duration-150" title="Edit Kategori">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Produk di dalamnya mungkin akan kehilangan kategori.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 transition duration-150" title="Hapus Kategori">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-5 py-8 text-center text-dim italic">
                        Belum ada kategori. Silakan tambah baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if ($categories instanceof \Illuminate\Contracts\Pagination\Paginator)
        <div class="px-5 py-5 bg-surface border-t border-white/10 flex flex-col xs:flex-row items-center xs:justify-between text-dim">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>