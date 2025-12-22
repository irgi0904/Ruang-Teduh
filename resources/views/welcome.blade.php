<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Teduh | Sanctuary</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;400;500&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

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
                        'serif': ['"Lora"', 'serif'],
                        'sans': ['"DM Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { background-color: #0F0F0F; color: #E0E0E0; scroll-behavior: smooth; overflow-x: hidden; }
        .noise {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 0; opacity: 0.07;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }
        
        #preloader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: #0F0F0F;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .loader-logo {
            font-family: 'Lora', serif;
            font-size: 1.5rem;
            font-style: italic;
            color: #C69C6D;
            margin-bottom: 20px;
            opacity: 0;
            letter-spacing: 0.1em;
        }
        .loader-bar-container {
            width: 150px;
            height: 1px;
            background: rgba(198, 156, 109, 0.1);
            position: relative;
            overflow: hidden;
        }
        .loader-bar {
            width: 0%;
            height: 100%;
            background: #C69C6D;
            position: absolute;
        }

        .glow-spot {
            position: absolute; width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(198, 156, 109, 0.15) 0%, rgba(0,0,0,0) 70%);
            pointer-events: none; z-index: 0; filter: blur(40px);
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #0F0F0F; }
        ::-webkit-scrollbar-thumb { background: #C69C6D; }

        .mobile-menu-open { transform: translateX(0) !important; opacity: 1 !important; }
    </style>
</head>
<body class="antialiased selection:bg-gold selection:text-void">

    <div id="preloader">
        <div class="loader-logo" id="loader-text">Ruang Teduh.</div>
        <div class="loader-bar-container">
            <div class="loader-bar" id="loader-progress"></div>
        </div>
    </div>

    <div class="noise"></div>

    <nav class="fixed top-0 w-full z-50 px-6 py-6 flex justify-between items-center backdrop-blur-md bg-void/70 border-b border-white/5">
        <a href="/" class="font-serif font-bold text-xl italic text-moon hover:text-gold transition-colors tracking-wide z-50 relative">
            Ruang Teduh.
        </a>

        <div class="hidden md:flex items-center gap-8 font-sans text-xs font-medium lowercase tracking-widest text-dim">
            @auth
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-gold transition font-bold text-gold uppercase">Admin Area</a>
                @elseif(auth()->user()->role == 'kasir')
                    <a href="{{ route('kasir.dashboard') }}" class="hover:text-gold transition font-bold text-gold uppercase">POS System</a>
                @else
                    <a href="{{ route('pengguna.menu.index') }}" class="hover:text-gold transition">Menu</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                    @csrf
                    <button type="submit" class="hover:text-white transition opacity-50 uppercase text-[10px] tracking-tighter">(logout)</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-gold transition">Login</a>
                <span class="opacity-30">/</span>
                <a href="{{ route('register') }}" class="hover:text-gold transition">Register</a>
            @endauth
        </div>

        <button id="mobile-menu-btn" class="md:hidden text-gold text-2xl z-50 focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>

        <div id="mobile-menu" class="fixed inset-0 bg-void z-40 flex flex-col items-center justify-center gap-8 translate-x-full opacity-0 transition-all duration-500 ease-in-out md:hidden">
            @auth
                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="font-serif text-2xl text-gold italic">Admin Area</a>
                @elseif(auth()->user()->role == 'kasir')
                    <a href="{{ route('kasir.dashboard') }}" class="font-serif text-2xl text-gold italic">POS System</a>
                @else
                    <a href="{{ route('pengguna.menu.index') }}" class="font-serif text-2xl text-moon hover:text-gold italic">Menu</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-sans text-sm text-dim uppercase tracking-widest hover:text-white">(Logout)</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="font-serif text-3xl text-moon hover:text-gold italic">Login</a>
                <a href="{{ route('register') }}" class="font-serif text-3xl text-moon hover:text-gold italic">Register</a>
            @endauth
        </div>
    </nav>

    <header class="relative min-h-screen flex flex-col md:flex-row items-center justify-center px-6 md:px-20 pt-24 md:pt-20">
        <div class="glow-spot top-20 left-20"></div>
        
        <div class="w-full md:w-1/2 z-10 mb-12 md:mb-0 relative text-center md:text-left">
            <span class="font-sans text-[10px] tracking-[0.3em] uppercase text-gold mb-6 inline-block md:block border-l-0 md:border-l border-gold pl-0 md:pl-3">
                Late Night Sanctuary
            </span>
            <h1 class="font-serif text-4xl sm:text-5xl md:text-7xl leading-tight md:leading-none mb-6 md:mb-8 text-moon anim-text opacity-0 translate-y-10">
                Gelap itu <br><span class="italic text-dim">menenangkan.</span>
            </h1>
            <p class="font-sans text-sm md:text-base text-dim leading-relaxed max-w-md mx-auto md:mx-0 mb-8 md:mb-10 anim-text opacity-0 translate-y-10 font-light">
                Buat kamu yang otaknya baru jalan jam 12 malam, atau yang cuma butuh tempat sembunyi dari silau-nya ekspektasi orang lain.
            </p>
            <div class="flex justify-center md:justify-start gap-4 anim-text opacity-0 translate-y-10">
                <a href="#menu-gelap" class="px-8 py-3 bg-moon text-void font-sans text-sm font-bold tracking-wide hover:bg-gold transition duration-500 rounded-sm">
                    Lihat Menu
                </a>
            </div>
        </div>

        <div class="w-full md:w-1/2 relative z-10 flex justify-center md:justify-end anim-img opacity-0">
            <div class="relative w-[80vw] h-[400px] md:w-[400px] md:h-[500px] max-w-[400px]">
                <div class="absolute -inset-4 bg-gold/10 blur-2xl rounded-full"></div>
                <img src="https://i.pinimg.com/736x/de/46/98/de4698ce7a62ed7b94c9b4a5212f3940.jpg" 
                     class="w-full h-full object-cover grayscale opacity-80 hover:opacity-100 hover:grayscale-0 transition duration-1000 border border-white/10 shadow-2xl shadow-black"
                     alt="Moody Coffee">
                <div class="absolute -bottom-10 -right-4 text-right">
                    <p class="font-serif italic text-2xl text-gold opacity-50"></p>
                </div>
            </div>
        </div>
    </header>

    <section id="menu-gelap" class="py-20 md:py-32 px-6 md:px-20 bg-void relative">
        <div class="absolute top-0 right-0 w-full h-px bg-gradient-to-l from-transparent via-white/10 to-transparent"></div>
        <div class="mb-12 md:mb-16 text-center md:text-left">
            <h2 class="font-serif text-3xl md:text-4xl text-moon mb-2">Menu Pilihan</h2>
            <p class="font-sans text-xs text-dim uppercase tracking-widest">Diseduh tanpa banyak bicara</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <div class="bg-surface p-1 group hover:bg-white/5 transition duration-500 cursor-pointer text-left">
                <div class="relative h-64 overflow-hidden mb-4 opacity-80 group-hover:opacity-100 transition">
                    <img src="https://i.pinimg.com/736x/34/d1/74/34d1748eeaa450044413271dc395b3cc.jpg" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-700">
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-baseline mb-2">
                        <h3 class="font-serif text-lg text-moon italic">Black Coffee</h3>
                        <span class="font-sans text-gold text-sm">22k</span>
                    </div>
                    <p class="font-sans text-xs text-dim leading-relaxed">Hitam pekat, sepahit kenyataan kalau chat dia cuma di-read doang.</p>
                </div>
            </div>
            <div class="bg-surface p-1 group hover:bg-white/5 transition duration-500 cursor-pointer text-left">
                <div class="relative h-64 overflow-hidden mb-4 opacity-80 group-hover:opacity-100 transition">
                    <img src="https://i.pinimg.com/736x/2f/2b/94/2f2b94944675fbeac30c3800b42108dd.jpg" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-700">
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-baseline mb-2">
                        <h3 class="font-serif text-lg text-moon italic">Creamy Latte</h3>
                        <span class="font-sans text-gold text-sm">28k</span>
                    </div>
                    <p class="font-sans text-xs text-dim leading-relaxed">Lembut banget. Cocok buat yang hatinya lagi rapuh dan butuh validasi.</p>
                </div>
            </div>
            <div class="bg-surface p-1 group hover:bg-white/5 transition duration-500 cursor-pointer text-left">
                <div class="relative h-64 overflow-hidden mb-4 opacity-80 group-hover:opacity-100 transition">
                    <img src="https://i.pinimg.com/1200x/98/6e/80/986e8020d901fe1c313e9460495ec5c3.jpg" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-700">
                </div>
                <div class="p-4">
                    <div class="flex justify-between items-baseline mb-2">
                        <h3 class="font-serif text-lg text-moon italic">Pancake</h3>
                        <span class="font-sans text-gold text-sm">79k</span>
                    </div>
                    <p class="font-sans text-xs text-dim leading-relaxed">Tumpukan manis yang tebal dan empuk, disiram sirup klasik.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 md:py-24 px-6 md:px-20 bg-void border-t border-white/5">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-16 text-center md:text-left">
            <div class="space-y-4">
                <h3 class="font-serif text-gold text-xl italic">Jam Operasional.</h3>
                <div class="space-y-2 font-sans text-xs tracking-widest text-dim uppercase">
                    <div class="flex justify-between md:justify-between border-b border-white/5 pb-2 max-w-xs mx-auto md:mx-0">
                        <span>Senin - Kamis</span>
                        <span class="text-moon">16:00 - 00:00</span>
                    </div>
                    <div class="flex justify-between md:justify-between border-b border-white/5 pb-2 max-w-xs mx-auto md:mx-0">
                        <span>Jumat - Minggu</span>
                        <span class="text-moon">16:00 - 02:00</span>
                    </div>
                    <div class="flex items-center justify-center md:justify-start gap-2 pt-2 text-green-500 font-bold text-[10px]">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        SEDANG MENYEDUH (BUKA)
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <h3 class="font-serif text-gold text-xl italic">Titik Temu.</h3>
                <p class="font-sans text-sm text-dim leading-relaxed">
                    Jl. Gatot Subroto. 24, Medan Baru.<br>
                    Sumatera Utara, 20111.
                </p>
                <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Gatot+Subroto.+24,+Medan+Baru,+Sumatera+Utara+20111" 
                   target="_blank" 
                   class="inline-block font-sans text-[10px] text-gold border-b border-gold pb-1 uppercase tracking-[0.2em] hover:text-white hover:border-white transition">
                    Buka di Google Maps
                </a>
            </div>
            <div class="space-y-4">
                <h3 class="font-serif text-gold text-xl italic">Suasana.</h3>
                <div class="flex flex-wrap justify-center md:justify-start gap-2 text-left">
                    <span class="px-3 py-1 bg-surface border border-white/5 rounded-full text-[9px] uppercase tracking-widest text-dim">No Wi-Fi</span>
                    <span class="px-3 py-1 bg-surface border border-white/5 rounded-full text-[9px] uppercase tracking-widest text-dim">Smoking Area</span>
                    <span class="px-3 py-1 bg-surface border border-white/5 rounded-full text-[9px] uppercase tracking-widest text-dim">Live Music</span>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-12 md:py-20 px-6 border-t border-white/5 bg-void">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8 md:gap-0">
            <div class="flex flex-col text-center md:text-left">
                <h4 class="font-serif font-bold text-2xl text-moon italic tracking-wide">Ruang Teduh.</h4>
                <p class="font-sans text-[10px] text-dim tracking-[0.3em] uppercase opacity-60">Medan, Sumatera Utara.</p>
            </div>
            <div class="flex items-center gap-8">
                <a href="https://wa.me/+62 878-2463-0419" target="_blank" class="text-dim hover:text-green-400 transition transform hover:scale-125"><i class="fab fa-whatsapp text-xl"></i></a>
                <a href="https://www.instagram.com/firdaus_azka02" target="_blank" class="text-dim hover:text-pink-400 transition transform hover:scale-125"><i class="fab fa-instagram text-xl"></i></a>
                <a href="mailto:Firdausazka804@gmail.com" class="text-dim hover:text-gold transition transform hover:scale-125"><i class="far fa-envelope text-xl"></i></a>
            </div>
        </div>
        <div class="text-center mt-12 md:mt-20 pt-10 border-t border-white/5 font-sans text-[10px] text-dim/30 uppercase tracking-[0.4em]">
            © 2025 • Azka Firdaus.
        </div>
    </footer>

    <script>
        gsap.registerPlugin(ScrollTrigger);

        window.addEventListener('load', () => {
            const tl = gsap.timeline();

            tl.to("#loader-text", { opacity: 1, duration: 1, ease: "power2.out" })
              .to("#loader-progress", { width: "100%", duration: 1.2, ease: "power3.inOut" }, "-=0.5")
              .to("#preloader", { 
                  y: "-100%", 
                  duration: 1, 
                  ease: "expo.inOut",
                  onComplete: () => {
                      document.body.style.overflowY = "auto";
                     
                  }
              })
              .to(".anim-text", { y: 0, opacity: 1, duration: 1.2, stagger: 0.2, ease: "power4.out" }, "-=0.5")
              .to(".anim-img", { opacity: 1, duration: 1.5, ease: "power2.out" }, "-=1");
        });

        const cards = document.querySelectorAll('.group');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => gsap.to(card, { y: -5, duration: 0.3 }));
            card.addEventListener('mouseleave', () => gsap.to(card, { y: 0, duration: 0.3 }));
        });

        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        let isMenuOpen = false;

        mobileBtn.addEventListener('click', () => {
            isMenuOpen = !isMenuOpen;
            if(isMenuOpen) {
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('mobile-menu-open');
                mobileBtn.innerHTML = '<i class="fas fa-times"></i>'; 
            } else {
                mobileMenu.classList.remove('mobile-menu-open');
                mobileBtn.innerHTML = '<i class="fas fa-bars"></i>'; 
            }
        });
    </script>
</body>
</html>