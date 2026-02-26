@extends('layouts.app')
@section('title', 'Calendar — CRM Admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <a href="{{ route('dashboard') }}" class="text-sm text-indigo-500 hover:text-indigo-600 font-medium flex items-center gap-1.5 mb-3 leading-none">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Dashboard
        </a>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Activity Calendar</h1>
        <p class="text-sm text-slate-400 mt-0.5">Manage your schedule and upcoming follow-ups.</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="alert('Static Demo: Navigated to previous month.')" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all active:scale-95">
            <i data-lucide="chevron-left" class="w-4 h-4"></i>
        </button>
        <span class="text-sm font-black text-slate-700 dark:text-slate-200">{{ now()->format('F Y') }}</span>
        <button onclick="alert('Static Demo: Navigated to next month.')" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all active:scale-95">
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
        </button>
        <div class="w-px h-6 bg-slate-200 dark:bg-slate-700 mx-1"></div>
        <a href="{{ route('followups.create') }}" class="flex items-center gap-2.5 px-6 py-2.5 bg-indigo-600 text-white rounded-2xl text-sm font-black shadow-lg shadow-indigo-500/25 hover:bg-indigo-700 transition active:scale-95">
            <i data-lucide="plus" class="w-4 h-4"></i>
            New Follow-up
        </a>
    </div>
</div>

<div class="grid grid-cols-7 gap-px bg-slate-200 dark:bg-slate-700 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
    {{-- Days of Week --}}
    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
    <div class="bg-slate-50 dark:bg-slate-900 py-3 text-center">
        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $day }}</span>
    </div>
    @endforeach

    {{-- Grid Days (Mock for current month) --}}
    @php
        $startOfMonth = now()->startOfMonth();
        $daysInPrevMonth = 0; // Simple mock: assume starts on a Sun
        $totalCells = 35;
    @endphp

    @for($i = 0; $i < $totalCells; $i++)
        @php
            $currentDate = $startOfMonth->copy()->addDays($i);
            $isToday = $currentDate->isToday();
            $isOtherMonth = $currentDate->month != now()->month;
            $dayEvents = $events->where('date', $currentDate->format('Y-m-d'));
        @endphp
        <div class="min-h-[140px] bg-white dark:bg-slate-800 p-3 flex flex-col gap-2 {{ $isOtherMonth ? 'opacity-40' : '' }} hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
            <div class="flex justify-between items-start">
                <span class="text-xs font-black {{ $isToday ? 'w-6 h-6 rounded-full bg-indigo-500 text-white flex items-center justify-center -mt-1 -ml-1' : 'text-slate-500' }}">
                    {{ $currentDate->day }}
                </span>
            </div>
            
            <div class="flex-1 space-y-1.5 pt-1 overflow-y-auto max-h-[90px] scrollbar-hide">
                @foreach($dayEvents as $event)
                <div onclick="alert('Static Demo: Event details for \'{{ $event->title }}\' would open here.')" class="group relative px-2 py-1.5 rounded-lg bg-{{ $event->color }}-50 dark:bg-{{ $event->color }}-900/20 border border-{{ $event->color }}-100 dark:border-{{ $event->color }}-800/50 cursor-pointer overflow-hidden transition-all hover:scale-[1.02] hover:shadow-sm">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-{{ $event->color }}-500"></div>
                    <p class="text-[10px] font-black text-{{ $event->color }}-700 dark:text-{{ $event->color }}-300 leading-tight truncate">
                        {{ $event->title }}
                    </p>
                    <div class="flex items-center gap-1 mt-0.5">
                         <span class="text-[8px] font-bold text-{{ $event->color }}-500 uppercase tracking-tighter opacity-70">{{ $event->type }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endfor
</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm">
        <h3 class="text-sm font-black text-slate-800 dark:text-white mb-4 uppercase tracking-wider">Upcoming Deadlines</h3>
        <div class="space-y-4">
            @foreach($events->take(3) as $event)
            <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-700/30 hover:bg-slate-100 transition-colors cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-{{ $event->color }}-500/10 flex items-center justify-center">
                        <i data-lucide="calendar-clock" class="w-5 h-5 text-{{ $event->color }}-500"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $event->title }}</p>
                        <p class="text-[11px] text-slate-400 font-medium">Scheduled for {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</p>
                    </div>
                </div>
                <button onclick="alert('Static Demo: Showing full details for \'{{ $event->title }}\'.')" class="px-4 py-1.5 bg-white dark:bg-slate-800 text-[10px] font-black text-slate-500 rounded-lg border border-slate-100 dark:border-slate-700 uppercase tracking-widest hover:text-indigo-500 hover:border-indigo-100 transition-all active:scale-95">Details</button>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-xl shadow-indigo-500/20 relative overflow-hidden group">
        <div class="relative z-10">
            <h3 class="text-lg font-black mb-2">Sync Your Calendar</h3>
            <p class="text-indigo-100 text-xs mb-6 leading-relaxed">Connect your Outlook or Google Calendar to sync all follow-ups automatically.</p>
            <button onclick="alert('Static Demo: Integration wizard for Calendar Sync would start.')" class="w-full py-3 bg-white text-indigo-600 rounded-xl text-sm font-black hover:bg-indigo-50 transition-all active:scale-95 shadow-lg">
                Connect Now
            </button>
        </div>
        <i data-lucide="refresh-cw" class="absolute -right-10 -bottom-10 w-48 h-48 text-white/10 rotate-12 group-hover:rotate-45 transition-transform duration-700"></i>
    </div>
</div>
@endsection
