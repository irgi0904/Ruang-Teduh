<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Home' }} - Ruang Teduh</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>
<body class="bg-[#FAF7F2] font-sans antialiased">
    <nav class="bg-[#3B2F2F]/95 backdrop-blur-sm shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-[#E6D3B1]">Ruang Teduh</a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-[#E6D3B1] hover:text-[#C2A25D] transition">Home</a>
                    @auth
                        <a href="{{ route('pengguna.menu.index') }}" class="text-[#E6D3B1] hover:text-[#C2A25D] transition">Menu</a>
                        <a href="{{ route('pengguna.cart.index') }}" class="text-[#E6D3B1] hover:text-[#C2A25D] transition relative">
                            🛒 Keranjang
                            @php
                                $cartCount = session()->has('cart') ? count(session('cart')) : 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-[#C2A25D] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('pengguna.orders.index') }}" class="text-[#E6D3B1] hover:text-[#C2A25D] transition">Pesanan</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-[#C2A25D] text-white rounded-lg hover:bg-[#a88a4d] transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-[#E6D3B1] hover:text-[#C2A25D] transition">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-[#C2A25D] text-white rounded-lg hover:bg-[#a88a4d] transition">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        
        {{ $slot }}
    </main>

    <footer class="bg-[#3B2F2F] text-[#E6D3B1] mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-xl font-bold text-[#C2A25D] mb-4">Ruang Teduh</h3>
                    <p class="text-sm text-[#E6D3B1]/80">Tempat di mana cerita bertemu dengan kopi</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <p class="text-sm text-[#E6D3B1]/80">Jl. Cerita No. 123</p>
                    <p class="text-sm text-[#E6D3B1]/80">Jakarta Selatan</p>
                    <p class="text-sm text-[#E6D3B1]/80">021-12345678</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Jam Operasional</h4>
                    <p class="text-sm text-[#E6D3B1]/80">Senin - Jumat: 08:00 - 22:00</p>
                    <p class="text-sm text-[#E6D3B1]/80">Sabtu: 09:00 - 23:00</p>
                    <p class="text-sm text-[#E6D3B1]/80">Minggu: 09:00 - 22:00</p>
                </div>
            </div>
            <div class="border-t border-[#E6D3B1]/20 mt-8 pt-8 text-center text-sm text-[#E6D3B1]/60">
                © {{ date('Y') }} Ruang Teduh. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>