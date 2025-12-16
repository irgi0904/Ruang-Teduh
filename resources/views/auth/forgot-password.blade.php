<x-guest-layout>
    <div class="mb-6 text-sm text-dim leading-relaxed">
        {{ __('Lupa password? Nggak masalah. Cukup masukkan email kamu, nanti kami kirimkan link untuk meresetnya. Santai saja.') }}
    </div>

    <x-auth-session-status class="mb-4 text-gold" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email" class="block font-sans text-xs font-bold text-dim uppercase tracking-widest mb-2">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                class="block w-full bg-void border border-white/10 rounded-md shadow-sm text-moon focus:border-gold focus:ring focus:ring-gold/20 focus:ring-opacity-50 py-3 px-4 transition-all duration-300"
                placeholder="nama@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-void bg-gold hover:bg-white transition-all duration-300 uppercase tracking-widest transform hover:-translate-y-1">
                Kirim Link Reset
            </button>
        </div>
        
        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-xs text-dim hover:text-gold transition">
                ← Kembali ke Login
            </a>
        </div>
    </form>
</x-guest-layout>