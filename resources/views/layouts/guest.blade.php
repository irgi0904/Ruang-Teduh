<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Ruang Teduh</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'void': '#0F0F0F', 'surface': '#1A1A1A', 'moon': '#E0E0E0', 'gold': '#C69C6D', 'dim': '#888888',
                    },
                    fontFamily: { 'serif': ['Lora', 'serif'], 'sans': ['DM Sans', 'sans-serif'] }
                }
            }
        }
    </script>

    <style>
        body { background-color: #0F0F0F; color: #E0E0E0; }
        .noise {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; z-index: 0; opacity: 0.07;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="noise"></div>
    
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
        <div class="mb-6 text-center">
            <h1 class="font-serif text-3xl italic text-gold">Ruang Teduh.</h1>
            <p class="text-xs text-dim tracking-widest uppercase mt-2">Masuk ke dalam sunyi</p>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-surface border border-white/5 shadow-2xl overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
        
        <div class="mt-8 text-dim text-xs">
            &copy; 2025 Ruang Teduh.
        </div>
    </div>
</body>
</html>