@extends('layouts.app')

@section('content')
{{-- Main Content Canvas --}}
<div class="flex flex-col items-start p-[48px] gap-[48px] w-full max-w-[1280px] min-h-screen mx-auto bg-[#F9F9F8]">

    {{-- Header Section --}}
    <div class="w-full flex justify-between items-start">
        <div class="max-w-2xl">
            <p class="font-[Inter] font-bold text-[12px] tracking-[0.1em] uppercase text-[#8D4B00] mb-3">
                Activity Management
            </p>
            <h1 class="font-[Manrope] font-black text-[56px] leading-[1.1] tracking-[-0.04em] text-[#1A1C1C] mb-4">
                Organize with<br>Dignity & Clarity.
            </h1>
            <p class="font-[Manrope] text-lg text-[#554336] leading-relaxed">
                Oversee every congregational event, community gathering, and educational session with precise financial tracking and impact measurement.
            </p>
        </div>

        {{-- Top Stats Grid --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-[32px] p-6 shadow-sm border border-[#DBC2B0]/20 min-w-[180px]">
                <p class="font-[Inter] text-[10px] font-bold uppercase tracking-widest text-[#887364] mb-1">Total Activities</p>
                <h3 class="font-[Manrope] font-black text-3xl text-[#1A1C1C]">128</h3>
                <p class="text-[11px] text-[#526050] font-bold mt-1">↗ +12% this month</p>
            </div>
            <div class="bg-white rounded-[32px] p-6 shadow-sm border border-[#DBC2B0]/20 min-w-[180px]">
                <p class="font-[Inter] text-[10px] font-bold uppercase tracking-widest text-[#887364] mb-1">Avg. Attendance</p>
                <h3 class="font-[Manrope] font-black text-3xl text-[#1A1C1C]">242</h3>
                <p class="text-[11px] text-[#887364] mt-1">👤 Per session</p>
            </div>
            <div class="col-span-2 bg-white rounded-[32px] p-6 shadow-sm border border-[#DBC2B0]/20 flex justify-between items-end">
                <div>
                    <p class="font-[Inter] text-[10px] font-bold uppercase tracking-widest text-[#887364] mb-1">Budget Efficiency</p>
                    <h3 class="font-[Manrope] font-black text-3xl text-[#1A1C1C]">94.2%</h3>
                </div>
                <div class="flex items-end gap-1 h-12">
                    <div class="w-2 bg-[#DBC2B0] h-[40%] rounded-t-sm"></div>
                    <div class="w-2 bg-[#DBC2B0] h-[60%] rounded-t-sm"></div>
                    <div class="w-2 bg-[#DBC2B0] h-[50%] rounded-t-sm"></div>
                    <div class="w-2 bg-[#8D4B00] h-[90%] rounded-t-sm"></div>
                    <div class="w-2 bg-[#8D4B00] h-[70%] rounded-t-sm"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Upcoming Activities Section --}}
    <div class="w-full">
        <div class="flex justify-between items-center mb-8">
            <h2 class="font-[Manrope] font-black text-2xl text-[#1A1C1C]">Upcoming Activities</h2>
            <a href="#" class="font-[Manrope] font-bold text-sm text-[#8D4B00] flex items-center gap-2">
                View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-3 gap-8">
            @php
                $activities = [
                    [
                        'title' => 'Pengajian Bulanan: Tazkiyatun Nafs',
                        'date' => 'SAT, 14 OCT • 19:30',
                        'loc' => 'Main Prayer Hall',
                        'cat' => 'RELIGIOUS',
                        'img' => 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=800',
                        'attendees' => 45
                    ],
                    [
                        'title' => 'Bakti Sosial: Sembako Murah Rakyat',
                        'date' => 'SUN, 15 OCT • 08:00',
                        'loc' => 'Courtyard Gate 2',
                        'cat' => 'SOCIAL',
                        'img' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=800',
                        'attendees' => 120
                    ],
                    [
                        'title' => 'Kursus Bahasa Arab Dasar',
                        'date' => 'MON, 16 OCT • 16:00',
                        'loc' => 'Classroom A-3',
                        'cat' => 'EDUCATION',
                        'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=800',
                        'attendees' => 12
                    ],
                ];
            @endphp

            @foreach($activities as $act)
            <div class="bg-white rounded-[40px] overflow-hidden shadow-sm border border-[#DBC2B0]/10 flex flex-col h-full group transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="relative h-[240px]">
                    <img src="{{ $act['img'] }}" class="w-full h-full object-cover" alt="{{ $act['title'] }}">
                    <div class="absolute top-6 left-6">
                        <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-[10px] font-black tracking-widest text-[#1A1C1C] shadow-sm">
                            {{ $act['cat'] }}
                        </span>
                    </div>
                </div>
                <div class="p-8 flex flex-col flex-1">
                    <p class="font-[Inter] text-[11px] font-bold text-[#887364] mb-2">{{ $act['date'] }}</p>
                    <h4 class="font-[Manrope] font-black text-xl text-[#1A1C1C] mb-4 leading-tight min-h-[56px]">{{ $act['title'] }}</h4>
                    <p class="font-[Manrope] text-sm text-[#887364] flex items-center gap-2 mb-8">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $act['loc'] }}
                    </p>
                    <div class="mt-auto flex justify-between items-center">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-200 overflow-hidden"><img src="https://i.pravatar.cc/150?u=1" alt=""></div>
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-200 overflow-hidden"><img src="https://i.pravatar.cc/150?u=2" alt=""></div>
                            <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-200 overflow-hidden flex items-center justify-center bg-[#F4F4F3] font-bold text-[10px] text-[#887364]">
                                +{{ $act['attendees'] }}
                            </div>
                        </div>
                        <button class="w-10 h-10 rounded-full bg-[#FFDCC3] flex items-center justify-center text-[#8D4B00] group-hover:bg-[#8D4B00] group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Financial Performance Table Section --}}
    <div class="w-full bg-white rounded-[48px] p-10 shadow-sm border border-[#DBC2B0]/10">
        <div class="flex justify-between items-start mb-10">
            <div>
                <h2 class="font-[Manrope] font-black text-2xl text-[#1A1C1C]">Financial Performance</h2>
                <p class="text-sm text-[#887364] mt-1">Budget allocation vs. actual real-time spending across categories.</p>
            </div>
            <div class="flex bg-[#F4F4F3] p-1 rounded-2xl">
                <button class="px-6 py-2 bg-white rounded-xl shadow-sm text-sm font-bold text-[#1A1C1C]">Monthly</button>
                <button class="px-6 py-2 text-sm font-bold text-[#887364]">Quarterly</button>
            </div>
        </div>

        <table class="w-full">
            <thead>
                <tr class="text-left border-b border-[#F4F4F3]">
                    <th class="pb-6 font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364]">Category</th>
                    <th class="pb-6 font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364]">Allocated Budget</th>
                    <th class="pb-6 font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364]">Actual Spent</th>
                    <th class="pb-6 font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364]">Utilization</th>
                    <th class="pb-6 font-[Inter] text-[10px] font-black uppercase tracking-widest text-[#887364] text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#F4F4F3]">
                @php
                    $performance = [
                        ['cat' => 'Religious Events', 'budget' => 25000000, 'spent' => 18450000, 'pct' => 74, 'status' => 'On Track', 'color' => 'bg-[#8D4B00]'],
                        ['cat' => 'Education Programs', 'budget' => 15000000, 'spent' => 14800000, 'pct' => 98, 'status' => 'Near Limit', 'color' => 'bg-[#8D4B00]'],
                        ['cat' => 'Maintenance & Ops', 'budget' => 10000000, 'spent' => 4200000, 'pct' => 42, 'status' => 'On Track', 'color' => 'bg-[#8D4B00]'],
                        ['cat' => 'Social Outreach', 'budget' => 30000000, 'spent' => 32500000, 'pct' => 100, 'status' => 'Over Budget', 'color' => 'bg-[#BA1A1A]'],
                    ];
                @endphp

                @foreach($performance as $p)
                <tr class="group">
                    <td class="py-8 font-[Manrope] font-extrabold text-[#1A1C1C]">{{ $p['cat'] }}</td>
                    <td class="py-8 font-[Manrope] font-bold text-[#554336]">Rp {{ number_format($p['budget'], 0, ',', '.') }}</td>
                    <td class="py-8 font-[Manrope] font-bold text-[#554336]">Rp {{ number_format($p['spent'], 0, ',', '.') }}</td>
                    <td class="py-8 w-[300px]">
                        <div class="flex items-center gap-4">
                            <div class="flex-1 h-2 bg-[#F4F4F3] rounded-full overflow-hidden">
                                <div class="h-full {{ $p['color'] }} rounded-full" style="width: {{ $p['pct'] }}%"></div>
                            </div>
                            <span class="font-[Inter] text-[11px] font-black text-[#1A1C1C] w-8">{{ $p['pct'] }}%</span>
                        </div>
                    </td>
                    <td class="py-8 text-right">
                        @php
                            $statusClasses = [
                                'On Track' => 'bg-[#D8E7D2] text-[#526050]',
                                'Near Limit' => 'bg-[#FFDCC3] text-[#8D4B00]',
                                'Over Budget' => 'bg-[#FFDAD6] text-[#BA1A1A]',
                            ];
                        @endphp
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tight {{ $statusClasses[$p['status']] }}">
                            {{ $p['status'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection