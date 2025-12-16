<x-user-layout>
    <div class="relative bg-gray-900 rounded-3xl overflow-hidden shadow-2xl mb-10 mx-4 md:mx-0">
        <div class="absolute inset-0 bg-cover bg-center opacity-60" style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>

        <div class="relative p-10 md:p-16 text-center md:text-left">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 tracking-tight">
                Lapar? <span class="text-green-400">Makan Enak</span> <br> Gak Pakai Ribet.
            </h1>
            <p class="text-gray-200 text-lg mb-8 max-w-lg">
                Nikmati hidangan koki bintang lima dengan harga kaki lima. Pesan sekarang, kami antar ke mejamu.
            </p>
            <a href="{{ route('pengguna.menu.index') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-full shadow-lg transform transition hover:scale-105">
                Pesan Sekarang <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

    <div class="mb-12 px-4 md:px-0">
        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span> Kategori Favorit
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('pengguna.menu.index', ['category' => 'makanan']) }}" class="group bg-white p-6 rounded-2xl shadow hover:shadow-xl transition border border-transparent hover:border-green-500 flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center text-2xl mb-3 group-hover:bg-orange-500 group-hover:text-white transition">
                    🍔
                </div>
                <span class="font-bold text-gray-700 group-hover:text-green-600">Makanan Berat</span>
            </a>
            <a href="{{ route('pengguna.menu.index', ['category' => 'minuman']) }}" class="group bg-white p-6 rounded-2xl shadow hover:shadow-xl transition border border-transparent hover:border-green-500 flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-blue-100 text-blue-500 rounded-full flex items-center justify-center text-2xl mb-3 group-hover:bg-blue-500 group-hover:text-white transition">
                    🥤
                </div>
                <span class="font-bold text-gray-700 group-hover:text-green-600">Minuman Segar</span>
            </a>
            </div>
    </div>

    <div class="px-4 md:px-0 mb-10">
        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
            <span class="w-2 h-8 bg-orange-500 rounded-full mr-3"></span> Paling Laris
        </h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($featuredProducts ?? [] as $product)
                @empty
                <div class="col-span-4 text-center text-gray-400 py-10">
                    Belum ada rekomendasi hari ini.
                </div>
            @endforelse
        </div>
    </div>
</x-user-layout>