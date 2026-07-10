@extends('layouts.app')

@section('content')
{{-- Kontrol CSS Spesifik untuk Kebutuhan Cetak Papan Pengumuman/PDF --}}
<style>
    @media print {
        /* 1. Sembunyikan total semua layout bawaan aplikasi */
        nav, sidebar, .sidebar, aside, [id*="sidebar"], [class*="sidebar"], 
        [class*="navigation"], .no-print, button, form, footer, 
        [class*="topbar"], [class*="header"], .sidebar-wrapper, #sidebar-nav {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }

        /* 2. Reset paksa seluruh wrapper induk bawaan template app.blade */
        html, body, #app, main, .main-content, [class*="main"], [class*="wrapper"], [class*="content"], .flex {
            background: white !important;
            color: #1A1C1C !important;
            padding-left: 0 !important; 
            margin-left: 0 !important;  
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            display: block !important;
            position: relative !important;
            float: none !important;
        }

        /* 3. Maksimalkan kontainer cetak agar simetris di tengah kertas */
        .container-print-fix {
            display: block !important;
            width: 100% !important;      
            max-width: 100% !important;
            margin: 0 auto !important;   
            padding: 5mm !important;
            background: white !important;
        }

        /* 4. Paksa Grid Summary menjadi 3 kolom sejajar di kertas */
        .print-grid-3 {
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 16px !important;
            width: 100% !important;
        }

        /* 5. Paksa Seksi Catatan & Rasio berdampingan (tidak turun ke bawah) */
        .print-grid-split {
            display: grid !important;
            grid-template-columns: 1fr 340px !important;
            gap: 24px !important;
            width: 100% !important;
        }

        /* 6. Styling Card versi cetak ekonomis tinta */
        .rounded-\[40px\], .rounded-\[48px\] {
            border-radius: 12px !important;
            padding: 16px !important;
            border: 1px solid #D5D5D5 !important;
            box-shadow: none !important;
            background: white !important;
        }

        /* Ringankan ukuran font agar pas di kertas */
        h1 { font-size: 26px !important; }
        h3 { font-size: 22px !important; }
        
        table { width: 100% !important; page-break-inside: auto; }
        tr { page-break-inside: avoid !important; page-break-after: auto; }
    }
</style>

{{-- Main Content Canvas --}}
<div class="flex flex-col items-start p-[48px] gap-[48px] w-full max-w-[1280px] min-h-screen mx-auto bg-[#F9F9F8] container container-print-fix">
    
    {{-- Breadcrumb & Header --}}
    <div class="w-full flex flex-col md:flex-row justify-between items-start md:items-end gap-4 no-print">
        <div class="space-y-2">
            <p class="font-[Inter] font-bold text-[10px] tracking-[0.2em] uppercase text-[#887364]">
                UTAMA / <span class="text-[#8D4B00]">LAPORAN KEUANGAN KAS</span>
            </p>
            <h1 class="font-[Manrope] font-black text-[48px] leading-tight tracking-[-0.04em] text-[#1A1C1C]">
                Laporan Keuangan
            </h1>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            {{-- TOMBOL KEMBALI KELOLA DATA (Hanya Muncul Jika Sudah Login) --}}
            @auth
            <a href="{{ route('transaksi.index') }}" class="bg-white border border-[#DBC2B0]/40 text-[#554336] rounded-2xl px-4 py-3 flex items-center gap-2 font-[Manrope] font-bold text-sm hover:bg-[#F4F4F3] transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kelola Buku Kas Utama
            </a>
            @endauth

            {{-- Form Filter Bulan & Tahun --}}
            <form action="{{ route('laporan.index') }}" method="GET" class="flex items-center gap-2 bg-white border border-[#DBC2B0]/30 rounded-2xl px-3 py-1.5 shadow-sm m-0">
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

            <button onclick="window.print()" class="bg-[#1A1C1C] text-white rounded-2xl px-6 py-3 flex items-center gap-2 font-[Manrope] font-bold text-sm hover:bg-black transition-all shadow-sm">
                <i data-lucide="printer" class="w-4 h-4"></i>
                Cetak / Cetak PDF
            </button>
        </div>
    </div>

    {{-- KOP SURAT FORMAL (Hanya Aktif Saat Dicetak) --}}
    <div class="w-full hidden print:block text-center border-b-4 border-[#1A1C1C] pb-4 mb-2">
        <h2 class="font-[Manrope] font-black text-2xl uppercase tracking-wider text-[#1A1C1C]">LAPORAN BULANAN MUTASI KAS MASJID</h2>
        <p class="font-[Manrope] text-xs text-[#554336]">Sistem Akuntabilitas & Transparansi Keuangan Jamaah</p>
        <p class="font-[Inter] font-bold text-xs uppercase text-[#8D4B00] mt-2 tracking-widest">
            PERIODE MUTASI: {{ Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}
        </p>
    </div>

    {{-- Summary Cards Section --}}
    <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-[24px] print-grid-3">
        <div class="bg-white rounded-[40px] p-8 border border-[#DBC2B0]/10 shadow-sm relative overflow-hidden">
            <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364] mb-4">Total Pemasukan</p>
            <h3 class="font-[Manrope] font-black text-[32px] text-[#1A1C1C]">Rp {{ number_format($totalMasuk ?? 0, 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center gap-2">
                <span class="bg-[#D8E7D2] text-[#526050] text-[10px] font-black px-2 py-1 rounded-lg">Bulan Ini</span>
            </div>
        </div>

        <div class="bg-white rounded-[40px] p-8 border border-[#DBC2B0]/10 shadow-sm relative overflow-hidden">
            <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364] mb-4">Total Pengeluaran</p>
            <h3 class="font-[Manrope] font-black text-[32px] text-[#1A1C1C]">Rp {{ number_format($totalKeluar ?? 0, 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center gap-2">
                <span class="bg-[#FFDAD6] text-[#BA1A1A] text-[10px] font-black px-2 py-1 rounded-lg">Alokasi Kas</span>
            </div>
        </div>

        <div class="bg-[#8D4B00] rounded-[40px] p-8 shadow-xl relative overflow-hidden">
            <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-white/60 mb-4">Saldo Akhir Periode</p>
            <h3 class="font-[Manrope] font-black text-[32px] text-white">Rp {{ number_format($saldoAkhir ?? 0, 0, ',', '.') }}</h3>
            <div class="mt-6 pt-4 border-t border-white/10 flex justify-between items-center text-[10px] font-bold text-white/80">
                <span>Sisa Awal Bulan: Rp {{ number_format($saldoAwal ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Catatan & Rasio Berjejer --}}
    <div class="w-full grid grid-cols-1 md:grid-cols-[1fr_380px] gap-[48px] items-stretch print-grid-split">
        <div class="bg-white rounded-[48px] p-10 border border-[#DBC2B0]/10 shadow-sm flex flex-col justify-between">
            <div>
                <h4 class="font-[Manrope] font-black text-xl text-[#1A1C1C] mb-4">Catatan Laporan Mutasi</h4>
                <p class="font-[Manrope] text-sm text-[#554336] leading-relaxed mb-6">
                    Seluruh rincian transaksi kas masuk dan keluar di bawah ini merupakan ringkasan transaksi resmi yang telah diverifikasi oleh Bendahara Masjid secara berkala pada bulan <strong>{{ Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') }}</strong>.
                </p>
            </div>
            <div class="bg-[#F9F9F8] border border-[#DBC2B0]/20 p-6 rounded-2xl text-xs text-[#1A1C1C] font-bold">
                Sistem Terverifikasi DKM Al-Bayan
            </div>
        </div>

        <div class="bg-white rounded-[48px] p-10 border border-[#DBC2B0]/10 shadow-sm flex flex-col items-center justify-between">
            <h4 class="w-full font-[Manrope] font-black text-xl text-[#1A1C1C] mb-2">Rasio Arus Kas</h4>
            
            @php
                $safeMasuk = $totalMasuk ?? 0;
                $safeKeluar = $totalKeluar ?? 0;
                $grandTotal = $safeMasuk + $safeKeluar;
                $pctMasuk = $grandTotal > 0 ? round(($safeMasuk / $grandTotal) * 100) : 0;
            @endphp

            <div class="relative w-36 h-36 my-2 flex-shrink-0">
                <svg class="w-full h-full transform -rotate-90">
                    <circle cx="72" cy="72" r="56" stroke="#F4F4F3" stroke-width="14" fill="transparent" />
                    <circle cx="72" cy="72" r="56" stroke="#8D4B00" stroke-width="14" fill="transparent" 
                            stroke-dasharray="351.8" stroke-dashoffset="{{ $grandTotal > 0 ? (351.8 - (351.8 * ($pctMasuk / 100))) : 351.8 }}" stroke-linecap="round" />
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="font-[Manrope] font-black text-2xl text-[#1A1C1C]">{{ $pctMasuk }}%</span>
                    <span class="text-[8px] font-black text-[#887364] tracking-widest">MASUK</span>
                </div>
            </div>
            
            <div class="w-full space-y-1 text-xs mt-2">
                <div class="flex justify-between">
                    <span class="text-[#554336]">Pemasukan:</span>
                    <span class="font-black text-[#1A1C1C]">Rp {{ number_format($safeMasuk, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[#554336]">Pengeluaran:</span>
                    <span class="font-black text-[#1A1C1C]">Rp {{ number_format($safeKeluar, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="w-full bg-white rounded-[48px] p-10 border border-[#DBC2B0]/10 shadow-sm">
        <h4 class="font-[Manrope] font-black text-xl text-[#1A1C1C] mb-6 no-print">Rincian Buku Kas Transaksi</h4>
        <table class="w-full">
            <thead class="border-b border-[#F4F4F3]">
                <tr class="font-[Inter] text-[10px] font-black uppercase tracking-wider text-[#DBC2B0] text-left">
                    <th class="pb-4">Tanggal</th>
                    <th class="pb-4">Kategori</th>
                    <th class="pb-4">Keterangan</th>
                    <th class="pb-4 text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#F4F4F3]">
                @forelse($transactions ?? [] as $t)
                @php $isIncome = strtoupper($t->type) === 'INCOME'; @endphp
                <tr class="font-[Manrope] text-sm">
                    <td class="py-4 font-bold text-[#1A1C1C]">{{ \Carbon\Carbon::parse($t->date)->translatedFormat('d M Y') }}</td>
                    <td class="py-4">
                        <span class="text-[9px] font-black px-2 py-1 rounded uppercase {{ $isIncome ? 'bg-[#FFDCC3] text-[#8D4B00]' : 'bg-[#F4F4F3] text-[#554336]' }}">
                            {{ $t->category->name ?? $t->category ?? 'Umum' }}
                        </span>
                    </td>
                    <td class="py-4 text-[#554336] max-w-[280px] truncate">{{ $t->description ?? $t->title }}</td>
                    <td class="py-4 text-right font-black {{ $isIncome ? 'text-[#8D4B00]' : 'text-[#BA1A1A]' }}">
                        {{ $isIncome ? '+' : '-' }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-12 text-center italic text-[#887364]">Belum ada riwayat mutasi keuangan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- AREA TANDA TANGAN (Hanya Tampil Saat Print) --}}
        <div class="hidden print:grid grid-cols-2 text-center text-xs font-bold text-[#1A1C1C] pt-12 mt-12 border-t border-dashed border-[#1A1C1C]">
            <div>
                <p>Mengetahui,</p>
                <p class="mb-20">Ketua DKM Masjid</p>
                <p>( _______________________ )</p>
            </div>
            <div>
                <p>Dibuat Oleh,</p>
                <p class="mb-20">Bendahara Masjid</p>
                <p>( {{ Auth::check() ? Auth::user()->name : 'Pengurus DKM' }} )</p>
            </div>
        </div>
    </div>
</div>
@endsection