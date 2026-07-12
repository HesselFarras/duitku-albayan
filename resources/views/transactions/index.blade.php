@extends('layouts.app')

@section('content')
<div class="flex flex-col items-start p-[48px] gap-[48px] w-full max-w-[1280px] min-h-screen mx-auto bg-[#F9F9F8]">

    {{-- Header --}}
    <div class="w-full flex justify-between items-start">
        <div class="max-w-2xl">
            <h1 class="font-[Manrope] font-black text-[48px] leading-tight tracking-[-0.04em] text-[#1A1C1C] mb-2">Manajemen Transaksi</h1>
            <p class="font-[Manrope] text-lg text-[#554336]">Kelola arus kas masuk dan keluar dengan transparansi penuh.</p>
        </div>
        {{-- TOMBOL AKSES MUTASI INTERNAL BARU --}}
        <a href="{{ route('transaksi.mutasi.create') }}" class="flex items-center gap-2 bg-[#1A1C1C] hover:bg-[#8D4B00] text-white font-[Manrope] font-bold text-sm rounded-full px-5 py-3 shadow transition-all">
            🔄 Mutasi Internal Kas
        </a>
    </div>

    @if(session('success'))
        <div class="w-full p-4 bg-green-100 text-green-700 rounded-2xl font-bold border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="w-full grid grid-cols-[380px_1fr] gap-[48px] items-start">
        
        {{-- 1. FORM INPUT (KIRI) --}}
        <div class="bg-white rounded-[48px] p-10 shadow-sm border border-[#DBC2B0]/10 sticky top-28">
            <h3 id="form-title" class="font-[Manrope] font-black text-xl text-[#1A1C1C] mb-8">Catat Transaksi</h3>

            <form action="{{ route('transaksi.store') }}" method="POST" class="flex flex-col gap-6">
                @csrf
                <input type="hidden" name="type" id="transaction_type" value="income">

                <div class="grid grid-cols-2 gap-2 bg-[#F4F4F3] p-1.5 rounded-[32px]">
                    <button type="button" id="btn-income" onclick="switchType('income')" class="py-3 rounded-[28px] transition-all font-black text-[10px] uppercase">Pemasukan</button>
                    <button type="button" id="btn-expense" onclick="switchType('expense')" class="py-3 rounded-[28px] transition-all font-black text-[10px] uppercase">Pengeluaran</button>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#887364]">Judul Transaksi</label>
                    <input type="text" name="title" required class="w-full bg-[#F9F9F8] border-none rounded-[24px] py-4 px-6 font-bold focus:ring-2 focus:ring-[#8D4B00]" placeholder="Nama Transaksi">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#887364]">Nominal (IDR)</label>
                    <input type="number" name="amount" required class="w-full bg-[#F9F9F8] border-none rounded-[24px] py-4 px-6 font-black text-xl" placeholder="0">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#887364]">Kategori</label>
                    <div class="relative">
                        <select name="category" id="category-select" 
                            class="w-full bg-[#F9F9F8] border-none rounded-[24px] py-4 px-6 font-bold appearance-none cursor-pointer focus:ring-2 focus:ring-[#8D4B00] transition-all">
                            {{-- Option akan diisi oleh JavaScript --}}
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-[#887364]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- NEW: DROPDOWN KANTONG KAS DENGAN VISUAL MEWAH BAWAAN LU --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#887364]">Kantong Kas</label>
                    <div class="relative">
                        <select name="wallet_id" required 
                            class="w-full bg-[#F9F9F8] border-none rounded-[24px] py-4 px-6 font-bold appearance-none cursor-pointer focus:ring-2 focus:ring-[#8D4B00] transition-all">
                            <option value="" disabled selected>Pilih Kantong Kas...</option>
                            @foreach($wallets as $w)
                                <option value="{{ $w->id }}">
                                    {{ $w->slug == 'cash' ? '💵' : '🏦' }} {{ $w->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-[#887364]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#887364]">Tanggal</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full bg-[#F9F9F8] border-none rounded-[24px] py-4 px-6 font-bold">
                </div>

                <button type="submit" id="submit-btn" class="w-full py-5 rounded-[24px] text-white font-black text-lg transition-all mt-4 shadow-lg hover:scale-[1.02] active:scale-95">
                    Simpan Transaksi
                </button>
            </form>
        </div>

        <div class="flex flex-col gap-4">
            
            {{-- Filter Tipe & Kategori Dinamis --}}
            <div class="bg-white p-8 rounded-[40px] border border-[#DBC2B0]/10 shadow-sm space-y-6">
                {{-- Pilih Tipe --}}
                <div class="flex items-center gap-4">
                    <span class="text-[10px] font-black uppercase text-[#887364] w-20">Tipe</span>
                    <div class="flex gap-2">
                        <a href="{{ route('transaksi.index') }}" 
                           class="px-5 py-2 rounded-full font-bold text-xs transition-all {{ !request('type') ? 'bg-[#1A1C1C] text-white shadow-lg' : 'bg-[#F4F4F3] text-[#887364]' }}">
                            Semua
                        </a>
                        <a href="{{ route('transaksi.index', ['type' => 'income']) }}" 
                           class="px-5 py-2 rounded-full font-bold text-xs transition-all {{ request('type') == 'income' ? 'bg-[#8D4B00] text-white shadow-lg' : 'bg-[#F4F4F3] text-[#8D4B00]' }}">
                            Pemasukan
                        </a>
                        <a href="{{ route('transaksi.index', ['type' => 'expense']) }}" 
                           class="px-5 py-2 rounded-full font-bold text-xs transition-all {{ request('type') == 'expense' ? 'bg-[#BA1A1A] text-white shadow-lg' : 'bg-[#F4F4F3] text-[#BA1A1A]' }}">
                            Pengeluaran
                        </a>
                    </div>
                </div>

                {{-- Pilih Kategori --}}
                <div class="flex items-start gap-4">
                    <span class="text-[10px] font-black uppercase text-[#887364] w-20 mt-2">Kategori</span>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $activeType = request('type');
                            $displayCats = collect();
                            if(!$activeType || $activeType == 'income') $displayCats = $displayCats->merge($incomeCategories);
                            if(!$activeType || $activeType == 'expense') $displayCats = $displayCats->merge($expenseCategories);
                            $displayCats = $displayCats->unique();
                        @endphp

                        @forelse($displayCats as $catName)
                            <a href="{{ route('transaksi.index', ['type' => request('type'), 'category' => $catName]) }}" 
                               class="px-4 py-2 rounded-xl font-bold text-[11px] uppercase transition-all {{ request('category') == $catName ? 'bg-[#8D4B00] text-white' : 'bg-white border border-[#DBC2B0]/30 text-[#887364] hover:border-[#8D4B00]' }}">
                                {{ $catName }}
                            </a>
                        @empty
                            <span class="text-xs italic text-[#887364] mt-1">Belum ada kategori untuk tipe ini.</span>
                        @endforelse
                    </div>
                </div>

                @if(request('type') || request('category'))
                <div class="pt-2">
                    <a href="{{ route('transaksi.index') }}" class="text-[10px] font-black text-[#8D4B00] uppercase underline decoration-2 underline-offset-4">
                        ✕ Bersihkan Semua Filter
                    </a>
                </div>
                @endif
            </div>

            <h3 class="font-[Manrope] font-black text-xl text-[#1A1C1C] mt-4 mb-2">
                @if(request('category'))
                    Menampilkan: {{ request('category') }}
                @elseif(request('type'))
                    Semua {{ request('type') == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                @else
                    Riwayat Transaksi
                @endif
            </h3>
            
            @forelse($transactions as $t)
            <div class="bg-white rounded-[40px] p-6 flex items-center justify-between border border-[#DBC2B0]/5 shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 rounded-[20px] flex items-center justify-center {{ $t->type == 'income' ? 'bg-[#F0F5ED] text-[#526050]' : 'bg-[#FFF0F0] text-[#BA1A1A]' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $t->type == 'income' ? 'M7 11l5-5m0 0l5 5m-5-5v12' : 'M17 13l-5 5m0 0l-5-5m5 5V6' }}"/>
                        </svg>
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="font-black text-lg text-[#1A1C1C]">{{ $t->title }}</h4>
                            <span class="text-[9px] font-black px-2 py-0.5 rounded bg-[#F4F4F3] text-[#887364]">{{ $t->badge }}</span>
                            {{-- NEW: Badge penanda kantong kas di daftar riwayat --}}
                            <span class="text-[9px] font-extrabold px-2 py-0.5 rounded {{ $t->wallet && $t->wallet->slug == 'cash' ? 'bg-[#FFDCC3] text-[#8D4B00]' : 'bg-[#D8E7D2] text-[#526050]' }} uppercase">
                                {{ $t->wallet ? $t->wallet->name : 'Unassigned' }}
                            </span>
                        </div>
                        <p class="text-sm text-[#887364]">{{ $t->date->format('d M Y') }} • <span class="font-bold">{{ $t->category }}</span></p>
                    </div>
                </div>

                <div class="flex items-center gap-8">
                    <div class="text-right">
                        <p class="font-black text-xl {{ $t->type == 'income' ? 'text-[#1A1C1C]' : 'text-[#BA1A1A]' }}">
                            {{ $t->type == 'income' ? '+' : '-' }}Rp {{ number_format($t->amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('transaksi.edit', $t->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>

                        <form action="{{ route('transaksi.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-20 text-center bg-white rounded-[48px] border border-dashed border-[#DBC2B0]">
                <p class="text-[#887364] font-medium italic">Tidak ada transaksi ditemukan untuk kategori ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    const categories = {
        income: ['Infaq', 'Zakat', 'Sadaqah', 'Wakaf', 'Hibah', 'Lainnya'],
        expense: ['Listrik & Air', 'Kebersihan', 'Honor Marbot', 'Perbaikan Gedung', 'Kegiatan Ramadhan', 'Lainnya']
    };

    function switchType(type) {
        const btnIncome = document.getElementById('btn-income');
        const btnExpense = document.getElementById('btn-expense');
        const hiddenInput = document.getElementById('transaction_type');
        const submitBtn = document.getElementById('submit-btn');
        const select = document.getElementById('category-select');

        hiddenInput.value = type;

        if (type === 'income') {
            btnIncome.className = "py-3 rounded-[28px] transition-all font-black text-[10px] uppercase bg-white shadow-sm text-[#8D4B00] border border-[#DBC2B0]";
            btnExpense.className = "py-3 rounded-[28px] transition-all font-black text-[10px] uppercase text-[#887364]";
            submitBtn.className = "w-full bg-[#8D4B00] py-5 rounded-[24px] text-white font-black text-lg mt-4 shadow-lg hover:scale-[1.02] active:scale-95";
            submitBtn.innerText = "Simpan Pemasukan";
        } else {
            btnExpense.className = "py-3 rounded-[28px] transition-all font-black text-[10px] uppercase bg-white shadow-sm text-[#BA1A1A] border border-[#BA1A1A]/30";
            btnIncome.className = "py-3 rounded-[28px] transition-all font-black text-[10px] uppercase text-[#887364]";
            submitBtn.className = "w-full bg-[#BA1A1A] py-5 rounded-[24px] text-white font-black text-lg mt-4 shadow-lg hover:scale-[1.02] active:scale-95";
            submitBtn.innerText = "Simpan Pengeluaran";
        }

        select.innerHTML = '';
        categories[type].forEach(cat => {
            let opt = document.createElement('option');
            opt.value = cat; 
            opt.text = cat;
            select.appendChild(opt);
        });
    }

    window.onload = () => switchType('income');
</script>
@endsection