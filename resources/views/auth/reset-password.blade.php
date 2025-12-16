<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-8 bg-gradient-to-br from-[#FAF7F2] to-[#E6D3B1]">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-[#C2A25D] rounded-full mb-4">
                    <span class="text-4xl text-white">🔐</span>
                </div>
                <h1 class="text-4xl font-bold text-[#3B2F2F] mb-2">Reset Password</h1>
                <p class="text-gray-600">Buat password baru untuk akun Anda</p>
            </div>

        
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-[#E6D3B1]">
                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-[#3B2F2F] font-semibold" />
                        <x-text-input id="email" 
                                      class="block mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-[#C2A25D] focus:ring focus:ring-[#C2A25D]/20 transition bg-gray-50" 
                                      type="email" 
                                      name="email" 
                                      :value="old('email', $request->email)" 
                                      required 
                                      autofocus 
                                      autocomplete="username"
                                      readonly />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password Baru')" class="text-[#3B2F2F] font-semibold" />
                        <x-text-input id="password" 
                                      class="block mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-[#C2A25D] focus:ring focus:ring-[#C2A25D]/20 transition" 
                                      type="password" 
                                      name="password" 
                                      required 
                                      autocomplete="new-password"
                                      placeholder="Min. 8 karakter" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500">Gunakan minimal 8 karakter dengan kombinasi huruf dan angka</p>
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-[#3B2F2F] font-semibold" />
                        <x-text-input id="password_confirmation" 
                                      class="block mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-[#C2A25D] focus:ring focus:ring-[#C2A25D]/20 transition"
                                      type="password"
                                      name="password_confirmation" 
                                      required 
                                      autocomplete="new-password"
                                      placeholder="Ketik ulang password baru" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div>
                        <x-primary-button class="w-full justify-center py-3 bg-[#C2A25D] hover:bg-[#a88a4d] focus:bg-[#a88a4d] text-white font-semibold rounded-lg transition transform hover:scale-105 shadow-lg">
                            {{ __('Reset Password') }}
                        </x-primary-button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm text-[#C2A25D] hover:text-[#a88a4d] font-semibold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Login
                    </a>
                </div>
            </div>

            <div class="mt-6 p-4 bg-[#E6D3B1]/30 rounded-lg border border-[#C2A25D]/30">
                <div class="flex items-start gap-3">
                    <span class="text-2xl">🛡️</span>
                    <div class="text-sm text-[#3B2F2F]">
                        <p class="font-semibold mb-1">Password yang Baik:</p>
                        <ul class="space-y-1 text-xs text-gray-600">
                            <li>• Minimal 8 karakter</li>
                            <li>• Kombinasi huruf besar & kecil</li>
                            <li>• Gunakan angka dan simbol</li>
                            <li>• Hindari informasi pribadi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>