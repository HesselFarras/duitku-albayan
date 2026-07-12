@extends('layouts.app')

@section('content')
<div class="flex flex-col items-start p-[48px] gap-[48px] w-full max-w-[1280px] min-h-screen mx-auto bg-[#F9F9F8]">
    
    {{-- Header --}}
    <div class="w-full flex justify-between items-end">
        <div class="space-y-2">
            <p class="font-[Inter] font-bold text-[10px] tracking-[0.2em] uppercase text-[#887364]">
                OPERASIONAL / <span class="text-[#8D4B00]">AI INSIGHT</span>
            </p>
            <h1 class="font-[Manrope] font-black text-[48px] leading-tight tracking-[-0.04em] text-[#1A1C1C]">
                Analisis Kas Asisten AI
            </h1>
        </div>

        {{-- Filter Bulan & Tahun --}}
        <form action="{{ route('ai.index') }}" method="GET" class="flex items-center gap-2 bg-white border border-[#DBC2B0]/30 rounded-2xl px-3 py-1.5 shadow-sm m-0">
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
    </div>

    {{-- Main Container Spark AI --}}
    <div class="w-full grid grid-cols-1 md:grid-cols-[380px_1fr] gap-[48px] items-stretch">
        
        {{-- Sisi Kiri: Rekap Angka Kas --}}
        <div class="flex flex-col gap-6">
            <div class="bg-white border border-[#DBC2B0]/10 rounded-[40px] p-8 shadow-sm">
                <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364] mb-2">Status Kesehatan Kas</p>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold uppercase {{ $insights['color'] }}">
                    {{ $insights['status'] }}
                </span>
                <hr class="my-6 border-[#F4F4F3]">
                
                <div class="space-y-4 text-sm font-[Manrope]">
                    <div class="flex justify-between">
                        <span class="text-[#554336]">Pemasukan:</span>
                        <span class="font-black text-[#1A1C1C]">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[#554336]">Pengeluaran:</span>
                        <span class="font-black text-[#BA1A1A]">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-dashed border-[#F4F4F3]">
                        <span class="text-[#1A1C1C] font-bold">Sisa Saldo:</span>
                        <span class="font-black text-[#8D4B00]">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#1A1C1C] rounded-[40px] p-8 text-white relative overflow-hidden">
                <div class="absolute right-[-20px] bottom-[-20px] opacity-10">
                    <i data-lucide="brain-circuit" class="w-40 h-40 text-white"></i>
                </div>
                <p class="font-[Inter] text-[10px] font-black uppercase tracking-widest text-white/60 mb-2">Titik Beban Utama</p>
                <h4 class="font-[Manrope] font-black text-xl text-white truncate">{{ strtoupper($kategoriTerbesar) }}</h4>
                <p class="font-[Manrope] text-xs text-white/70 mt-2 leading-relaxed">
                    Kategori di atas mengonsumsi porsi dana keluar paling dominan pada periode yang sedang aktif dipilih.
                </p>
            </div>
        </div>

        {{-- Sisi Kanan: Output Kotak Analisis AI --}}
        <div class="bg-white border border-[#DBC2B0]/10 rounded-[48px] p-10 shadow-sm flex flex-col justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 text-[#8D4B00]/10">
                <i data-lucide="sparkles" class="w-24 h-24"></i>
            </div>

            <div class="space-y-8 relative z-10">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-3">
                        <div class="bg-[#8D4B00]/10 p-3 rounded-2xl">
                            <i data-lucide="cpu" class="w-6 h-6 text-[#8D4B00]"></i>
                        </div>
                        <div>
                            <h3 class="font-[Manrope] font-black text-2xl text-[#1A1C1C]">Rangkuman Cerdas Sistem</h3>
                            <p class="font-[Inter] text-[10px] text-[#887364] uppercase font-bold tracking-wider">Hasil Autogenerate Berbasis Algoritma Keuangan</p>
                        </div>
                    </div>

                    {{-- DYNAMIC HEALTH SCORE BADGE --}}
                    @if(isset($insights['score']))
                    <div class="flex items-center space-x-2 bg-[#8D4B00]/5 px-3 py-1.5 rounded-full border border-[#DBC2B0]/30">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#8D4B00] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#8D4B00]"></span>
                        </span>
                        <span class="text-xs font-[Inter] font-black text-[#8D4B00]">Score: {{ $insights['score'] }}/100</span>
                    </div>
                    @endif
                </div>

                {{-- Blok Kesimpulan --}}
                <div class="space-y-3">
                    <h5 class="font-[Manrope] font-extrabold text-sm text-[#1A1C1C] flex items-center gap-2">
                        <i data-lucide="activity" class="w-4 h-4 text-[#8D4B00]"></i> Kondisi Arus Kas
                    </h5>
                    <p class="font-[Manrope] text-sm text-[#554336] leading-relaxed bg-[#F9F9F8] p-5 rounded-2xl border border-[#DBC2B0]/20">
                        {{ $insights['kesimpulan'] }}
                    </p>
                </div>

                {{-- Blok Rekomendasi --}}
                <div class="space-y-3">
                    <h5 class="font-[Manrope] font-extrabold text-sm text-[#1A1C1C] flex items-center gap-2">
                        <i data-lucide="lightbulb" class="w-4 h-4 text-[#8D4B00]"></i> Saran Strategis Organisasi
                    </h5>
                    <p class="font-[Manrope] text-sm text-[#554336] leading-relaxed border-l-4 border-[#8D4B00] pl-4 py-1">
                        {!! $insights['rekomendasi'] !!}
                    </p>
                </div>

                {{-- QUICK ACTIONS PROMPT --}}
                <div class="pt-4 border-t border-dashed border-[#F4F4F3]">
                    <p class="font-[Inter] text-[10px] font-bold text-[#887364] uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <i data-lucide="message-square-plus" class="w-3.5 h-3.5 text-[#8D4B00]"></i> Konsultasikan lebih dalam:
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <button data-prompt="Bagaimana cara menghemat pengeluaran berdasarkan data bulan ini?" class="btn-quick-action font-[Manrope] text-xs bg-[#F9F9F8] hover:bg-[#8D4B00] hover:text-white text-[#554336] px-4 py-2.5 rounded-xl border border-[#DBC2B0]/20 transition-all duration-200 font-bold shadow-sm">
                            💡 Cara Hemat Bulan Ini?
                        </button>
                        <button data-prompt="Buatkan rancangan draf anggaran optimasi untuk bulan depan." class="btn-quick-action font-[Manrope] text-xs bg-[#F9F9F8] hover:bg-[#8D4B00] hover:text-white text-[#554336] px-4 py-2.5 rounded-xl border border-[#DBC2B0]/20 transition-all duration-200 font-bold shadow-sm">
                            📅 Draf Anggaran Bulan Depan
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-[#F4F4F3] text-[11px] text-[#887364] font-medium flex items-center gap-2">
                <i data-lucide="shield-check" class="w-4 h-4 text-[#526050]"></i>
                Analisis ini bersifat kalkulasi instan terhadap data masukan tanpa memungut biaya token API eksternal.
            </div>
        </div>

    </div>
</div>

{{-- SLIDE-OVER INTERACTIVE AI CHAT PANEL --}}
<div id="ai-chat-panel" class="fixed inset-y-0 right-0 max-w-full flex pl-10 transform translate-x-full transition-transform duration-300 ease-in-out z-50">
    <div class="w-screen max-w-md bg-white shadow-2xl flex flex-col justify-between rounded-l-[32px] border-l border-[#DBC2B0]/20">
        <div class="p-6 border-b border-[#F4F4F3] flex justify-between items-center bg-[#F9F9F8] rounded-tl-[32px]">
            <div class="flex items-center gap-3">
                <div class="bg-[#8D4B00]/10 p-2.5 rounded-xl text-[#8D4B00]">
                    <i data-lucide="bot" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="font-[Manrope] font-black text-sm text-[#1A1C1C]">Duitku AI Konsultan</h3>
                    <p class="text-[10px] text-green-600 font-bold font-[Inter] flex items-center gap-1">
                        <span class="h-1.5 w-1.5 rounded-full bg-green-500 inline-block animate-pulse"></span> Terhubung dengan Sistem
                    </p>
                </div>
            </div>
            {{-- Tombol Tutup Teks Nyata --}}
            <button id="btn-close-chat" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">
                Tutup
            </button>
        </div>

        <div id="chat-messages" class="flex-1 p-6 overflow-y-auto space-y-4 text-sm font-[Manrope]">
            <div class="flex gap-2.5">
                <div class="bg-[#F9F9F8] border border-[#DBC2B0]/10 p-4 rounded-2xl max-w-[85%] text-[#554336] leading-relaxed">
                    Halo Bendahara! Saya asisten pintar Duitku. Ada yang ingin didiskusikan lebih spesifik terkait alokasi kas organisasi bulan ini?
                </div>
            </div>
        </div>

        <div class="p-4 border-t border-[#F4F4F3] bg-white rounded-bl-[32px]">
            <div class="flex gap-2">
                <input type="text" id="chat-input" placeholder="Tanyakan analisis mendalam..." class="flex-1 bg-[#F9F9F8] border border-[#DBC2B0]/30 rounded-xl px-4 py-2.5 text-xs font-[Manrope] focus:outline-none focus:border-[#8D4B00] focus:ring-1 focus:ring-[#8D4B00]">
                <button id="btn-send-chat" class="bg-[#8D4B00] hover:bg-[#6d3a00] text-white px-4 py-2.5 rounded-xl text-xs font-bold transition-colors flex items-center gap-1.5 shadow-sm">
                    Kirim <i data-lucide="send" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- FLOATING TOGGLE CHAT BUTTON --}}
<button id="btn-floating-chat" class="fixed bottom-24 right-8 bg-[#8D4B00] hover:bg-[#6d3a00] text-white p-4 rounded-full shadow-2xl transition-all duration-300 hover:scale-110 z-40 flex items-center justify-center border border-[#DBC2B0]/20">
    <i data-lucide="bot" class="w-6 h-6"></i>
    <span class="absolute -top-1 -right-1 flex h-3 w-3">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
    </span>
</button>

<script>
    let isWaiting = false;

    document.addEventListener("DOMContentLoaded", function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();

        const chatPanel = document.getElementById('ai-chat-panel');
        const chatInput = document.getElementById('chat-input');
        const sendBtn = document.getElementById('btn-send-chat');
        const closeBtn = document.getElementById('btn-close-chat');
        const floatingBtn = document.getElementById('btn-floating-chat');

        if (chatInput) chatInput.value = '';

        // Event: Buka/Tutup lewat tombol melayang robot
        if (floatingBtn) {
            floatingBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                chatPanel.classList.toggle('translate-x-full');
            });
        }

        // Event: Tutup laci lewat tombol "Tutup" teks
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                chatPanel.classList.add('translate-x-full');
            });
        }

        // Event: Klik Rekomendasi Pintasan Finansial di tengah
        document.querySelectorAll('.btn-quick-action').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // FIX: Membuka laci dengan aman menggunakan classList
                chatPanel.classList.remove('translate-x-full');
                
                const promptText = this.getAttribute('data-prompt');
                chatInput.value = promptText;
            });
        });

        if (sendBtn) {
            sendBtn.addEventListener('click', function(e) {
                e.preventDefault();
                sendChatMessage();
            });
        }

        if (chatInput) {
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    sendChatMessage();
                }
            });
        }
    });

    function sendChatMessage() {
        if (isWaiting) return;

        const input = document.getElementById('chat-input');
        const text = input.value.trim();
        if (!text) return;

        isWaiting = true;
        const container = document.getElementById('chat-messages');

        container.innerHTML += `
            <div class="flex justify-end">
                <div class="bg-[#8D4B00] text-white p-4 rounded-2xl max-w-[85%] leading-relaxed shadow-sm">
                    ${text}
                </div>
            </div>
        `;

        input.value = '';
        container.scrollTop = container.scrollHeight;

        const loadingId = 'loading-' + Date.now();
        container.innerHTML += `
            <div class="flex gap-2.5" id="${loadingId}">
                <div class="bg-[#F9F9F8] border border-[#DBC2B0]/20 p-4 rounded-2xl max-w-[85%] text-gray-400 italic flex items-center gap-2">
                    <span class="animate-bounce">●</span><span class="animate-bounce delay-100">●</span><span class="animate-bounce delay-200">●</span> Berpikir...
                </div>
            </div>
        `;
        container.scrollTop = container.scrollHeight;

        const bulanAktif = document.querySelector('select[name="bulan"]').value;
        const tahunAktif = document.querySelector('select[name="tahun"]').value;

        fetch("{{ route('ai.chat') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                message: text,
                bulan: bulanAktif,
                tahun: tahunAktif
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            const loadEl = document.getElementById(loadingId);
            if (loadEl) loadEl.remove();

            if (data.success) {
                container.innerHTML += `
                    <div class="flex gap-2.5">
                        <div class="bg-[#F9F9F8] border border-[#DBC2B0]/10 p-4 rounded-2xl max-w-[85%] text-[#554336] leading-relaxed shadow-sm prose prose-sm">
                            ${data.reply.replace(/\n/g, '<br>')}
                        </div>
                    </div>
                `;
            } else {
                container.innerHTML += `
                    <div class="flex gap-2.5">
                        <div class="bg-red-50 border border-red-200 p-4 rounded-2xl max-w-[85%] text-red-600 font-medium">
                            ⚠️ ${data.reply}
                        </div>
                    </div>
                `;
            }
            
            isWaiting = false;
            container.scrollTop = container.scrollHeight;
            if (typeof lucide !== 'undefined') lucide.createIcons();
        })
        .catch(error => {
            const loadEl = document.getElementById(loadingId);
            if (loadEl) loadEl.remove();
            
            let displayError = error.reply ? error.reply : (error.message ? error.message : "Gagal terhubung ke server.");
            
            container.innerHTML += `
                <div class="flex gap-2.5">
                    <div class="bg-red-50 border border-red-200 p-4 rounded-2xl max-w-[85%] text-red-600 font-medium shadow-sm">
                        ❌ <strong>System Error:</strong> ${displayError}
                    </div>
                </div>
            `;
            
            isWaiting = false;
            container.scrollTop = container.scrollHeight;
            console.error("Error Detail:", error);
        });
    }
</script>
@endsection