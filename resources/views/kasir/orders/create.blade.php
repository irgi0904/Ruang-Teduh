<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Transaksi Baru | Ruang Teduh POS</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'void': '#0F0F0F',    
                        'surface': '#1A1A1A',  
                        'moon': '#E0E0E0',     
                        'gold': '#C69C6D',    
                        'dim': '#888888',      
                        'accent': '#3C824E',   
                    },
                    fontFamily: { 
                        'serif': ['Lora', 'serif'], 
                        'sans': ['DM Sans', 'sans-serif'] 
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-void font-sans h-screen flex flex-col text-moon">

    <header class="bg-surface shadow-lg shadow-black/10 px-4 py-3 flex justify-between items-center z-10 border-b border-white/5">
        <div class="flex items-center gap-4">
            <a href="{{ route('kasir.orders.index') }}" class="text-dim hover:text-gold transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-xl font-serif italic text-gold">POS System</h1>
        </div>
        <div class="font-bold text-dim">{{ date('d M Y') }}</div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        
        <div class="w-2/3 p-6 overflow-y-auto">
            <div class="mb-6 relative">
                <input type="text" placeholder="Cari nama produk..." 
                       class="w-full p-3 pl-10 rounded-lg shadow-inner bg-void border border-white/10 text-moon focus:ring-2 focus:ring-gold focus:border-gold placeholder-dim transition">
                <i class="fas fa-search absolute left-3 top-4 text-dim"></i>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div class="bg-surface rounded-lg shadow-xl shadow-black/20 p-4 cursor-pointer hover:shadow-gold/30 transition border border-white/10 hover:border-gold/50">
                    <div class="h-24 bg-void/50 rounded-lg mb-3 flex items-center justify-center text-dim">
                        <i class="fas fa-mug-hot fa-2x"></i> 
                    </div>
                    <h3 class="font-serif italic text-moon text-md">Kopi Susu Gula Aren</h3>
                    <div class="flex justify-between items-end mt-3">
                        <span class="text-gold font-bold text-lg">Rp 18.000</span>
                        <button class="bg-gold text-void w-8 h-8 rounded-full flex items-center justify-center text-md font-bold hover:bg-white transition">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="bg-surface rounded-lg shadow-xl shadow-black/20 p-4 cursor-pointer hover:shadow-gold/30 transition border border-white/10 hover:border-gold/50">
                    <div class="h-24 bg-void/50 rounded-lg mb-3 flex items-center justify-center text-dim">
                        <i class="fas fa-bread-slice fa-2x"></i>
                    </div>
                    <h3 class="font-serif italic text-moon text-md">Roti Bakar Coklat</h3>
                    <div class="flex justify-between items-end mt-3">
                        <span class="text-gold font-bold text-lg">Rp 12.000</span>
                        <button class="bg-gold text-void w-8 h-8 rounded-full flex items-center justify-center text-md font-bold hover:bg-white transition">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                </div>
        </div>

        <div class="w-1/3 bg-surface shadow-xl shadow-black/30 flex flex-col h-full border-l border-white/5">
            <div class="p-4 border-b border-white/10 bg-void/50">
                <h2 class="font-bold text-moon text-xl"><i class="fas fa-shopping-cart mr-2 text-gold"></i> Keranjang</h2>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                <div class="flex justify-between items-center p-2 rounded hover:bg-void/50 transition">
                    <div class="flex flex-col">
                        <span class="font-serif italic text-moon text-sm">Kopi Susu Gula Aren</span>
                        <span class="text-xs text-dim font-mono">Rp 18.000 x 2</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-moon font-mono">Rp 36.000</span>
                        <button class="text-red-400 hover:text-red-300"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
                
                <div class="flex justify-between items-center p-2 rounded hover:bg-void/50 transition">
                    <div class="flex flex-col">
                        <span class="font-serif italic text-moon text-sm">Roti Bakar</span>
                        <span class="text-xs text-dim font-mono">Rp 12.000 x 1</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-moon font-mono">Rp 12.000</span>
                        <button class="text-red-400 hover:text-red-300"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
                
            </div>

            <div class="p-6 border-t border-white/10 bg-void/50">
                
                <div class="flex justify-between mb-2 text-sm text-dim">
                    <span>Subtotal</span>
                    <span class="font-mono">Rp 48.000</span>
                </div>
                
                <div class="flex justify-between mb-4 text-2xl font-serif italic text-gold border-t border-white/5 pt-2">
                    <span>Total</span>
                    <span>Rp 48.000</span>
                </div>
                
                <button class="w-full bg-gold hover:bg-white text-void font-bold py-4 rounded-lg shadow-lg shadow-gold/20 transition transform hover:scale-[1.01] uppercase tracking-wider">
                    <i class="fas fa-money-bill-wave mr-2"></i> BAYAR SEKARANG
                </button>
            </div>
        </div>

    </div>
</body>
</html>