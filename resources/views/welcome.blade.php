<x-guest-layout>
    <main class="flex min-h-screen w-full overflow-hidden bg-[#F9F9F8]">
        
        <section class="relative hidden w-1/2 items-center lg:flex">
            <div class="absolute inset-0 z-0 bg-[#E2E2E2]">
                <img src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?q=80&w=1280" 
                     class="h-full w-full object-cover" 
                     alt="Mosque Architecture">
                
                <div class="absolute inset-0 bg-gradient-to-tr from-[rgba(47,21,0,0.4)] to-transparent z-10"></div>
            </div>

            <div class="relative z-20 px-16 w-full max-w-[672px]">
                <div class="flex flex-col gap-[23px]">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-[#8D4B00] to-[#B15F00] shadow-lg">
                            <div class="h-5 w-5 bg-white"></div>
                        </div>
                        <h2 class="font-manrope text-[30px] leading-9 tracking-[-0.75px] text-white">
                            DKM Al-Bayan
                        </h2>
                    </div>

                    <h1 class="font-manrope text-[48px] font-bold leading-[60px] text-white">
                        Transparent Financial Management for the Ummah.
                    </h1>

                    <p class="font-manrope text-[20px] font-light leading-8 text-white/80">
                        Managing mosque funds with trust, clarity, and modern digital accountability.
                    </p>
                </div>
            </div>

            <div class="absolute bottom-12 left-16 flex gap-4 z-20">
                <div class="h-1 w-12 bg-[#8D4B00]"></div>
                <div class="h-1 w-12 bg-white/30"></div>
                <div class="h-1 w-12 bg-white/30"></div>
            </div>
        </section>


        <section class="flex w-full flex-col justify-between bg-[#F9F9F8] p-8 md:p-24 lg:w-1/2">
            
            <div class="mx-auto flex w-full max-w-[448px] flex-grow flex-col justify-center">
                <header class="mb-10">
                    <h1 class="font-manrope text-[36px] leading-[40px] text-[#1A1C1C]">
                        Assalamu'alaikum, Admin
                    </h1>
                    <p class="mt-2 font-manrope text-[16px] leading-6 text-[#554336]">
                        Please enter your credentials to access the secure portal.
                    </p>
                </header>

                <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-6">
                    @csrf
                    
                    <div class="flex flex-col gap-2">
                        <label class="font-inter text-[10px] font-bold tracking-[1px] text-[#887364] uppercase">
                            EMAIL ADDRESS
                        </label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#887364]">
                                <svg class="w-[16.67px] h-[13.33px]" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full h-14 bg-[#F4F4F3] border-none rounded-md pl-12 pr-4 font-manrope text-[16px] text-[#1A1C1C] placeholder-[#887364]/50 focus:ring-2 focus:ring-[#8D4B00]/20 transition-all"
                                placeholder="admin@amanahledger.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <label class="font-inter text-[10px] font-bold tracking-[1px] text-[#887364] uppercase">
                                PASSWORD
                            </label>
                            <a href="{{ route('password.request') }}" class="font-manrope text-[10px] font-bold tracking-[1px] text-[#8D4B00] uppercase hover:opacity-80 transition-opacity">
                                FORGOT PASSWORD?
                            </a>
                        </div>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#887364]">
                                <svg class="w-[13.33px] h-[17.5px]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            </span>
                            <input type="password" name="password" required
                                class="w-full h-14 bg-[#F4F4F3] border-none rounded-md px-12 font-manrope text-[16px] text-[#1A1C1C] placeholder-[#887364]/50 focus:ring-2 focus:ring-[#8D4B00]/20 transition-all"
                                placeholder="••••••••">
                            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#887364]">
                                <svg class="w-[18.33px] h-[12.5px]" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="mt-4 flex flex-col gap-4">
                        <button type="submit" 
                            class="w-full h-[60px] bg-gradient-to-r from-[#8D4B00] to-[#B15F00] rounded-full text-white font-manrope font-bold text-[18px] shadow-[0px_10px_15px_-3px_rgba(141,75,0,0.1)] transition-transform active:scale-[0.98] hover:brightness-110">
                            Login
                        </button>
                        
                        <div class="h-[1px] w-full border-t border-[#DBC2B0]/30 mt-4"></div>
                    </div>
                </form>
            </div>

            <footer class="mt-auto pt-12 flex flex-col md:flex-row justify-between items-center border-t border-[#DBC2B0]/10 gap-4">
                <span class="font-inter text-[10px] tracking-[1px] text-[#887364]/60 uppercase">
                    © 2026 AMANAH LEDGER V.2.0
                </span>
                <nav class="flex gap-6 font-inter text-[10px] tracking-[1px] text-[#887364] uppercase">
                    <a href="#" class="hover:text-[#8D4B00] transition-colors">Help</a>
                    <a href="#" class="hover:text-[#8D4B00] transition-colors">Privacy</a>
                    <a href="#" class="hover:text-[#8D4B00] transition-colors">Terms</a>
                </nav>
            </footer>
        </section>
    </main>
</x-guest-layout>