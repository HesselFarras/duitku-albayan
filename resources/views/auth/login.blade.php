<x-guest-layout>
    <div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-12 bg-[#F9F9F8] font-[Manrope]">
        
        {{-- Sisi Kiri: Visual Branding & Atmofser Hangat (Hidden on Mobile) --}}
        <div class="hidden lg:flex lg:col-span-5 bg-[#8D4B00] relative flex-col justify-between p-16 overflow-hidden">
            {{-- Decorative pattern overlay --}}
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#FFF_1px,transparent_1px)] [background-size:16px_16px]"></div>
            
            <div class="relative z-10 space-y-2">
                <p class="font-[Inter] font-bold text-[10px] tracking-[0.2em] text-[#FFDCC3] uppercase">SISTEM INFORMASI MASJID</p>
                <h2 class="text-3xl font-black text-white tracking-tight">Al-Amanah</h2>
            </div>

            <div class="relative z-10 space-y-4">
                <p class="text-2xl font-medium text-[#FFDCC3] leading-relaxed">
                    "Membangun transparansi umat, memakmurkan baitullah dengan amanah dan ketulusan."
                </p>
                <div class="h-1 w-12 bg-[#FFDCC3] rounded-full"></div>
            </div>

            <p class="relative z-10 text-xs font-bold text-[#FFDCC3]/60 font-[Inter] tracking-wide">
                &copy; 2026 DKM Al-Amanah. All Rights Reserved.
            </p>
        </div>

        {{-- Sisi Kanan: Form Autentikasi Elit --}}
        <div class="col-span-1 lg:col-span-7 flex flex-col justify-center px-8 sm:px-16 lg:px-24 xl:px-32 py-12">
            <div class="w-full max-w-[440px] mx-auto space-y-8">
                
                {{-- Header Form --}}
                <div class="space-y-2">
                    <h1 class="text-3xl font-black text-[#1A1C1C] tracking-tight">Selamat Datang Kembali</h1>
                    <p class="text-sm font-bold text-[#887364]">Silakan masuk untuk mengelola operasional DKM.</p>
                </div>

                {{-- Session Status --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email Address --}}
                    <div class="space-y-1.5">
                        <label for="email" class="text-xs font-black uppercase text-[#887364] tracking-wider">Alamat Email</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                class="w-full rounded-2xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm py-3.5 px-4 text-[#1A1C1C]" 
                                placeholder="nama@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    {{-- Password --}}
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <label for="password" class="text-xs font-black uppercase text-[#887364] tracking-wider">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-[#8D4B00] hover:underline" href="{{ route('password.request') }}">
                                    Lupa sandi?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full rounded-2xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm py-3.5 px-4 text-[#1A1C1C]"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-[#DBC2B0]/60 text-[#8D4B00] focus:ring-[#8D4B00] w-4 h-4">
                            <span class="ms-2 text-xs font-bold text-[#554336]">Ingat perangkat ini</span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="w-full bg-[#1A1C1C] hover:bg-black text-white font-bold py-4 px-6 rounded-2xl text-sm transition-all shadow-sm flex justify-center items-center gap-2 mt-2">
                        Masuk ke Dashboard
                    </button>
                </form>

                {{-- Sign Up Route Link --}}
                @if (Route::has('register'))
                    <p class="text-center text-xs font-bold text-[#887364]">
                        Belum punya akun pengurus? 
                        <a href="{{ route('register') }}" class="text-[#8D4B00] hover:underline ml-1">Daftar Akun Baru</a>
                    </p>
                @endif

            </div>
        </div>
    </div>
</x-guest-layout>