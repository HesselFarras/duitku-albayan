@extends('layouts.app')

@section('content')
<div class="max-w-[1200px] mx-auto animate-in fade-in duration-700">
    
    {{-- Header Section --}}
    <div class="mb-10">
        <p class="font-[Inter] text-[12px] font-black uppercase tracking-[0.2em] text-[#8D4B00] mb-2">Intelligence Portal</p>
        <h1 class="font-[Manrope] font-black text-[48px] text-[#1A1C1C] leading-tight">Assalamu'alaikum, Admin</h1>
        <p class="font-[Manrope] text-lg text-[#887364] mt-2">
            AI telah menganalisis 4,281 transaksi untuk memberikan rekomendasi tata kelola untuk siklus bulan depan.
        </p>
    </div>

    {{-- Top Grid: Main Anomaly & Forecast --}}
    <div class="grid grid-cols-12 gap-8 mb-8">
        {{-- Hero Anomaly Card --}}
        <div class="col-span-8 bg-[#3D2616] rounded-[48px] p-10 relative overflow-hidden shadow-2xl shadow-stone-200">
            {{-- Background Accent --}}
            <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-white/5 to-transparent"></div>
            
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <div class="inline-flex items-center gap-2 bg-[#FFDCC3]/10 border border-white/10 px-4 py-2 rounded-full mb-8">
                        <span class="w-2 h-2 rounded-full bg-[#FFDCC3] animate-pulse"></span>
                        <span class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#FFDCC3]">Urgent Anomaly Detected</span>
                    </div>
                    
                    <h2 class="font-[Manrope] font-extrabold text-[40px] text-white leading-tight mb-4">
                        Unusual <br> Maintenance Outlay
                    </h2>
                    
                    <p class="font-[Manrope] text-white/60 text-lg max-w-md leading-relaxed">
                        Sistem mendeteksi deviasi 42% pada biaya listrik di Sektor 4 dibandingkan rata-rata historis. Disarankan investigasi kebocoran infrastruktur.
                    </p>
                </div>

                <div class="flex gap-4 mt-12">
                    <button class="bg-[#8D4B00] hover:bg-[#7a4100] text-white font-[Manrope] font-black px-8 py-4 rounded-3xl transition-all active:scale-95">
                        Run Diagnostics
                    </button>
                    <button class="bg-white/5 hover:bg-white/10 text-white/80 font-[Manrope] font-bold px-8 py-4 rounded-3xl transition-all border border-white/10">
                        Dismiss
                    </button>
                </div>
            </div>

            {{-- Graph Visual --}}
            <div class="absolute right-12 top-1/2 -translate-y-1/2 flex flex-col items-center">
                <div class="relative">
                    <svg class="w-32 h-32 text-white/10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-width="1" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pt-4">
                        <span class="text-white font-[Manrope] font-black text-4xl">+42%</span>
                        <span class="text-white/40 font-[Inter] text-[10px] uppercase tracking-widest">Variance Peak</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Forecast Card --}}
        <div class="col-span-4 bg-white rounded-[48px] p-10 border border-[#DBC2B0]/20 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364] mb-1">Liquidity Forecast</p>
                        <h3 class="font-[Manrope] font-black text-2xl text-[#1A1C1C]">Safar 1446</h3>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-[#F9F9F8] flex items-center justify-center text-[#8D4B00]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex justify-between items-end">
                        <span class="text-[#887364] font-medium">Expected Inflow</span>
                        <span class="text-[#1A1C1C] font-[Manrope] font-black">IDR 142.5M</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-end">
                            <span class="text-[#887364] font-medium">Fixed Obligations</span>
                            <span class="text-[#8D4B00] font-[Manrope] font-black">IDR 89.2M</span>
                        </div>
                        <div class="w-full h-2 bg-[#F4F4F3] rounded-full overflow-hidden">
                            <div class="h-full bg-[#8D4B00] rounded-full" style="width: 65%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-sm text-[#887364] leading-relaxed italic border-t border-[#F4F4F3] pt-6 mt-6">
                "Ekspektasi surplus memungkinkan alokasi strategis kembali ke Dana Abadi (Endowment Fund)."
            </p>
        </div>
    </div>

    {{-- Middle Grid: Efficiency & Social Score --}}
    <div class="grid grid-cols-2 gap-8 mb-8">
        <div class="bg-[#E7F0E4] rounded-[48px] p-10 flex items-start gap-8 group hover:scale-[1.02] transition-transform">
            <div class="w-16 h-16 rounded-[24px] bg-white flex items-center justify-center text-[#526050] shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="font-[Manrope] font-black text-[32px] text-[#1A1C1C]">12.4%</span>
                    <span class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#526050]">Potential Savings</span>
                </div>
                <h4 class="font-[Manrope] font-extrabold text-xl text-[#1A1C1C] mb-3">Operational Optimization</h4>
                <p class="text-[#526050]/80 leading-relaxed">
                    Transisi ke pengadaan digital untuk alat kebersihan dapat menghemat biaya Rp 4.2jt per tahun.
                </p>
            </div>
        </div>

        <div class="bg-[#F5EBE4] rounded-[48px] p-10 flex items-start gap-8 group hover:scale-[1.02] transition-transform">
            <div class="w-16 h-16 rounded-[24px] bg-white flex items-center justify-center text-[#8D4B00] shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="font-[Manrope] font-black text-[32px] text-[#1A1C1C]">High</span>
                    <span class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#8D4B00]">Impact Score</span>
                </div>
                <h4 class="font-[Manrope] font-extrabold text-xl text-[#1A1C1C] mb-3">Zakat Optimization</h4>
                <p class="text-[#8D4B00]/80 leading-relaxed">
                    Data menyarankan pengalihan 15% distribusi ke pendidikan mikro lokal untuk dampak ROI sosial jangka panjang.
                </p>
            </div>
        </div>
    </div>

    {{-- Recommended Allocation Section --}}
    <div class="bg-white rounded-[48px] p-10 border border-[#DBC2B0]/20 shadow-sm mb-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h3 class="font-[Manrope] font-black text-2xl text-[#1A1C1C]">Recommended Allocation</h3>
                <p class="text-[#887364] text-sm">Berdasarkan pemodelan dampak sosial algoritma.</p>
            </div>
            <div class="flex bg-[#F4F4F3] p-1 rounded-2xl">
                <button class="px-6 py-2 text-sm font-bold text-[#887364]">Current</button>
                <button class="px-6 py-2 text-sm font-black bg-[#8D4B00] text-white rounded-xl shadow-lg shadow-[#8D4B00]/20">Suggested</button>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-8">
            @php
                $allocations = [
                    ['label' => 'INFRASTRUCTURE', 'value' => '28%', 'height' => 'h-32', 'color' => 'bg-[#8D4B00]'],
                    ['label' => 'COMMUNITY', 'value' => '35%', 'height' => 'h-40', 'color' => 'bg-[#A35D0D]'],
                    ['label' => 'EDUCATION', 'value' => '22%', 'height' => 'h-24', 'color' => 'bg-[#C67C2C]'],
                    ['label' => 'RESERVE', 'value' => '15%', 'height' => 'h-16', 'color' => 'bg-[#D49B5D]'],
                ];
            @endphp

            @foreach($allocations as $item)
            <div class="flex flex-col items-center">
                <div class="w-full bg-[#F9F9F8] rounded-3xl h-64 flex items-end p-4 mb-4">
                    <div class="w-full {{ $item['height'] }} {{ $item['color'] }} rounded-2xl transition-all duration-1000 ease-out group-hover:opacity-80"></div>
                </div>
                <div class="text-center">
                    <p class="font-[Inter] text-[10px] font-black text-[#887364] tracking-widest mb-1">{{ $item['label'] }}</p>
                    <p class="font-[Manrope] font-black text-xl text-[#1A1C1C]">{{ $item['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Bottom Quote --}}
    <div class="py-12 flex flex-col items-center text-center">
        <div class="w-12 h-px bg-[#DBC2B0] mb-8"></div>
        <svg class="w-10 h-10 text-[#DBC2B0] mb-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.154c-2.433.914-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
        <h2 class="font-[Manrope] font-extrabold text-[32px] text-[#1A1C1C] max-w-2xl leading-tight mb-4">
            "The best of people are those who are most beneficial to others."
        </h2>
        <p class="font-[Inter] text-xs font-black uppercase tracking-[0.3em] text-[#8D4B00]">Prophetic Wisdom</p>
    </div>
</div>
@endsection