@extends('layouts.app')

@section('content')
{{-- Main Content Canvas --}}
<div class="flex flex-col items-start p-[48px] gap-[48px] w-full max-w-[1280px] min-h-screen mx-auto bg-[#F9F9F8]">

    {{-- Breadcrumb & Header --}}
    <div class="w-full flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
        <div class="space-y-2">
            <p class="font-[Inter] font-bold text-[10px] tracking-[0.2em] uppercase text-[#887364]">
                UTAMA / <span class="text-[#8D4B00]">AGENDA KEGIATAN</span>
            </p>
            <h1 class="font-[Manrope] font-black text-[48px] leading-tight tracking-[-0.04em] text-[#1A1C1C]">
                Kegiatan & Program
            </h1>
        </div>
        
        {{-- Action Button & Mini Stat Tracker --}}
        <div class="flex flex-wrap items-center gap-4 w-full sm:w-auto justify-end">
            {{-- Tombol Tambah Agenda Operasional Admin --}}
            <a href="{{ route('activities.create') }}" class="no-print bg-[#1A1C1C] text-white rounded-2xl px-6 py-3.5 flex items-center gap-2 font-[Manrope] font-bold text-sm hover:bg-black transition-all shadow-sm">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Tambah Agenda
            </a>

            {{-- Mini Stat Tracker --}}
            <div class="flex items-center gap-4 bg-white border border-[#DBC2B0]/30 rounded-3xl p-4 shadow-sm font-[Manrope]">
                <div class="px-4 border-r border-[#DBC2B0]/30 text-center">
                    <span class="text-[10px] font-black text-[#887364] uppercase block">Akan Datang</span>
                    <span class="font-black text-xl text-[#8D4B00]">{{ $totalUpcoming }}</span>
                </div>
                <div class="px-4 border-r border-[#DBC2B0]/30 text-center">
                    <span class="text-[10px] font-black text-[#887364] uppercase block">Selesai</span>
                    <span class="font-black text-xl text-[#1A1C1C]">{{ $totalCompleted }}</span>
                </div>
                <div class="px-4 text-center">
                    <span class="text-[10px] font-black text-[#887364] uppercase block">Alokasi Dana Aktif</span>
                    <span class="font-black text-sm text-green-600">Rp {{ number_format($totalBudgetAllocated, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Success Notification --}}
    @if(session('success'))
        <div class="w-full bg-green-50 border border-green-200 text-green-800 rounded-2xl p-4 font-[Manrope] text-sm font-bold flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Grid Card Kegiatan --}}
    <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[24px]">
        @forelse($activities as $act)
            <div class="bg-white rounded-[40px] p-8 border border-[#DBC2B0]/10 shadow-sm flex flex-col justify-between relative group hover:shadow-md transition-all duration-300">
                
                <div>
                    {{-- Badge Status & Sumber Dana --}}
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-[9px] font-black px-3 py-1.5 rounded-lg uppercase tracking-wider
                            {{ $act->status == 'UPCOMING' ? 'bg-[#FFDCC3] text-[#8D4B00]' : '' }}
                            {{ $act->status == 'ONGOING' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $act->status == 'COMPLETED' ? 'bg-[#F4F4F3] text-[#554336]' : '' }}">
                            ● {{ $act->status }}
                        </span>
                        <span class="text-[10px] font-bold text-[#887364] bg-[#F9F9F8] px-3 py-1 rounded-full border border-[#DBC2B0]/20">
                            💰 {{ $act->funding_source }}
                        </span>
                    </div>

                    {{-- Title & Deskripsi --}}
                    <h3 class="font-[Manrope] font-black text-xl text-[#1A1C1C] line-clamp-2 group-hover:text-[#8D4B00] transition-colors mb-3">
                        {{ $act->title }}
                    </h3>
                    <p class="font-[Manrope] text-sm text-[#554336] leading-relaxed line-clamp-3 mb-6">
                        {{ $act->description ?? 'Tidak ada deskripsi tambahan untuk program ini.' }}
                    </p>
                </div>

                <div>
                    {{-- Detail Waktu, Tempat, dan Anggaran --}}
                    <div class="pt-6 border-t border-[#F4F4F3] space-y-3 font-[Manrope] text-xs font-bold text-[#554336]">
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="calendar" class="w-4 h-4 text-[#8D4B00]"></i>
                            <span>{{ \Carbon\Carbon::parse($act->date)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="clock" class="w-4 h-4 text-[#8D4B00]"></i>
                            <span>{{ \Carbon\Carbon::parse($act->time)->format('H:i') }} WIB</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-[#8D4B00]"></i>
                            <span class="truncate">{{ $act->location }}</span>
                        </div>
                        <div class="pt-3 flex justify-between items-center text-sm border-t border-dashed border-[#F4F4F3]">
                            <span class="text-[#887364] text-xs">Anggaran Kegiatan:</span>
                            <span class="font-black text-[#1A1C1C]">Rp {{ number_format($act->budget, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    {{-- Tombol Edit & Delete Manajemen Operasional Admin --}}
                    <div class="mt-4 pt-4 border-t border-[#F4F4F3] flex items-center justify-end gap-2 no-print">
                        <a href="{{ route('activities.edit', $act->id) }}" class="p-2 text-[#554336] bg-[#F4F4F3] hover:bg-[#DBC2B0]/20 rounded-xl transition-all" title="Edit Agenda">
                            <i data-lucide="edit-3" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('activities.destroy', $act->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus agenda kegiatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-all" title="Hapus Agenda">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white rounded-[48px] p-16 border border-[#DBC2B0]/10 shadow-sm text-center">
                <div class="w-16 h-16 bg-[#F9F9F8] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="calendar-x" class="w-8 h-8 text-[#887364]"></i>
                </div>
                <h4 class="font-[Manrope] font-black text-lg text-[#1A1C1C] mb-1">Belum Ada Agenda Terjadwal</h4>
                <p class="font-[Manrope] text-sm text-[#887364]">Pengurus DKM belum menginput jadwal kegiatan dalam waktu dekat.</p>
            </div>
        @endforelse
    </div>

</div>

<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endsection