@extends('layouts.app')

@section('content')
{{-- Main Content Canvas: Mengikuti spesifikasi padding 48px dan gap 48px --}}
<div class="flex flex-col items-start p-[48px] gap-[48px] w-full max-w-[1280px] min-h-screen mx-auto bg-[#F9F9F8]">

    {{-- Breadcrumb & Header --}}
    <div class="w-full flex justify-between items-end">
        <div class="space-y-2">
            <p class="font-[Inter] font-bold text-[10px] tracking-[0.2em] uppercase text-[#887364]">
                UTAMA / <span class="text-[#8D4B00]">LAPORAN KEUANGAN</span>
            </p>
            <h1 class="font-[Manrope] font-black text-[48px] leading-tight tracking-[-0.04em] text-[#1A1C1C]">
                Laporan Keuangan
            </h1>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-white border border-[#DBC2B0]/30 rounded-2xl px-4 py-3 shadow-sm">
                <i data-lucide="calendar" class="w-4 h-4 text-[#8D4B00]"></i>
                <span class="font-[Manrope] font-bold text-sm text-[#554336]">1 Jan 2024 - 31 Mar 2024</span>
            </div>
            <button class="bg-[#1A1C1C] text-white rounded-2xl px-6 py-3 flex items-center gap-2 font-[Manrope] font-bold text-sm hover:bg-black transition-all">
                <i data-lucide="download" class="w-4 h-4"></i>
                Export PDF
            </button>
        </div>
    </div>

    {{-- Summary Cards Section --}}
    <div class="w-full grid grid-cols-3 gap-[24px]">
        {{-- Total Pemasukan --}}
        <div class="bg-white rounded-[40px] p-8 border border-[#DBC2B0]/10 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364] mb-4">Total Pemasukan</p>
                <h3 class="font-[Manrope] font-black text-[32px] text-[#1A1C1C]">Rp 128.450.000</h3>
                <div class="mt-4 flex items-center gap-2">
                    <span class="bg-[#D8E7D2] text-[#526050] text-[10px] font-black px-2 py-1 rounded-lg">+12.5%</span>
                    <span class="text-[10px] font-bold text-[#887364]">vs kuartal lalu</span>
                </div>
            </div>
            <i data-lucide="trending-up" class="absolute top-8 right-8 w-12 h-12 text-[#DBC2B0]/20 group-hover:scale-110 transition-transform"></i>
        </div>

        {{-- Total Pengeluaran --}}
        <div class="bg-white rounded-[40px] p-8 border border-[#DBC2B0]/10 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364] mb-4">Total Pengeluaran</p>
                <h3 class="font-[Manrope] font-black text-[32px] text-[#1A1C1C]">Rp 42.120.000</h3>
                <div class="mt-4 flex items-center gap-2">
                    <span class="bg-[#FFDAD6] text-[#BA1A1A] text-[10px] font-black px-2 py-1 rounded-lg">-4.2%</span>
                    <span class="text-[10px] font-bold text-[#887364]">efisiensi operasional</span>
                </div>
            </div>
            <i data-lucide="trending-down" class="absolute top-8 right-8 w-12 h-12 text-[#DBC2B0]/20 group-hover:scale-110 transition-transform"></i>
        </div>

        {{-- Saldo Bersih (Net) --}}
        <div class="bg-[#8D4B00] rounded-[40px] p-8 shadow-xl shadow-[#8D4B00]/20 relative overflow-hidden">
            <div class="relative z-10">
                <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-white/60 mb-4">Saldo Bersih (Net)</p>
                <h3 class="font-[Manrope] font-black text-[32px] text-white">Rp 86.330.000</h3>
                <div class="mt-6 pt-4 border-t border-white/10">
                    <p class="text-[10px] font-bold text-white/80 italic">Target Saldo Abadi: 67% tercapai</p>
                </div>
            </div>
            <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
        </div>
    </div>

    {{-- Chart & Allocation Section --}}
    <div class="w-full grid grid-cols-[1fr_380px] gap-[48px] items-stretch">
        {{-- Arus Kas Bulanan --}}
        <div class="bg-white rounded-[48px] p-10 border border-[#DBC2B0]/10 shadow-sm">
            <div class="flex justify-between items-center mb-10">
                <h4 class="font-[Manrope] font-black text-xl text-[#1A1C1C]">Arus Kas Bulanan</h4>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#8D4B00]"></span>
                        <span class="text-[10px] font-black uppercase text-[#887364]">Masuk</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#DBC2B0]"></span>
                        <span class="text-[10px] font-black uppercase text-[#887364]">Keluar</span>
                    </div>
                </div>
            </div>
            {{-- Placeholder for Chart --}}
            <div class="h-[300px] w-full flex items-end justify-between px-4 pb-2 border-b border-[#F4F4F3]">
                <div class="w-12 bg-[#F4F4F3] h-[40%] rounded-t-xl"></div>
                <div class="w-12 bg-[#F4F4F3] h-[60%] rounded-t-xl"></div>
                <div class="w-12 bg-[#8D4B00] h-[90%] rounded-t-xl relative">
                    <span class="absolute -top-8 left-1/2 -translate-x-1/2 text-[10px] font-black text-[#8D4B00]">MAR</span>
                </div>
                <div class="w-12 bg-[#F4F4F3] h-[50%] rounded-t-xl"></div>
                <div class="w-12 bg-[#F4F4F3] h-[70%] rounded-t-xl"></div>
            </div>
            <div class="flex justify-between mt-4 px-4 font-[Inter] text-[10px] font-black text-[#DBC2B0] uppercase tracking-widest">
                <span>Jan</span><span>Feb</span><span class="text-[#8D4B00]">Mar</span><span>Apr</span><span>Mei</span>
            </div>
        </div>

        {{-- Alokasi Dana --}}
        <div class="bg-white rounded-[48px] p-10 border border-[#DBC2B0]/10 shadow-sm flex flex-col items-center">
            <h4 class="w-full font-[Manrope] font-black text-xl text-[#1A1C1C] mb-8">Alokasi Dana</h4>
            <div class="relative w-48 h-48 mb-10">
                {{-- Simple SVG Circle Progress for 75% --}}
                <svg class="w-full h-full transform -rotate-90">
                    <circle cx="96" cy="96" r="80" stroke="#F4F4F3" stroke-width="24" fill="transparent" />
                    <circle cx="96" cy="96" r="80" stroke="#8D4B00" stroke-width="24" fill="transparent" stroke-dasharray="502.6" stroke-dashoffset="125.6" stroke-linecap="round" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="font-[Manrope] font-black text-4xl text-[#1A1C1C]">75%</span>
                    <span class="font-[Inter] text-[10px] font-black text-[#887364] uppercase tracking-widest">ZISWAF</span>
                </div>
            </div>
            <div class="w-full space-y-4">
                <div class="flex justify-between items-center border-b border-[#F4F4F3] pb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#8D4B00]"></span>
                        <span class="font-[Manrope] font-bold text-sm text-[#554336]">Zakat & Infaq</span>
                    </div>
                    <span class="font-[Manrope] font-black text-sm text-[#1A1C1C]">Rp 64.7M</span>
                </div>
                <div class="flex justify-between items-center border-b border-[#F4F4F3] pb-2">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#554336]"></span>
                        <span class="font-[Manrope] font-bold text-sm text-[#554336]">Operasional</span>
                    </div>
                    <span class="font-[Manrope] font-black text-sm text-[#1A1C1C]">Rp 12.1M</span>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#DBC2B0]"></span>
                        <span class="font-[Manrope] font-bold text-sm text-[#554336]">Renovasi</span>
                    </div>
                    <span class="font-[Manrope] font-black text-sm text-[#1A1C1C]">Rp 9.5M</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Transaksi Terverifikasi --}}
    <div class="w-full bg-white rounded-[48px] p-10 border border-[#DBC2B0]/10 shadow-sm overflow-hidden">
        <div class="flex justify-between items-center mb-8">
            <h4 class="font-[Manrope] font-black text-xl text-[#1A1C1C]">Transaksi Terverifikasi</h4>
            <div class="flex bg-[#F4F4F3] p-1 rounded-2xl">
                <button class="px-6 py-2 bg-white rounded-xl shadow-sm font-[Manrope] font-bold text-xs text-[#1A1C1C]">Semua</button>
                <button class="px-6 py-2 font-[Manrope] font-bold text-xs text-[#887364]">Harian</button>
            </div>
        </div>

        <table class="w-full">
            <thead class="text-left border-b border-[#F4F4F3]">
                <tr class="font-[Inter] text-[10px] font-black uppercase tracking-[0.2em] text-[#DBC2B0]">
                    <th class="py-6">Tanggal</th>
                    <th class="py-6">Kategori</th>
                    <th class="py-6">Keterangan</th>
                    <th class="py-6 text-center">Status</th>
                    <th class="py-6 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#F4F4F3]">
                {{-- Row 1 --}}
                <tr class="font-[Manrope]">
                    <td class="py-8 font-bold text-[#1A1C1C]">24 Mar 2024</td>
                    <td class="py-8">
                        <span class="bg-[#FFDCC3] text-[#8D4B00] text-[9px] font-black px-3 py-1.5 rounded-lg uppercase">Infaq Jumat</span>
                    </td>
                    <td class="py-8 text-sm text-[#554336]">Kotak Amal Masjid - Pekan 3</td>
                    <td class="py-8 text-center">
                        <div class="inline-flex items-center gap-1.5 text-[#526050] font-bold text-[11px]">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Verified
                        </div>
                    </td>
                    <td class="py-8 text-right font-black text-[#8D4B00] text-lg">+ Rp 14.250.000</td>
                </tr>
                {{-- Row 2 --}}
                <tr class="font-[Manrope]">
                    <td class="py-8 font-bold text-[#1A1C1C]">22 Mar 2024</td>
                    <td class="py-8">
                        <span class="bg-[#F4F4F3] text-[#554336] text-[9px] font-black px-3 py-1.5 rounded-lg uppercase">Operasional</span>
                    </td>
                    <td class="py-8 text-sm text-[#554336]">Tagihan Listrik & Internet Bulanan</td>
                    <td class="py-8 text-center">
                        <div class="inline-flex items-center gap-1.5 text-[#526050] font-bold text-[11px]">
                            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> Verified
                        </div>
                    </td>
                    <td class="py-8 text-right font-black text-[#BA1A1A] text-lg">- Rp 3.420.000</td>
                </tr>
            </tbody>
        </table>
        
        <div class="mt-8 text-center">
            <button class="font-[Manrope] font-black text-xs text-[#8D4B00] uppercase tracking-widest hover:underline flex items-center justify-center gap-2 mx-auto">
                Lihat Semua Transaksi <i data-lucide="arrow-right" class="w-3 h-3"></i>
            </button>
        </div>
    </div>

</div>

<script>
    lucide.createIcons();
</script>
@endsection