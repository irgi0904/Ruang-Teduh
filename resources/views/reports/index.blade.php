<x-admin-layout>
    
    <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
        <h2 class="text-3xl font-serif italic text-gold">Laporan & Analisis</h2>
        <p class="text-dim text-sm">Ringkasan penjualan, produk, dan keuangan dari 
            <span class="font-bold">{{ date('d M Y', strtotime($startDate)) }}</span> sampai 
            <span class="font-bold">{{ date('d M Y', strtotime($endDate)) }}</span>
        </p>
    </div>

    <div x-data="{ activeReport: 'penjualan' }" class="space-y-6">
        
        <div class="border-b border-white/10">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="activeReport = 'penjualan'" 
                        :class="{'border-gold text-gold': activeReport === 'penjualan', 'border-transparent text-dim hover:text-moon': activeReport !== 'penjualan'}"
                        class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-lg transition duration-200 focus:outline-none">
                    <i class="fas fa-chart-line mr-2"></i> Penjualan Harian
                </button>
                <button @click="activeReport = 'produk'" 
                        :class="{'border-gold text-gold': activeReport === 'produk', 'border-transparent text-dim hover:text-moon': activeReport !== 'produk'}"
                        class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-lg transition duration-200 focus:outline-none">
                    <i class="fas fa-box-open mr-2"></i> Performa Produk
                </button>
            </nav>
        </div>

        <div class="bg-surface shadow-xl shadow-black/20 rounded-xl p-6 border border-white/5">
            <h3 class="text-xl font-serif text-moon mb-4 border-b border-white/10 pb-3">
                <i class="fas fa-filter mr-2 text-dim"></i> Filter Periode
            </h3>
            
            <form action="{{ route('admin.reports.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-dim mb-1">Dari Tanggal</label>
                        <input type="date" id="start_date" name="start_date" 
                               value="{{ $startDate }}" onchange="this.form.submit()"
                               class="w-full p-2 rounded-lg bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold cursor-pointer">
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-dim mb-1">Sampai Tanggal</label>
                        <input type="date" id="end_date" name="end_date" 
                               value="{{ $endDate }}" onchange="this.form.submit()"
                               class="w-full p-2 rounded-lg bg-void border border-white/10 text-moon focus:ring-gold focus:border-gold cursor-pointer">
                    </div>
                </div>
                </form>
        </div>

        <div x-show="activeReport === 'penjualan'">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="p-6 bg-void/50 rounded-xl shadow-xl shadow-black/20 border border-white/10">
                    <div class="flex items-center">
                        <div class="p-3 mr-4 text-green-400 bg-green-800/20 rounded-full">
                            <i class="fas fa-dollar-sign text-2xl"></i>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-dim">Total Pendapatan (Selesai)</p>
                            <p class="text-3xl font-bold text-moon font-serif italic">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-void/50 rounded-xl shadow-xl shadow-black/20 border border-white/10">
                    <div class="flex items-center">
                        <div class="p-3 mr-4 text-blue-400 bg-blue-800/20 rounded-full">
                            <i class="fas fa-receipt text-2xl"></i>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-dim">Total Transaksi</p>
                            <p class="text-3xl font-bold text-moon">{{ number_format($totalOrders, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-void/50 rounded-xl shadow-xl shadow-black/20 border border-white/10">
                    <div class="flex items-center">
                        <div class="p-3 mr-4 text-gold bg-gold/20 rounded-full">
                            <i class="fas fa-hand-holding-usd text-2xl"></i>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-dim">Rata-Rata Order</p>
                            <p class="text-3xl font-bold text-moon font-serif italic">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <h3 class="font-serif italic text-xl text-moon mt-8 mb-4 border-b border-white/10 pb-2">Rincian Harian</h3>
            
            <div class="bg-surface shadow-xl shadow-black/20 rounded-lg overflow-hidden border border-white/5">
                <table class="min-w-full leading-normal text-moon">
                    <thead class="bg-void/50 border-b border-white/10">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Tanggal</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Jumlah Order</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-dim uppercase tracking-wider">Pendapatan (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($dailyRevenue as $daily)
                        <tr class="hover:bg-void/50 transition">
                            <td class="px-5 py-4 text-sm font-bold text-moon">{{ date('d F Y', strtotime($daily->date)) }}</td>
                            <td class="px-5 py-4 text-sm text-dim">{{ $daily->orders }}</td>
                            <td class="px-5 py-4 text-sm font-bold text-right text-green-400">Rp {{ number_format($daily->revenue, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-5 text-center text-dim italic">Tidak ada data pendapatan dalam periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="grid md:grid-cols-2 gap-6 mt-8">
                <div class="p-6 bg-void/50 rounded-xl shadow-xl shadow-black/20 border border-white/10">
                    <h4 class="font-serif text-moon mb-4 border-b border-white/10 pb-2">Pesanan Berdasarkan Tipe</h4>
                    <ul class="space-y-2 text-sm text-dim">
                        @foreach($ordersByType as $type)
                        <li class="flex justify-between items-center border-b border-white/5 pb-1 last:border-b-0">
                            <span class="capitalize text-moon">{{ $type->order_type }}</span>
                            <span class="font-bold text-gold">{{ $type->count }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="p-6 bg-void/50 rounded-xl shadow-xl shadow-black/20 border border-white/10">
                    <h4 class="font-serif text-moon mb-4 border-b border-white/10 pb-2">Pembayaran Terbanyak</h4>
                    <ul class="space-y-2 text-sm text-dim">
                        @foreach($paymentMethods as $method => $data)
                        <li class="flex justify-between items-center border-b border-white/5 pb-1 last:border-b-0">
                            <span class="capitalize text-moon">{{ $method }}</span>
                            <span class="font-bold text-green-400">Rp {{ number_format($data['total'], 0, ',', '.') }} ({{ $data['count'] }})</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <a href="{{ route('admin.reports.index', ['export_type' => 'penjualan', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="bg-green-600/80 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-200 flex items-center gap-2">
                    <i class="fas fa-file-csv"></i> Download Data Penjualan
                </a>
            </div>
        </div>

        <div x-show="activeReport === 'produk'" style="display: none;">
            <h3 class="font-serif italic text-xl text-moon mb-4 border-b border-white/10 pb-2">Produk Terlaris (Top 10)</h3>
            
            <div class="bg-surface shadow-xl shadow-black/20 rounded-lg overflow-hidden border border-white/5">
                <table class="min-w-full leading-normal text-moon">
                    <thead class="bg-void/50 border-b border-white/10">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">#</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Nama Produk</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Kuantitas Terjual</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-dim uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($topProducts as $index => $product)
                        <tr class="hover:bg-void/50 transition">
                            <td class="px-5 py-4 text-sm font-bold text-gold">{{ $index + 1 }}</td>
                            <td class="px-5 py-4 text-sm font-bold text-moon">{{ $product->product_name }}</td>
                            <td class="px-5 py-4 text-sm text-green-400 font-mono">{{ $product->total_sold }} pcs</td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider bg-gold/20 text-gold rounded-full">
                                    Best Seller
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-5 text-center text-dim italic">Tidak ada data produk yang terjual dalam periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="flex justify-end mt-8">
                <a href="{{ route('admin.reports.index', ['export_type' => 'produk', 'start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="bg-blue-600/80 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-200 flex items-center gap-2">
                    <i class="fas fa-file-csv"></i> Download Data Produk
                </a>
            </div>
        </div>

    </div>
</x-admin-layout>