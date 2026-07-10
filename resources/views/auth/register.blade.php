<x-guest-layout>
    <div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-12 bg-[#F9F9F8] font-[Manrope]">
        
        {{-- Sisi Kiri: Branding Visual --}}
        <div class="hidden lg:flex lg:col-span-5 bg-[#1A1C1C] relative flex-col justify-between p-16 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#FFF_1px,transparent_1px)] [background-size:16px_16px]"></div>
            
            <div class="relative z-10 space-y-2">
                <p class="font-[Inter] font-bold text-[10px] tracking-[0.2em] text-[#887364] uppercase">REGISTRASI OPERASIONAL</p>
                <h2 class="text-3xl font-black text-white tracking-tight">Mulai Khidmat</h2>
            </div>

            <div class="relative z-10 space-y-4">
                <p class="text-2xl font-medium text-[#DBC2B0] leading-relaxed">
                    "Gabung bersama jajaran kepengurusan DKM untuk pengelolaan masjid yang akuntabel."
                </p>
                <div class="h-1 w-12 bg-[#8D4B00] rounded-full"></div>
            </div>

            <p class="relative z-10 text-xs font-bold text-[#887364] font-[Inter] tracking-wide">
                &copy; 2026 DKM Al-Amanah. All Rights Reserved.
            </p>
        </div>

        {{-- Sisi Kanan: Form Registrasi --}}
        <div class="col-span-1 lg:col-span-7 flex flex-col justify-center px-8 sm:px-16 lg:px-24 xl:px-32 py-12">
            <div class="w-full max-w-[440px] mx-auto space-y-8">
                
                {{-- Header Form --}}
                <div class="space-y-2">
                    <h1 class="text-3xl font-black text-[#1A1C1C] tracking-tight">Daftar Pengurus Baru</h1>
                    <p class="text-sm font-bold text-[#887364]">Lengkapi kredensial data diri Anda di bawah.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div class="space-y-1.5">
                        <label for="name" class="text-xs font-black uppercase text-[#887364] tracking-wider">Nama Lengkap</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                            class="w-full rounded-2xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm py-3.5 px-4 text-[#1A1C1C]"
                            placeholder="Contoh: Muhammad Abdullah">
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    {{-- Email Address --}}
                    <div class="space-y-1.5">
                        <label for="email" class="text-xs font-black uppercase text-[#887364] tracking-wider">Alamat Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                            class="w-full rounded-2xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm py-3.5 px-4 text-[#1A1C1C]"
                            placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    {{-- Password --}}
                    <div class="space-y-1.5">
                        <label for="password" class="text-xs font-black uppercase text-[#887364] tracking-wider">Kata Sandi</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="w-full rounded-2xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm py-3.5 px-4 text-[#1A1C1C]"
                            placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    {{-- Confirm Password --}}
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="text-xs font-black uppercase text-[#887364] tracking-wider">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="w-full rounded-2xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm py-3.5 px-4 text-[#1A1C1C]"
                            placeholder="Ulangi kata sandi">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="w-full bg-[#8D4B00] hover:bg-amber-900 text-white font-bold py-4 px-6 rounded-2xl text-sm transition-all shadow-sm flex justify-center items-center gap-2 mt-2">
                        Daftarkan Akun Pengurus
                    </button>
                </form>

                {{-- Back to Login Link --}}
                <p class="text-center text-xs font-bold text-[#887364]">
                    Sudah terdaftar sebagai pengurus? 
                    <a href="{{ route('login') }}" class="text-[#8D4B00] hover:underline ml-1">Masuk Sekarang</a>
                </p>

            </div>
        </div>
    </div>
</x-guest-layout>