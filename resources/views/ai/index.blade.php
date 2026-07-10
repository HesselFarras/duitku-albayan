@extends('layouts.app')

@section('content')
<div class="flex flex-col items-start p-[48px] gap-[48px] w-full max-w-[1280px] min-h-screen mx-auto bg-[#F9F9F8]">
    
    {{-- Header --}}
    <div class="w-full flex justify-between items-end">
        <div class="space-y-2">
            <p class="font-[Inter] font-bold text-[10px] tracking-[0.2em] uppercase text-[#887364]">
                OPERASIONAL / <span class="text-[#8D4B00]">AI INSIGHT</span>
            </p>
            <h1 class="font-[Manrope] font-black text-[48px] leading-tight tracking-[-0.04em] text-[#1A1C1C]">
                Analisis Kas Asisten AI
            </h1>
        </div>

        {{-- Filter Bulan & Tahun --}}
        <form action="{{ route('ai.index') }}" method="GET" class="flex items-center gap-2 bg-white border border-[#DBC2B0]/30 rounded-2xl px-3 py-1.5 shadow-sm m-0">
            <i data-lucide="calendar" class="w-4 h-4 text-[#8D4B00] ml-1"></i>
            <select name="bulan" onchange="this.form.submit()" class="bg-transparent border-none text-xs font-bold text-[#554336] focus:ring-0 cursor-pointer pr-8 py-1">
                @for($m=1; $m<=12; $m++)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                        {{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            <select name="tahun" onchange="this.form.submit()" class="bg-transparent border-none text-xs font-bold text-[#554336] focus:ring-0 cursor-pointer pr-8 py-1">
                @for($y = Carbon\Carbon::now()->year; $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </form>
    </div>

    {{-- Main Container Spark AI --}}
    <div class="w-full grid grid-cols-1 md:grid-cols-[380px_1fr] gap-[48px] items-stretch">
        
        {{-- Sisi Kiri: Rekap Angka Kas --}}
        <div class="flex flex-col gap-6">
            <div class="bg-white border border-[#DBC2B0]/10 rounded-[40px] p-8 shadow-sm">
                <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364] mb-2">Status Kesehatan Kas</p>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold uppercase {{ $insights['color'] }}">
                    {{ $insights['status'] }}
                </span>
                <hr class="my-6 border-[#F4F4F3]">
                
                <div class="space-y-4 text-sm font-[Manrope]">
                    <div class="flex justify-between">
                        <span class="text-[#554336]">Pemasukan:</span>
                        <span class="font-black text-[#1A1C1C]">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#554336]">Pengeluaran:</span>
                        <span class="font-black text-[#BA1A1A]">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-dashed border-[#F4F4F3]">
                        <span class="text-[#1A1C1C] font-bold">Sisa Saldo:</span>
                        <span class="font-black text-[#8D4B00]">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#1A1C1C] rounded-[40px] p-8 text-white relative overflow-hidden">
                <div class="absolute right-[-20px] bottom-[-20px] opacity-10">
                    <i data-lucide="brain-circuit" class="w-40 h-40 text-white"></i>
                </div>
                <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-white/60 mb-2">Titik Beban Utama</p>
                <h4 class="font-[Manrope] font-black text-xl text-white truncate">{{ strtoupper($kategoriTerbesar) }}</h4>
                <p class="font-[Manrope] text-xs text-white/70 mt-2 leading-relaxed">
                    Kategori di atas mengonsumsi porsi dana keluar paling dominan pada periode yang sedang aktif dipilih.
                </p>
            </div>
        </div>

        {{-- Sisi Kanan: Output Kotak Analisis AI --}}
        <div class="bg-white border border-[#DBC2B0]/10 rounded-[48px] p-10 shadow-sm flex flex-col justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 text-[#8D4B00]/10">
                <i data-lucide="sparkles" class="w-24 h-24"></i>
            </div>

            <div class="space-y-8 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="bg-[#8D4B00]/10 p-3 rounded-2xl">
                        <i data-lucide="cpu" class="w-6 h-6 text-[#8D4B00]"></i>
                    </div>
                    <div>
                        <h3 class="font-[Manrope] font-black text-2xl text-[#1A1C1C]">Rangkuman Cerdas Sistem</h3>
                        <p class="font-[Inter] text-[10px] text-[#887364] uppercase font-bold tracking-wider">Hasil Autogenerate Berbasis Algoritma DKM</p>
                    </div>
                </div>

                {{-- Blok Kesimpulan --}}
                <div class="space-y-3">
                    <h5 class="font-[Manrope] font-extrabold text-sm text-[#1A1C1C] flex items-center gap-2">
                        <i data-lucide="activity" class="w-4 h-4 text-[#8D4B00]"></i> Kondisi Arus Kas
                    </h5>
                    <p class="font-[Manrope] text-sm text-[#554336] leading-relaxed bg-[#F9F9F8] p-5 rounded-2xl border border-[#DBC2B0]/20">
                        {{ $insights['kesimpulan'] }}
                    </p>
                </div>

                {{-- Blok Rekomendasi --}}
                <div class="space-y-3">
                    <h5 class="font-[Manrope] font-extrabold text-sm text-[#1A1C1C] flex items-center gap-2">
                        <i data-lucide="lightbulb" class="w-4 h-4 text-[#8D4B00]"></i> Saran Strategis DKM
                    </h5>
                    <p class="font-[Manrope] text-sm text-[#554336] leading-relaxed border-l-4 border-[#8D4B00] pl-4 py-1">
                        {!! $insights['rekomendasi'] !!}
                    </p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-[#F4F4F3] text-[11px] text-[#887364] font-medium flex items-center gap-2">
                <i data-lucide="shield-check" class="w-4 h-4 text-[#526050]"></i>
                Analisis ini bersifat kalkulasi instan terhadap data masukan tanpa memungut biaya token API eksternal.
            </div>
        </div>

    </div>
</div>
@endsection