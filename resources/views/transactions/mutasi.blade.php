@extends('layouts.app')

@section('content')
<div class="flex flex-col items-start p-[48px] gap-[32px] w-full max-w-[640px] mx-auto bg-[#F9F9F8] rounded-[48px] border border-[#DBC2B0]/20 shadow-[0px_24px_48px_-12px_rgba(85,67,54,0.04)] mt-12">
    
    {{-- Header Form --}}
    <div class="space-y-1 w-full">
        <p class="font-[Inter] font-bold text-[10px] tracking-[0.2em] uppercase text-[#8D4B00]">INTERNAL MUTASI</p>
        <h1 class="font-[Manrope] font-black text-3xl tracking-[-0.04em] text-[#1A1C1C]">Mutasi Antar Kantong</h1>
        <p class="font-[Manrope] text-xs text-[#887364]">Pindahkan saldo internal organisasi (Setor Tunai / Tarik Tunai ATM) secara riil.</p>
    </div>

    @if($errors->any())
        <div class="w-full p-4 bg-red-100 text-red-700 rounded-2xl font-bold text-xs list-none">
            @foreach($errors->all() as $error)
                <li>⚠️ {{ $error }}</li>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('transaksi.mutasi.store') }}" class="w-full flex flex-col gap-5 m-0">
        @csrf

        {{-- 1. Kantong Sumber Dana --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Dari Kantong Kas (Asal)</label>
            <div class="relative">
                <select name="from_wallet_id" required class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-bold text-[#1A1C1C] appearance-none focus:outline-none focus:ring-1 focus:ring-[#8D4B00] cursor-pointer">
                    <option value="" disabled selected>-- Pilih Asal Dana --</option>
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

        {{-- 2. Kantong Tujuan Dana --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Ke Kantong Kas (Tujuan)</label>
            <div class="relative">
                <select name="to_wallet_id" required class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-bold text-[#1A1C1C] appearance-none focus:outline-none focus:ring-1 focus:ring-[#8D4B00] cursor-pointer">
                    <option value="" disabled selected>-- Pilih Tujuan Dana --</option>
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

        {{-- 3. Nominal Mutasi --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Nominal Dana Terpindah (IDR)</label>
            <input type="number" name="amount" placeholder="0" class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-bold text-[#1A1C1C] focus:outline-none focus:ring-1 focus:ring-[#8D4B00]" required>
        </div>

        {{-- 4. Tanggal Eksekusi --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Tanggal Operasional</label>
            <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-bold text-[#1A1C1C] focus:outline-none focus:ring-1 focus:ring-[#8D4B00]" required>
        </div>

        {{-- 5. Keterangan Opsional --}}
        <div class="flex flex-col gap-2">
            <label class="font-[Inter] text-[10px] font-bold text-[#887364] tracking-[0.1em] uppercase">Keterangan Tambahan (Opsional)</label>
            <textarea name="description" placeholder="Contoh: Setor tunai infaq jumat ke bank Mandiri..." rows="2" class="w-full bg-white border border-[#DBC2B0]/30 rounded-2xl px-5 py-3 text-sm font-[Manrope] font-medium text-[#1A1C1C] focus:outline-none focus:ring-1 focus:ring-[#8D4B00] resize-none"></textarea>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-3 mt-2">
            <a href="{{ route('transaksi.index') }}" class="w-1/3 text-center bg-[#F4F4F3] text-[#554336] font-[Manrope] font-bold text-sm rounded-2xl py-3.5 border border-[#DBC2B0]/20 hover:bg-[#ede9e4] transition-colors">
                Batal
            </a>
            <button type="submit" class="w-2/3 bg-[#8D4B00] text-white font-[Manrope] font-bold text-sm rounded-2xl py-3.5 shadow-[0px_24px_48px_-12px_rgba(141,75,0,0.2)] hover:bg-[#703c00] transition-colors duration-200">
                Eksekusi Perpindahan Kas
            </button>
        </div>
    </form>
</div>
@endsection