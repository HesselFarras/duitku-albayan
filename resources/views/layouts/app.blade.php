<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'DKM' }} Al-Bayan</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800;900&family=Inter:wght@400;700&display=swap" rel="stylesheet">
    
    {{-- Scripts & Styles --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F9F9F8] font-sans">

    {{-- Sidebar --}}
    <aside class="fixed left-0 top-0 h-screen w-72 bg-[rgba(244,244,243,0.8)] backdrop-blur-md flex flex-col justify-between py-10 z-20 shadow-[24px_0px_48px_-12px_rgba(85,67,54,0.08)]">

        {{-- Logo --}}
        <div class="px-8 mb-12">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#8D4B00] rounded-3xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-5 text-white" fill="currentColor" viewBox="0 0 24 20">
                        <path d="M12 0L6 6H2v14h20V6h-4L12 0zm0 3.5L16 7.5V18H8V7.5L12 3.5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-[Manrope] font-extrabold text-xl text-[#554336] leading-tight">DKM Al-Bayan</p>
                    <p class="font-[Inter] text-[10px] text-[#887364] tracking-[0.1em] uppercase">Masjid al-bayan</p>
                </div>
            </div>
        </div>

        {{-- Nav Links --}}
        <nav class="flex-1 flex flex-col">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}" @class([
                'flex items-center gap-4 px-8 py-4 font-[Manrope] text-sm tracking-wide transition-all',
                'bg-white rounded-r-full font-bold text-[#92400E] shadow-sm' => request()->routeIs('dashboard'),
                'font-medium text-[#554336] hover:bg-white/50' => !request()->routeIs('dashboard'),
            ])>
                <svg class="w-[18px] h-[18px] flex-shrink-0" fill="currentColor" viewBox="0 0 18 18">
                    <rect x="0" y="0" width="8" height="8" rx="2"/><rect x="10" y="0" width="8" height="8" rx="2"/>
                    <rect x="0" y="10" width="8" height="8" rx="2"/><rect x="10" y="10" width="8" height="8" rx="2"/>
                </svg>
                Dashboard
            </a>

            {{-- Transaksi --}}
            <a href="{{ route('transaksi.index') }}" @class([
                'flex items-center gap-4 px-8 py-4 font-[Manrope] text-sm tracking-wide transition-all',
                'bg-white rounded-r-full font-bold text-[#92400E] shadow-sm' => request()->routeIs('transaksi.*'),
                'font-medium text-[#554336] hover:bg-white/50' => !request()->routeIs('transaksi.*'),
            ])>
                <svg class="w-[18px] h-[18px] flex-shrink-0" fill="currentColor" viewBox="0 0 18 18">
                    <path d="M9 0L0 4v2h18V4L9 0zM2 8v6H0v2h18v-2h-2V8h-2v6H4V8H2z"/>
                </svg>
                Transaksi
            </a>

            {{-- Laporan --}}
            <a href="{{ route('laporan.index') }}" @class([
                'flex items-center gap-4 px-8 py-4 font-[Manrope] text-sm tracking-wide transition-all',
                'bg-white rounded-r-full font-bold text-[#92400E] shadow-sm' => request()->routeIs('laporan.*'),
                'font-medium text-[#554336] hover:bg-white/50' => !request()->routeIs('laporan.*'),
            ])>
                <svg class="w-[22px] h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 22 16">
                    <path d="M0 0h22v3H0zm0 6.5h22v3H0zm0 6.5h14v3H0z"/>
                </svg>
                Laporan
            </a>

            {{-- Kegiatan --}}
            <a href="{{ route('activities.index') }}" @class([
                'flex items-center gap-4 px-8 py-4 font-[Manrope] text-sm tracking-wide transition-all',
                'bg-white rounded-r-full font-bold text-[#92400E] shadow-sm' => request()->routeIs('activities.*'),
                'font-medium text-[#554336] hover:bg-white/50' => !request()->routeIs('activities.*'),
            ])>
                <svg class="w-[18px] h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 18 20">
                    <path d="M9 0C6.2 0 4 2.2 4 5s2.2 5 5 5 5-2.2 5-5-2.2-5-5-5zm0 12C4 12 0 14 0 16v2h18v-2c0-2-4-4-9-4z"/>
                </svg>
                Kegiatan
            </a>
            {{-- AI Insight - NEW --}}
            <a href="{{ route('ai.index') }}" @class([
                'flex items-center gap-4 px-8 py-4 font-[Manrope] text-sm tracking-wide transition-all group',
                'bg-white rounded-r-full font-bold text-[#8D4B00] shadow-sm' => request()->routeIs('ai.*'),
                'font-medium text-[#554336] hover:bg-white/50' => !request()->routeIs('ai.*'),
            ])>
                <svg class="w-[18px] h-[18px] flex-shrink-0 @if(request()->routeIs('ai.*')) text-[#8D4B00] @else text-[#887364] @endif group-hover:text-[#8D4B00]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L14.4 9.6L22 12L14.4 14.4L12 22L9.6 14.4L2 12L9.6 9.6L12 2ZM19 4L20.1 7.1L23.2 8.2L20.1 9.3L19 12.4L17.9 9.3L14.8 8.2L17.9 7.1L19 4ZM5.4 3L6 4.7L7.7 5.3L6 5.9L5.4 7.6L4.8 5.9L3.1 5.3L4.8 4.7L5.4 3Z"/>
                </svg>
                AI Insight
            </a>
        </nav>

        {{-- Bottom Actions --}}
        <div class="px-8 border-t border-[rgba(219,194,176,0.1)] pt-8 space-y-4">

            <div class="flex flex-col gap-1">
                <a href="#" class="flex items-center gap-4 py-2 font-[Manrope] font-medium text-sm text-[#554336] hover:text-[#8D4B00] transition-colors tracking-wide">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 0a10 10 0 100 20A10 10 0 0010 0zm1 15H9V9h2v6zm0-8H9V5h2v2z"/>
                    </svg>
                    Bantuan
                </a>
                
                {{-- Logout Form --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 py-2 font-[Manrope] font-medium text-sm text-[#554336] hover:text-red-600 transition-colors tracking-wide">
                        <svg class="w-[18px] h-[18px] flex-shrink-0" fill="currentColor" viewBox="0 0 18 18">
                            <path d="M9 0C4 0 0 4 0 9s4 9 9 9 9-4 9-9-4-9-9-9zm0 16c-3.9 0-7-3.1-7-7s3.1-7 7-7 7 3.1 7 7-3.1 7-7 7zm0-11.5l-4 4h2.5V14h3v-5.5H13L9 4.5z"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Sisanya tetap sama... --}}
    <div class="ml-72 flex flex-col min-h-screen">
        <header class="sticky top-0 z-10 bg-[#F9F9F8]/80 backdrop-blur-sm h-20 px-12 flex items-center justify-between">
            <div class="relative w-96">
                <div class="absolute left-4 top-1/2 -translate-y-1/2">
                    <svg class="w-[18px] h-[18px] text-[#887364]" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M12.9 11.5h-.8l-.3-.3A7 7 0 101.5 7a7 7 0 009.2 6.8l.3.3v.8l5 5 1.5-1.5-5-4.9zm-6.5 0A4.8 4.8 0 116.4 2a4.8 4.8 0 010 9.5z"/>
                    </svg>
                </div>
                <input type="text" placeholder="Cari transaksi atau laporan..." class="w-full pl-12 pr-4 py-2.5 bg-[#F4F4F3] rounded-full font-[Manrope] text-sm text-[#1A1C1C] placeholder-[#DBC2B0] border-none focus:ring-2 focus:ring-[#8D4B00]/30 transition-all">
            </div>

            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <button class="relative w-9 h-9 flex items-center justify-center rounded-full hover:bg-[#F4F4F3] transition-colors group">
                        <svg class="w-4 h-5 text-[#554336] group-hover:text-[#8D4B00]" fill="currentColor" viewBox="0 0 16 20">
                            <path d="M8 0C5.2 0 3 2.2 3 5v1.3C1.2 7.2 0 8.9 0 11v5h5v1a3 3 0 006 0v-1h5v-5c0-2.1-1.2-3.8-3-4.7V5c0-2.8-2.2-5-5-5zm0 18a1 1 0 01-1-1h2a1 1 0 01-1 1z"/>
                        </svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-[#8D4B00] rounded-full border-2 border-[#F9F9F8]"></span>
                    </button>
                    <button class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-[#F4F4F3] transition-colors">
                        <svg class="w-5 h-5 text-[#554336]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a4 4 0 100 8 4 4 0 000-8zm8.7 2.9l-1.4-.2a7.7 7.7 0 00-.7-1.6l.8-1.2-1.4-1.4-1.2.8a7.7 7.7 0 00-1.6-.7L13 3h-2l-.2 1.4a7.7 7.7 0 00-1.6.7L8 4.3 6.6 5.7l.8 1.2a7.7 7.7 0 00-.7 1.6L5.3 8.7l-.3.3v2l1.4.2c.2.6.4 1.1.7 1.6l-.8 1.2 1.4 1.4 1.2-.8c.5.3 1 .5 1.6.7L11 17h2l.2-1.4c.6-.2 1.1-.4 1.6-.7l1.2.8 1.4-1.4-.8-1.2c.3-.5.5-1 .7-1.6l1.4-.2V9l-.3-.3V9zm-8.7 3a3 3 0 110-6 3 3 0 010 6z"/>
                        </svg>
                    </button>
                </div>

                <div class="w-px h-8 bg-[rgba(219,194,176,0.3)]"></div>

                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="font-[Manrope] font-bold text-xs text-[#1A1C1C] tracking-tight leading-none mb-1">
                            {{ auth()->user()->name ?? 'Admin Masjid' }}
                        </p>
                        <p class="font-[Inter] text-[10px] text-[#554336] uppercase tracking-tight">Bendahara</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-[#FFDCC3] border-2 border-white shadow-sm flex items-center justify-center font-[Manrope] font-bold text-sm text-[#8D4B00]">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 px-12 pt-12 pb-20">
            @yield('content')
        </main>
    </div>

    <button class="fixed right-10 bottom-10 w-16 h-16 bg-[#8D4B00] text-white rounded-full flex items-center justify-center shadow-[0px_25px_50px_-12px_rgba(141,75,0,0.4)] hover:bg-[#7a4100] hover:scale-110 active:scale-95 transition-all z-30 group">
        <svg class="w-6 h-6 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/>
        </svg>
    </button>
</body>
</html>