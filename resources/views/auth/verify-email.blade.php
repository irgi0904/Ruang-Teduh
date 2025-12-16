<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-8 bg-gradient-to-br from-[#FAF7F2] to-[#E6D3B1]">
        <div class="max-w-md w-full">
            <!-- Decorative Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-[#C2A25D] rounded-full mb-4">
                    <span class="text-4xl text-white">📧</span>
                </div>
                <h1 class="text-4xl font-bold text-[#3B2F2F] mb-2">Verifikasi Email</h1>
                <p class="text-gray-600">Satu langkah lagi untuk memulai</p>
            </div>

            <!-- Card -->
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-[#E6D3B1]">
                <div class="mb-6 text-sm text-gray-600">
                    Terima kasih sudah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan. Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan yang baru.
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
                        Link verifikasi baru telah dikirim ke alamat email yang Anda berikan saat registrasi.
                    </div>
                @endif

                <div class="flex items-center justify-between gap-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <x-primary-button class="py-3 px-6 bg-[#C2A25D] hover:bg-[#a88a4d] focus:bg-[#a88a4d] text-white font-semibold rounded-lg transition transform hover:scale-105 shadow-lg">
                            {{ __('Kirim Ulang Email Verifikasi') }}
                        </x-primary-button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-[#C2A25D] underline transition">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>

                <!-- Email Check Reminder -->
                <div class="mt-6 p-4 bg-[#E6D3B1]/30 rounded-lg border border-[#C2A25D]/30">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">💡</span>
                        <div class="text-sm text-[#3B2F2F]">
                            <p class="font-semibold mb-1">Belum menerima email?</p>
                            <ul class="space-y-1 text-xs text-gray-600">
                                <li>• Periksa folder spam/junk</li>
                                <li>• Pastikan email Anda benar</li>
                                <li>• Tunggu beberapa menit</li>
                                <li>• Klik "Kirim Ulang" jika perlu</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help -->
            <div class="mt-6 text-center text-sm text-gray-600">
                Mengalami masalah? 
                <a href="mailto:info@ruangteduh.test" class="text-[#C2A25D] hover:text-[#a88a4d] font-semibold">
                    Hubungi Tim Support
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>