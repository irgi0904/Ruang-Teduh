<x-guest-layout>
    <x-auth-session-status class="mb-4 text-gold" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block font-sans text-xs font-bold text-dim uppercase tracking-widest mb-2">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                class="block w-full bg-void border border-white/10 rounded-md shadow-sm text-moon focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 py-3 px-4 transition-all duration-300 placeholder-white/20" 
                placeholder="nama@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div>
            <label for="password" class="block font-sans text-xs font-bold text-dim uppercase tracking-widest mb-2">Password</label>
            
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password" 
                    class="block w-full bg-void border border-white/10 rounded-md shadow-sm text-moon focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 py-3 pl-4 pr-12 transition-all duration-300 placeholder-white/20"
                    placeholder="••••••••">
                
                <button type="button" onclick="togglePassword()" 
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white/50 hover:text-white transition-all duration-300 focus:outline-none hover:scale-110">
                    
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>

                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>

                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember" class="rounded bg-void border-white/20 text-gold shadow-sm focus:ring-gold focus:ring-offset-void">
                <span class="ml-2 text-sm text-dim group-hover:text-gold transition">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-dim hover:text-gold hover:underline decoration-gold underline-offset-4 transition" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-void bg-gold hover:bg-white transition-all duration-300 uppercase tracking-widest transform hover:-translate-y-1">
                Masuk Ruang
            </button>
        </div>

        <div class="text-center pt-4 border-t border-white/5">
            <span class="text-xs text-dim">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="text-xs font-bold text-gold hover:text-white ml-1 transition uppercase tracking-wide">
                Daftar Dulu
            </a>
        </div>
    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>