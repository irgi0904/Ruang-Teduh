<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Manajemen Pengguna</h2>
        <a href="{{ route('admin.users.create') }}" 
           class="bg-gold hover:bg-white text-void font-bold py-2 px-4 rounded shadow-lg transition transform hover:scale-[1.01]">
            <i class="fas fa-user-plus mr-2"></i> Tambah User
        </a>
    </div>

    <div class="bg-surface shadow-xl shadow-black/20 rounded-lg overflow-hidden border border-white/5">
        
        <table class="min-w-full leading-normal text-moon">
            <thead class="bg-void/50 border-b border-white/10">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Nama</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Email</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Role</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Terdaftar</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($users as $user)
                <tr class="hover:bg-void/50 transition">
                    <td class="px-5 py-4 text-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10">
                                <img class="w-10 h-10 rounded-full object-cover border border-dim/50" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=C69C6D&color=0F0F0F" 
                                     alt="{{ $user->name }}">
                            </div>
                            <div class="ml-3">
                                <p class="text-moon whitespace-no-wrap font-bold">{{ $user->name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-dim">
                        {{ $user->email }}
                    </td>
                    <td class="px-5 py-4 text-sm">
                        @php
                            $roleName = $user->role->name ?? $user->role ?? 'pengguna'; 
                            $roleBadge = match(strtolower($roleName)) {
                                'admin' => 'bg-gold/10 text-gold border border-gold/30',
                                'kasir' => 'bg-green-600/10 text-green-400 border border-green-600/30',
                                default => 'bg-dim/10 text-dim border border-dim/30',
                            };
                        @endphp
                        <span class="text-xs font-bold px-2 py-1 rounded-full capitalize {{ $roleBadge }}">
                            {{ $roleName }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-sm text-dim font-mono">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-5 py-4 text-sm flex space-x-3 mt-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-gold hover:text-white transition duration-150" title="Edit User">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        
                        @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user {{ $user->name }}? Aksi ini tidak dapat dibatalkan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition duration-150" title="Hapus User">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-dim italic">
                        Data pengguna kosong. Silakan tambah pengguna baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if ($users instanceof \Illuminate\Contracts\Pagination\Paginator)
        <div class="px-5 py-5 bg-surface border-t border-white/10 text-dim">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>