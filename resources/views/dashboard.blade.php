@extends('layouts.app')

@section('content')

{{-- HERO — Total Saldo --}}
<div class="flex items-end justify-between mb-12">
    <div class="space-y-2">
        <p class="font-[Inter] font-bold text-[12px] tracking-[0.1em] uppercase text-[#8D4B00]">Periode Ini</p>
        <h2 class="font-[Manrope] font-black text-[36px] leading-none tracking-[-0.05em] text-[#554336]">Saldo Masjid</h2>
        <div class="flex items-baseline gap-2 pt-2">
            <span class="font-[Manrope] font-bold text-xl text-[#887364]">Rp</span>
            <span class="font-[Manrope] font-black text-[60px] leading-none tracking-[-0.05em] text-[#1A1C1C]">
                {{ number_format($totalSaldo, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button class="flex items-center gap-2 bg-[#F4F4F3] rounded-[48px] px-6 py-3 font-[Manrope] font-bold text-base text-[#8D4B00] hover:bg-[#ede9e4] transition-colors">
            <svg class="w-4 h-4 text-[#8D4B00]" fill="currentColor" viewBox="0 0 16 16"><path d="M6 2a4 4 0 00-4 4v4a4 4 0 008 0V6a4 4 0 00-4-4zM0 6a6 6 0 1112 0v4a6 6 0 01-12 0V6zm13 .5a5 5 0 10-1 8.6V10a3.5 3.5 0 010-7v3.5z"/></svg>
            Ekspor
        </button>
        <a href="{{ route('transaksi.index') }}" class="flex items-center gap-2 bg-[#8D4B00] rounded-[48px] px-6 py-3 font-[Manrope] font-bold text-base text-white shadow-[0px_24px_48px_-12px_rgba(85,67,54,0.08)] hover:bg-[#7a4100] transition-colors">
            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9 0h2v9h9v2h-9v9H9v-9H0V9h9z"/></svg>
            Tambah Dana
        </a>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div class="grid grid-cols-3 gap-6 mb-12">
    {{-- Card Pemasukan --}}
    <div class="relative bg-white border-l-4 border-[#8D4B00] rounded-[48px] p-8 shadow-[0px_24px_48px_-12px_rgba(85,67,54,0.08)] flex flex-col gap-1">
        <div class="flex items-start justify-between">
            <div class="bg-[#FFDCC3] rounded-[32px] p-3 inline-flex">
                <svg class="w-5 h-3 text-[#8D4B00]" fill="currentColor" viewBox="0 0 20 12"><path d="M10 0L0 6l10 6 10-6L10 0z"/></svg>
            </div>
            <span class="bg-[#D8E7D2] text-[#526050] text-[12px] font-[Manrope] font-bold px-2 py-1 rounded-full">+12%</span>
        </div>
        <div class="mt-5"><p class="font-[Inter] text-[10px] text-[#887364] tracking-[0.1em] uppercase">Total Pemasukan</p></div>
        <h3 class="font-[Manrope] font-extrabold text-2xl text-[#1A1C1C]">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
        <div class="mt-3"><p class="font-[Manrope] text-xs text-[#554336]">Bulan ini, dari transaksi tercatat</p></div>
    </div>

    {{-- Card Pengeluaran --}}
    <div class="relative bg-white border-l-4 border-[#6A635E] rounded-[48px] p-8 shadow-[0px_24px_48px_-12px_rgba(85,67,54,0.08)] flex flex-col gap-1">
        <div class="flex items-start justify-between">
            <div class="bg-[#EAE1DA] rounded-[32px] p-3 inline-flex">
                <svg class="w-5 h-3 text-[#645D58]" fill="currentColor" viewBox="0 0 20 12"><path d="M10 12L0 6l10-6 10 6L10 12z"/></svg>
            </div>
            <span class="bg-[#FFDAD6] text-[#BA1A1A] text-[12px] font-[Manrope] font-bold px-2 py-1 rounded-full">-8%</span>
        </div>
        <div class="mt-5"><p class="font-[Inter] text-[10px] text-[#887364] tracking-[0.1em] uppercase">Total Pengeluaran</p></div>
        <h3 class="font-[Manrope] font-extrabold text-2xl text-[#1A1C1C]">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
        <div class="mt-3"><p class="font-[Manrope] text-xs text-[#554336]">Biaya operasional & maintenance</p></div>
    </div>

    {{-- Card Surplus --}}
    <div class="relative bg-white border-l-4 border-[#526050] rounded-[48px] p-8 shadow-[0px_24px_48px_-12px_rgba(85,67,54,0.08)] flex flex-col gap-1">
        <div class="flex items-start justify-between">
            <div class="bg-[#D8E7D2] rounded-[32px] p-3 inline-flex">
                <svg class="w-[19px] h-[18px] text-[#526050]" fill="currentColor" viewBox="0 0 19 18"><path d="M9.5 0L19 9.5 9.5 18 0 9.5 9.5 0zm0 5l-4.5 4.5 4.5 4.5 4.5-4.5L9.5 5z"/></svg>
            </div>
            <span class="bg-[#FFDCC3] text-[#8D4B00] text-[12px] font-[Manrope] font-bold px-2 py-1 rounded-full">+64%</span>
        </div>
        <div class="mt-5"><p class="font-[Inter] text-[10px] text-[#887364] tracking-[0.1em] uppercase">Surplus Operasional</p></div>
        <h3 class="font-[Manrope] font-extrabold text-2xl text-[#1A1C1C]">Rp {{ number_format($surplus, 0, ',', '.') }}</h3>
        <div class="mt-3"><p class="font-[Manrope] text-xs text-[#554336]">Dana cadangan tersedia</p></div>
    </div>
</div>

{{-- MAIN CONTENT GRID --}}
<div class="grid grid-cols-[1fr_277px] gap-8 items-start">
    <div class="flex flex-col gap-8">
            {{-- BAGIAN CHART — VERSI ANTI GAGAL --}}
    <div class="relative bg-white rounded-[48px] p-10 shadow-[0px_24px_48px_-12px_rgba(85,67,54,0.08)]">
        <div class="flex items-center justify-between mb-10">
            <h4 class="font-[Manrope] font-extrabold text-xl text-[#1A1C1C]">Statistik Keuangan</h4>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-[#8D4B00]"></div>
                    <span class="font-[Manrope] font-medium text-xs text-[#887364]">Masuk</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-[#645D58] opacity-40"></div>
                    <span class="font-[Manrope] font-medium text-xs text-[#887364]">Keluar</span>
                </div>
            </div>
        </div>
        
        {{-- Container ini kita kasih tinggi fixed 200px dan background tipis buat ngetes --}}
        <div class="flex items-end justify-between gap-4 h-[200px] w-full bg-[#FDFDFD] rounded-2xl p-4">
            @foreach($chartData as $item)
            <div class="flex-1 h-full flex flex-col justify-end items-center gap-3">
                
                {{-- Area Batang Grafik --}}
                <div class="w-full flex items-end justify-center gap-1.5 h-full">
                    {{-- Bar Pemasukan --}}
                    <div 
                        class="w-full max-w-[16px] bg-[#8D4B00] rounded-t-md transition-all duration-700"
                        style="height: {{ number_format($item['masuk'], 2, '.', '') }}% !important; min-height: 2px;"
                    ></div>
                    
                    {{-- Bar Pengeluaran --}}
                    <div 
                        class="w-full max-w-[16px] bg-[#645D58] opacity-30 rounded-t-md transition-all duration-700"
                        style="height: {{ number_format($item['keluar'], 2, '.', '') }}% !important; min-height: 2px;"
                    ></div>
                </div>

                {{-- Nama Bulan --}}
                <span class="font-[Inter] font-bold text-[10px] text-[#887364] uppercase tracking-tighter">
                    {{ $item['bulan'] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

        {{-- TRANSAKSI TERBARU --}}
        <div class="relative bg-white rounded-[48px] p-10 shadow-[0px_24px_48px_-12px_rgba(85,67,54,0.08)]">
            <div class="flex items-center justify-between mb-8">
                <h4 class="font-[Manrope] font-extrabold text-xl text-[#1A1C1C]">Transaksi Terbaru</h4>
                <a href="{{ route('transaksi.index') }}" class="font-[Manrope] font-bold text-sm text-[#8D4B00] hover:underline">Lihat semua</a>
            </div>

            <div class="flex flex-col gap-1">
                @foreach($recentTransactions as $trx)
                <div class="flex items-center justify-between px-4 py-4 rounded-[48px] hover:bg-[#F9F9F8] transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0" 
                             style="background-color: {{ $trx->type == 'income' ? '#D8E7D2' : '#EAE1DA' }}">
                            
                            @if($trx->type == 'income')
                                <svg class="w-5 h-5" fill="#526050" viewBox="0 0 20 20"><path d="M10 3l7 7H3l7-7z"/></svg>
                            @else
                                <svg class="w-[18px] h-5" fill="#645D58" viewBox="0 0 18 20"><path d="M0 0h18v4H0zm2 5h14v15H2z"/></svg>
                            @endif
                        </div>
                        <div>
                            <p class="font-[Manrope] font-bold text-base text-[#1A1C1C]">{{ $trx->title }}</p>
                            <p class="font-[Manrope] text-xs text-[#887364]">{{ $trx->date->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-[Manrope] font-black text-base {{ $trx->type == 'income' ? 'text-[#526050]' : 'text-[#1A1C1C]' }}">
                            {{ $trx->type == 'income' ? '+' : '-' }}Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </p>
                        <p class="font-[Inter] text-[10px] text-[#887364] uppercase">{{ $trx->type == 'income' ? 'MASUK' : 'KELUAR' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Sidebar Right --}}
    <div class="flex flex-col gap-8">
        {{-- AI Insights Panel --}}
        <div class="relative bg-[#1A1C1C] rounded-[48px] p-8 overflow-hidden shadow">
            <h5 class="font-[Manrope] font-normal text-2xl text-white mb-6">Analisis Keuangan Cerdas</h5>
            <div class="flex flex-col gap-6">
                <div class="bg-white/10 border border-white/5 backdrop-blur-sm rounded-[32px] p-4">
                    <p class="font-[Inter] text-xs text-[#DBC2B0] mb-2">TREN KAS</p>
                    <p class="font-[Manrope] text-sm text-[#E2E2E2]">{{ $aiInsight1 }}</p>
                </div>
                <div class="bg-white/10 border border-white/5 backdrop-blur-sm rounded-[32px] p-4">
                    <p class="font-[Inter] text-xs text-[#DBC2B0] mb-2">PENGELUARAN</p>
                    <p class="font-[Manrope] text-sm text-[#E2E2E2]">{{ $aiInsight2 }}</p>
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection