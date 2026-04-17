@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-10 rounded-[48px] shadow-sm">
    <h2 class="font-[Manrope] font-black text-2xl mb-8 text-[#1A1C1C]">Edit Transaksi</h2>

    <form action="{{ route('transaksi.update', $transaction->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nama Transaksi --}}
        <div>
            <label class="block font-[Manrope] text-[10px] font-black uppercase text-[#887364] mb-2 ml-2">Nama Transaksi</label>
            <input type="text" name="title" value="{{ old('title', $transaction->title) }}" required 
                class="w-full rounded-2xl border-[#EAE1DA] py-4 px-6 font-bold focus:border-[#8D4B00] focus:ring-[#8D4B00]">
        </div>

        <div class="grid grid-cols-2 gap-4">
            {{-- Nominal --}}
            <div>
                <label class="block font-[Manrope] text-[10px] font-black uppercase text-[#887364] mb-2 ml-2">Nominal (Rp)</label>
                <input type="number" name="amount" value="{{ old('amount', (int)$transaction->amount) }}" required 
                    class="w-full rounded-2xl border-[#EAE1DA] py-4 px-6 font-bold">
            </div>
            {{-- Tipe --}}
            <div>
                <label class="block font-[Manrope] text-[10px] font-black uppercase text-[#887364] mb-2 ml-2">Tipe</label>
                <select name="type" id="edit_type" onchange="updateEditCategories()" 
                    class="w-full rounded-2xl border-[#EAE1DA] py-4 px-6 font-bold appearance-none cursor-pointer">
                    <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
        </div>

        {{-- Kategori (PENTING: Ini yang sebelumnya hilang) --}}
        <div>
            <label class="block font-[Manrope] text-[10px] font-black uppercase text-[#887364] mb-2 ml-2">Kategori</label>
            <div class="relative">
                <select name="category" id="edit_category" 
                    class="w-full rounded-2xl border-[#EAE1DA] py-4 px-6 font-bold appearance-none cursor-pointer focus:border-[#8D4B00] focus:ring-[#8D4B00]">
                    {{-- Akan diisi oleh JS --}}
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none text-[#887364]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>

        {{-- Tanggal --}}
        <div>
            <label class="block font-[Manrope] text-[10px] font-black uppercase text-[#887364] mb-2 ml-2">Tanggal</label>
            <input type="date" name="date" value="{{ $transaction->date->format('Y-m-d') }}" required 
                class="w-full rounded-2xl border-[#EAE1DA] py-4 px-6 font-bold">
        </div>

        <div class="flex gap-4 pt-4">
            <button type="submit" class="flex-1 bg-[#8D4B00] hover:bg-[#1A1C1C] text-white py-5 rounded-[32px] font-black text-lg transition-all shadow-lg shadow-[#8D4B00]/20">
                Simpan Perubahan
            </button>
            <a href="{{ route('transaksi.index') }}" class="flex-1 bg-[#F4F4F3] text-[#554336] py-5 rounded-[32px] font-black text-lg text-center">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    const categories = {
        income: ['Infaq', 'Zakat', 'Sadaqah', 'Wakaf', 'Hibah', 'Lainnya'],
        expense: ['Listrik & Air', 'Kebersihan', 'Honor Marbot', 'Perbaikan Gedung', 'Kegiatan Ramadhan', 'Lainnya']
    };

    function updateEditCategories() {
        const type = document.getElementById('edit_type').value;
        const select = document.getElementById('edit_category');
        const currentCategory = "{{ $transaction->category }}"; // Kategori lama dari DB

        select.innerHTML = '';
        categories[type].forEach(cat => {
            let opt = document.createElement('option');
            opt.value = cat; 
            opt.text = cat;
            if(cat === currentCategory) opt.selected = true;
            select.appendChild(opt);
        });
    }

    // Jalankan saat halaman dimuat
    window.onload = updateEditCategories;
</script>
@endsection