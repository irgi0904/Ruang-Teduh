<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambahkan Pesanan | Ruang Teduh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'void': '#0F0F0F', 'surface': '#1A1A1A', 'gold': '#C69C6D', 'moon': '#E0E0E0', 'accent': '#3C824E' } } }
        }
    </script>
</head>
<body class="bg-void text-moon h-screen flex flex-col overflow-hidden font-sans">
    @if(session('error'))
        <div class="bg-red-500 text-white text-xs p-2 text-center">{{ session('error') }}</div>
    @endif

    <form action="{{ route('kasir.orders.store') }}" method="POST" class="flex flex-col h-full">
        @csrf
        <header class="p-5 bg-surface border-b border-white/5 flex justify-between items-center shadow-lg">
            <div class="flex items-center gap-6">
                <a href="{{ route('kasir.dashboard') }}" class="text-dim hover:text-gold text-[10px] uppercase font-bold tracking-widest transition">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <h1 class="text-lg font-serif italic text-gold">Tambahkan Pesanan</h1>
            </div>
            <div class="flex gap-4">
                <input type="text" name="customer_name" placeholder="Nama Pelanggan" required 
                    class="bg-void border border-white/10 rounded-lg px-4 py-2 text-sm focus:border-gold outline-none w-48 transition text-moon">
                <input type="text" name="table_number" placeholder="Meja" 
                    class="w-16 bg-void border border-white/10 rounded-lg px-4 py-2 text-sm focus:border-gold outline-none transition text-center text-gold font-bold">
            </div>
        </header>

        <div class="flex flex-1 overflow-hidden">
            <div class="w-2/3 p-6 overflow-y-auto">
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" 
                        class="bg-surface p-4 rounded-xl border border-white/5 hover:border-gold/30 transition shadow-lg group cursor-pointer active:scale-95">
                        <div class="h-24 bg-void/40 rounded-lg mb-4 flex items-center justify-center text-dim group-hover:text-gold transition">
                            <i class="fas fa-mug-hot fa-2x"></i>
                        </div>
                        <h3 class="text-sm truncate font-serif italic">{{ $product->name }}</h3>
                        <p class="text-gold font-bold font-mono text-sm mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="w-1/3 bg-surface border-l border-white/5 flex flex-col shadow-2xl">
                <div class="p-5 border-b border-white/10 bg-void/30 flex justify-between items-center font-serif italic text-gold">
                    <span>Rincian Pesanan</span>
                    <button type="button" onclick="clearCart()" class="text-[9px] uppercase font-bold text-red-400 hover:text-red-300">Hapus Semua</button>
                </div>
                
                <div id="cartItems" class="flex-1 overflow-y-auto p-5 space-y-3">
                    <div id="emptyCart" class="text-center py-20 text-dim italic text-xs opacity-50">
                        <i class="fas fa-shopping-basket block text-2xl mb-2"></i>
                        Pilih menu di samping...
                    </div>
                </div>

                <div class="p-4 border-t border-white/5 bg-void/20">
                    <textarea name="notes" placeholder="Tambahkan catatan (opsional)..." 
                        class="w-full bg-void border border-white/10 rounded-lg p-2 text-xs text-moon outline-none focus:border-gold h-16 resize-none"></textarea>
                </div>

                <div class="p-6 border-t border-white/10 bg-void/50">
                    <div class="flex justify-between mb-4 text-2xl font-serif text-gold italic border-b border-white/5 pb-2">
                        <span>Total</span> 
                        <span id="displayTotal">Rp 0</span>
                        <input type="hidden" name="total" id="inputTotal" value="0">
                    </div>
                    <button type="button" onclick="openPaymentModal()" 
                        class="w-full bg-gold hover:bg-white text-void font-bold py-4 rounded-xl shadow-lg transition uppercase tracking-widest text-xs">
                        Proses Pembayaran
                    </button>
                </div>
            </div>
        </div>

        <div id="paymentModal" class="hidden fixed inset-0 bg-black/90 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-surface w-full max-w-sm rounded-2xl border border-gold/30 p-8 shadow-2xl">
                <h3 class="text-center font-serif text-gold text-xl mb-6 italic">Konfirmasi Pembayaran</h3>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <label class="cursor-pointer group">
                        <input type="radio" name="payment_method" value="cash" checked class="hidden peer">
                        <div class="p-3 text-center rounded-lg border border-white/10 peer-checked:text-gold peer-checked:border-gold peer-checked:bg-gold/5 text-[10px] font-bold uppercase tracking-widest transition">
                            <i class="fas fa-money-bill-wave mb-1 block"></i> Tunai
                        </div>
                    </label>
                    <label class="cursor-pointer group">
                        <input type="radio" name="payment_method" value="debit" class="hidden peer">
                        <div class="p-3 text-center rounded-lg border border-white/10 peer-checked:text-gold peer-checked:border-gold peer-checked:bg-gold/5 text-[10px] font-bold uppercase tracking-widest transition">
                            <i class="fas fa-credit-card mb-1 block"></i> Debit
                        </div>
                    </label>
                </div>

                <div class="mb-6">
                    <p class="text-[10px] text-dim uppercase font-bold tracking-widest mb-2 text-center">Uang yang Diterima</p>
                    <input type="number" name="paid_amount" id="paid_amount" oninput="calculateChange()" 
                        placeholder="0" required
                        class="w-full bg-void border border-white/10 rounded-xl p-4 text-3xl font-mono text-gold outline-none text-center focus:border-gold transition">
                </div>

                <div class="text-center mb-8 bg-void/50 p-4 rounded-xl border border-white/5">
                    <p class="text-[10px] text-dim uppercase font-bold tracking-widest mb-1">Kembalian:</p>
                    <div id="displayChange" class="text-2xl font-bold text-accent font-mono italic">Rp 0</div>
                </div>

                <div class="flex gap-4">
                    <button type="button" onclick="closePaymentModal()" class="flex-1 py-3 text-xs text-dim uppercase font-bold hover:text-white transition">Batal</button>
                    <button type="submit" class="flex-1 bg-gold hover:bg-white text-void py-3 rounded-lg font-bold text-xs uppercase tracking-widest shadow-lg shadow-gold/20 transition">
                        Simpan & Cetak
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        let cart = []; 
        let total = 0;

        function addToCart(id, name, price) {
            const index = cart.findIndex(item => item.id === id);
            if (index > -1) {
                cart[index].qty++;
            } else {
                cart.push({ id, name, price, qty: 1 });
            }
            renderCart();
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        function clearCart() {
            if(confirm('Hapus semua item di keranjang?')) {
                cart = [];
                renderCart();
            }
        }

        function renderCart() {
            const container = document.getElementById('cartItems');
            container.innerHTML = '';
            total = 0;

            if (cart.length === 0) {
                container.innerHTML = `
                    <div id="emptyCart" class="text-center py-20 text-dim italic text-xs opacity-50">
                        <i class="fas fa-shopping-basket block text-2xl mb-2"></i>
                        Pilih menu di samping...
                    </div>`;
            } else {
                cart.forEach((item, index) => {
                    const sub = item.price * item.qty;
                    total += sub;
                    const div = document.createElement('div');
                    div.className = "flex justify-between items-center p-3 rounded-xl bg-void/40 border border-white/5 animate-fadeIn";
                    div.innerHTML = `
                        <div class="flex flex-col">
                            <span class="italic text-moon text-sm font-serif">${item.name}</span>
                            <span class="text-[10px] text-dim font-mono">Rp ${item.price.toLocaleString('id-ID')} x ${item.qty}</span>
                            <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                            <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-gold text-xs">Rp ${sub.toLocaleString('id-ID')}</span>
                            <button type="button" onclick="removeFromCart(${item.id})" class="text-red-400 text-xs hover:text-red-300 transition">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>`;
                    container.appendChild(div);
                });
            }
            document.getElementById('displayTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('inputTotal').value = total;
            calculateChange(); // Update kembalian jika modal sedang terbuka
        }

        function openPaymentModal() {
            if (total <= 0) {
                alert('Silakan pilih menu terlebih dahulu.');
                return;
            }
            document.getElementById('paymentModal').classList.remove('hidden');
            document.getElementById('paid_amount').focus();
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        function calculateChange() {
            const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
            const change = paid - total;
            const display = document.getElementById('displayChange');
            
            if (change < 0) {
                display.innerText = 'Rp 0';
                display.classList.add('text-red-400');
                display.classList.remove('text-accent');
            } else {
                display.innerText = 'Rp ' + change.toLocaleString('id-ID');
                display.classList.remove('text-red-400');
                display.classList.add('text-accent');
            }
        }
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.3s ease-out forwards; }
    </style>
</body>
</html>