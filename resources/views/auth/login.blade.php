<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-[#F9F9F8] p-6">
        
        {{-- Card Login --}}
        <div class="w-full max-w-[480px] bg-white rounded-[48px] p-12 shadow-sm border border-[#DBC2B0]/10">
            
            {{-- Logo & Header --}}
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-[#8D4B00] rounded-[24px] flex items-center justify-center mx-auto mb-6 shadow-lg shadow-[#8D4B00]/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1 class="font-[Manrope] font-black text-3xl text-[#1A1C1C] mb-2">Selamat Datang</h1>
                <p class="font-[Manrope] text-sm text-[#887364]">Masuk untuk mengelola keuangan masjid</p>
            </div>

            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                @csrf

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-wider text-[#887364] ml-2">Email Pengurus</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                        class="w-full bg-[#F9F9F8] border-none rounded-[24px] py-4 px-6 font-bold text-[#1A1C1C] focus:ring-2 focus:ring-[#8D4B00] transition-all placeholder:text-[#DBC2B0]" 
                        placeholder="nama@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 ml-2" />
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-2">
                        <label class="text-[10px] font-black uppercase tracking-wider text-[#887364]">Kata Sandi</label>
                        @if (Route::has('password.request'))
                            <a class="text-[10px] font-bold text-[#8D4B00] hover:underline" href="{{ route('password.request') }}">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full bg-[#F9F9F8] border-none rounded-[24px] py-4 px-6 font-bold text-[#1A1C1C] focus:ring-2 focus:ring-[#8D4B00] transition-all placeholder:text-[#DBC2B0]"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 ml-2" />
                </div>

                <div class="flex items-center ml-2 mt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded-lg border-[#DBC2B0] text-[#8D4B00] shadow-sm focus:ring-[#8D4B00]" name="remember">
                        <span class="ms-2 text-xs font-bold text-[#887364]">Ingat sesi saya</span>
                    </label>
                </div>

                <div class="mt-4">
                    <button type="submit" class="w-full bg-[#1A1C1C] hover:bg-[#8D4B00] text-white font-black py-5 rounded-[24px] text-lg transition-all shadow-lg hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-3">
                        Masuk Sekarang
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>
            
            <p class="text-center mt-8 text-xs text-[#887364] font-medium">
                Belum punya akun? <span class="text-[#1A1C1C] font-black">Hubungi Admin Utama</span>
            </p>
        </div>

        {{-- Footer --}}
        <p class="mt-8 text-[10px] font-black uppercase tracking-[0.2em] text-[#DBC2B0]">E-Masjid • Transparansi Keuangan</p>
    </div>
</x-guest-layout>