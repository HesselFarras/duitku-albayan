@extends('layouts.app')

@section('content')
<div class="flex flex-col items-start p-[48px] gap-[32px] w-full max-w-[640px] mx-auto bg-[#F9F9F8] rounded-[48px] border border-[#DBC2B0]/20 shadow-[0px_24px_48px_-12px_rgba(85,67,54,0.04)] mt-12">
    
    {{-- Header Form --}}
    <div class="space-y-1 w-full">
        <p class="font-[Inter] font-bold text-[10px] tracking-[0.2em] uppercase text-[#887364]">MANAJEMEN KAS</p>
        <h1 class="font-[Manrope] font-black text-3xl tracking-[-0.04em] text-[#1A1C1C]">Tambah Transaksi</h1>
        <p class="font-[Manrope] text-xs text-[#887364]">Catat arus kas masuk atau keluar organisasi ke cloud database.</p>
    </div>

    <form method="POST" action="{{ route('transactions.store') }}" class="w-full flex flex-col gap-5 m-0">
        @csrf

        {{-- 1. Pilihan Kantong Kas (Cash / Bank) --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Kantong Kas</label>
            <div class="relative">
                <select name="wallet_id" required class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-bold text-[#1A1C1C] appearance-none focus:outline-none focus:ring-1 focus:ring-[#8D4B00] focus:border-[#8D4B00] cursor-pointer">
                    <option value="" disabled selected>-- Pilih Pos Uang --</option>
                    @foreach($wallets as $w)
                        <option value="{{ $w->id }}">
                            {{ $w->slug == 'cash' ? '💵' : '🏦' }} {{ $w->name }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#887364]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        {{-- 2. Kategori Transaksi --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Kategori</label>
            <div class="relative">
                <select name="category_id" required class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-bold text-[#1A1C1C] appearance-none focus:outline-none focus:ring-1 focus:ring-[#8D4B00] focus:border-[#8D4B00] cursor-pointer">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#887364]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        {{-- 3. Tipe Transaksi --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Tipe</label>
            <div class="relative">
                <select name="type" required class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-bold text-[#1A1C1C] appearance-none focus:outline-none focus:ring-1 focus:ring-[#8D4B00] focus:border-[#8D4B00] cursor-pointer">
                    <option value="income">🟢 Pemasukan</option>
                    <option value="expense">🔴 Pengeluaran</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#887364]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        {{-- 4. Jumlah / Nominal --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Jumlah Nominal (IDR)</label>
            <input type="number" name="amount" placeholder="0" class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-bold text-[#1A1C1C] focus:outline-none focus:ring-1 focus:ring-[#8D4B00] focus:border-[#8D4B00]" required>
        </div>

        {{-- 5. Tanggal Transaksi --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Tanggal</label>
            <input type="date" name="date" class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-bold text-[#1A1C1C] focus:outline-none focus:ring-1 focus:ring-[#8D4B00] focus:border-[#8D4B00]" required>
        </div>

        {{-- 6. Deskripsi / Catatan --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Deskripsi</label>
            <textarea name="description" placeholder="Masukkan keterangan catatan transaksi..." rows="3" class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-medium text-[#1A1C1C] focus:outline-none focus:ring-1 focus:ring-[#8D4B00] focus:border-[#8D4B00] resize-none"></textarea>
        </div>

        {{-- Tombol Submit Mewah --}}
        <button class="w-full bg-[#8D4B00] text-white font-[Manrope] font-bold text-sm rounded-2xl py-3.5 mt-2 shadow-[0px_24px_48px_-12px_rgba(141,75,0,0.2)] hover:bg-[#703c00] transition-colors duration-200">
            Simpan Transaksi Keuangan
        </button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endsection