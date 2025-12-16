<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block font-sans text-xs font-bold text-dim uppercase tracking-widest mb-2">Nama Lengkap</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                class="block w-full bg-void border border-white/10 rounded-md shadow-sm text-moon focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 py-3 px-4 transition-all duration-300" 
                placeholder="Nama Kamu">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div>
            <label for="email" class="block font-sans text-xs font-bold text-dim uppercase tracking-widest mb-2">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required 
                class="block w-full bg-void border border-white/10 rounded-md shadow-sm text-moon focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 py-3 px-4 transition-all duration-300"
                placeholder="nama@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div>
            <label for="password" class="block font-sans text-xs font-bold text-dim uppercase tracking-widest mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="block w-full bg-void border border-white/10 rounded-md shadow-sm text-moon focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 py-3 px-4 transition-all duration-300"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div>
            <label for="password_confirmation" class="block font-sans text-xs font-bold text-dim uppercase tracking-widest mb-2">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required 
                class="block w-full bg-void border border-white/10 rounded-md shadow-sm text-moon focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 py-3 px-4 transition-all duration-300"
                placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-void bg-gold hover:bg-white transition-all duration-300 uppercase tracking-widest transform hover:-translate-y-1">
                Bergabung
            </button>
        </div>

        <div class="text-center pt-4 border-t border-white/5">
            <span class="text-xs text-dim">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="text-xs font-bold text-gold hover:text-white ml-1 transition uppercase tracking-wide">
                Masuk Saja
            </a>
        </div>
    </form>
</x-guest-layout>