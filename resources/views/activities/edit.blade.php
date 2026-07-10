@extends('layouts.app')

@section('content')
<div class="flex flex-col items-start p-[48px] gap-[48px] w-full max-w-[800px] min-h-screen mx-auto bg-[#F9F9F8]">
    
    <div class="w-full space-y-2">
        <p class="font-[Inter] font-bold text-[10px] tracking-[0.2em] uppercase text-[#887364]">
            MANAJEMEN / <span class="text-[#8D4B00]">EDIT DETAIL AGENDA</span>
        </p>
        <h1 class="font-[Manrope] font-black text-[36px] tracking-[-0.04em] text-[#1A1C1C]">
            Koreksi Agenda
        </h1>
    </div>

    <form action="{{ route('activities.update', $activity->id) }}" method="POST" class="w-full bg-white rounded-[40px] p-10 border border-[#DBC2B0]/10 shadow-sm space-y-6 font-[Manrope]">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label class="text-xs font-black uppercase text-[#887364] tracking-wider">Nama Agenda / Kegiatan</label>
            <input type="text" name="title" value="{{ $activity->title }}" required class="w-full rounded-xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-xs font-black uppercase text-[#887364] tracking-wider">Tanggal</label>
                <input type="date" name="date" value="{{ $activity->date }}" required class="w-full rounded-xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm">
            </div>
            <div class="space-y-2">
                <label class="text-xs font-black uppercase text-[#887364] tracking-wider">Waktu / Jam</label>
                <input type="time" name="time" value="{{ \Carbon\Carbon::parse($activity->time)->format('H:i') }}" required class="w-full rounded-xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm">
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-xs font-black uppercase text-[#887364] tracking-wider">Lokasi Pelaksanaan</label>
            <input type="text" name="location" value="{{ $activity->location }}" required class="w-full rounded-xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-xs font-black uppercase text-[#887364] tracking-wider">Sumber Alokasi Dana</label>
                <select name="funding_source" required class="w-full rounded-xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm cursor-pointer">
                    <option value="Kas Utama" {{ $activity->funding_source == 'Kas Utama' ? 'selected' : '' }}>Kas Utama Masjid</option>
                    <option value="Zakat" {{ $activity->funding_source == 'Zakat' ? 'selected' : '' }}>Dana Zakat Mal/Fitrah</option>
                    <option value="Infaq Terikat" {{ $activity->funding_source == 'Infaq Terikat' ? 'selected' : '' }}>Infaq Khusus / Donatur</option>
                    <option value="Dana Sosial" {{ $activity->funding_source == 'Dana Sosial' ? 'selected' : '' }}>Kas Sosial & Anak Yatim</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-black uppercase text-[#887364] tracking-wider">Anggaran Biaya (Rp)</label>
                <input type="number" name="budget" value="{{ intval($activity->budget) }}" required min="0" class="w-full rounded-xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm">
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-xs font-black uppercase text-[#887364] tracking-wider">Status Agenda</label>
            <select name="status" required class="w-full rounded-xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm cursor-pointer">
                <option value="UPCOMING" {{ $activity->status == 'UPCOMING' ? 'selected' : '' }}>UPCOMING (Akan Datang)</option>
                <option value="ONGOING" {{ $activity->status == 'ONGOING' ? 'selected' : '' }}>ONGOING (Sedang Berjalan)</option>
                <option value="COMPLETED" {{ $activity->status == 'COMPLETED' ? 'selected' : '' }}>COMPLETED (Selesai)</option>
            </select>
        </div>

        <div class="space-y-2">
            <label class="text-xs font-black uppercase text-[#887364] tracking-wider">Uraian / Deskripsi Kegiatan</label>
            <textarea name="description" rows="4" class="w-full rounded-xl border-[#DBC2B0]/40 focus:border-[#8D4B00] focus:ring-[#8D4B00] text-sm">{{ $activity->description }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('activities.index') }}" class="px-6 py-3 border border-[#DBC2B0]/60 rounded-2xl text-xs font-bold text-[#554336] hover:bg-[#F4F4F3] transition-all">Batal</a>
            <button type="submit" class="px-6 py-3 bg-[#1A1C1C] hover:bg-black text-white font-bold rounded-2xl text-xs shadow-sm transition-all">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection