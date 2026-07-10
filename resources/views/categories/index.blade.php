@extends('layouts.app')

@section('content')
<div class="flex flex-col items-start p-[48px] gap-[48px] w-full max-w-[1280px] min-h-screen mx-auto bg-[#F9F9F8]">

    {{-- Header --}}
    <div class="w-full flex justify-between items-start">
        <div class="max-w-2xl">
            <h1 class="font-[Manrope] font-black text-[48px] leading-tight tracking-[-0.04em] text-[#1A1C1C] mb-2">Master Kategori</h1>
            <p class="font-[Manrope] text-lg text-[#554336]">Kelola opsi kategori untuk pengelompokan pemasukan dan pengeluaran kas masjid.</p>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="w-full p-4 bg-green-100 text-green-700 rounded-2xl font-bold border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="w-full grid grid-cols-1 lg:grid-cols-[380px_1fr] gap-[48px] items-start">
        
        {{-- 1. FORM INPUT (KIRI) --}}
        <div class="bg-white rounded-[48px] p-10 shadow-sm border border-[#DBC2B0]/10 sticky top-28">
            <h3 class="font-[Manrope] font-black text-xl text-[#1A1C1C] mb-8">Tambah Kategori</h3>

            <form action="{{ route('categories.store') }}" method="POST" class="flex flex-col gap-6">
                @csrf

                {{-- Input Nama Kategori --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#887364] ml-2">Nama Kategori</label>
                    <input type="text" name="name" required 
                        class="w-full bg-[#F9F9F8] border-none rounded-[24px] py-4 px-6 font-bold focus:ring-2 focus:ring-[#8D4B00] placeholder:text-[#DBC2B0]" 
                        placeholder="Contoh: Pemeliharaan AC">
                </div>

                {{-- Input Tipe Kategori --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-[#887364] ml-2">Tipe</label>
                    <div class="relative">
                        <select name="type" required 
                            class="w-full bg-[#F9F9F8] border-none rounded-[24px] py-4 px-6 font-bold appearance-none cursor-pointer focus:ring-2 focus:ring-[#8D4B00]">
                            <option value="income">Pemasukan</option>
                            <option value="expense">Pengeluaran</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-[#887364]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#1A1C1C] hover:bg-[#8D4B00] py-5 rounded-[24px] text-white font-black text-lg transition-all mt-4 shadow-lg hover:scale-[1.02] active:scale-95">
                    Tambah Kategori
                </button>
            </form>
        </div>

        {{-- 2. DAFTAR KATEGORI (KANAN) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
            
            {{-- Kelompok Pemasukan --}}
            <div class="bg-white p-8 rounded-[40px] border border-[#DBC2B0]/10 shadow-sm flex flex-col gap-4">
                <h3 class="font-[Manrope] font-black text-lg text-[#8D4B00] mb-2 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#8D4B00]"></span>
                    Kategori Pemasukan
                </h3>
                
                <div class="flex flex-col gap-2">
                    @php $hasIncome = false; @endphp
                    @foreach($categories as $c)
                        @if($c->type == 'income')
                            @php $hasIncome = true; @endphp
                            <div class="flex justify-between items-center bg-[#F9F9F8] rounded-[20px] py-4 px-6 border border-[#DBC2B0]/5 group">
                                <span class="font-bold text-[#1A1C1C]">{{ $c->name }}</span>
                                
                                {{-- Tombol Delete --}}
                                <form action="{{ route('categories.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="opacity-0 group-hover:opacity-100 transition-opacity text-red-500 hover:text-red-700 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endforeach

                    @if(!$hasIncome)
                        <p class="text-sm italic text-[#887364] text-center py-8">Belum ada kategori pemasukan.</p>
                    @endif
                </div>
            </div>

            {{-- Kelompok Pengeluaran --}}
            <div class="bg-white p-8 rounded-[40px] border border-[#DBC2B0]/10 shadow-sm flex flex-col gap-4">
                <h3 class="font-[Manrope] font-black text-lg text-[#BA1A1A] mb-2 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#BA1A1A]"></span>
                    Kategori Pengeluaran
                </h3>
                
                <div class="flex flex-col gap-2">
                    @php $hasExpense = false; @endphp
                    @foreach($categories as $c)
                        @if($c->type == 'expense')
                            @php $hasExpense = true; @endphp
                            <div class="flex justify-between items-center bg-[#F9F9F8] rounded-[20px] py-4 px-6 border border-[#DBC2B0]/5 group">
                                <span class="font-bold text-[#1A1C1C]">{{ $c->name }}</span>
                                
                                {{-- Tombol Delete --}}
                                <form action="{{ route('categories.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="opacity-0 group-hover:opacity-100 transition-opacity text-red-500 hover:text-red-700 p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endforeach

                    @if(!$hasExpense)
                        <p class="text-sm italic text-[#887364] text-center py-8">Belum ada kategori pengeluaran.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection