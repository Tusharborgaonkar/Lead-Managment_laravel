@extends('layouts.app')
@section('title', 'Sales / Deals — CRM Admin')

@section('content')
<div class="space-y-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">Sales / Deals</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Manage your sales pipeline and track deal progress</p>
        </div>
        <div class="flex items-center gap-3 relative">
            <form action="{{ route('deals.index') }}" method="GET" class="flex items-center gap-3">
                <div class="relative group">
                    @foreach(request()->except('search', 'stage') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search deals..." class="pl-11 pr-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/60 rounded-2xl text-sm font-bold text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500/50 transition-all w-64 shadow-sm">
                </div>
                <select name="stage" onchange="this.form.submit()" class="pl-4 pr-10 py-2.5 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700/60 rounded-2xl text-sm font-bold text-slate-500 appearance-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500/50 cursor-pointer shadow-sm">
                    <option value="all">All Stages</option>
                    @foreach(['Prospect', 'Qualified', 'Proposal', 'Negotiation', 'Won'] as $stage)
                        <option value="{{ $stage }}" {{ request('stage') === $stage ? 'selected' : '' }}>{{ $stage }}</option>
                    @endforeach
                </select>
            </form>
            <button onclick="toggleDropdown('dealsExportDropdown')" id="btnDealsExport" class="flex items-center gap-2.5 px-5 py-2.5 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-2xl text-sm font-bold shadow-sm border border-slate-100 dark:border-slate-700/60 hover:bg-slate-50 transition active:scale-95">
                <i data-lucide="download" class="w-4 h-4 text-slate-400"></i>
                Export Board
            </button>
            <div id="dealsExportDropdown" class="hidden absolute top-12 right-0 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700/60 z-[100] overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                <div class="p-1.5 space-y-0.5">
                    <button onclick="exportReport('CSV', 'Deals Pipeline')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Export as CSV
                    </button>
                    <button onclick="exportReport('Excel', 'Deals Pipeline')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i> Export as Excel
                    </button>
                    <button onclick="exportReport('PDF', 'Deals Pipeline')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 dark:hover:text-rose-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-type-2" class="w-3.5 h-3.5"></i> Export as PDF
                    </button>
                </div>
            </div>
            <a href="{{ route('deals.create') }}" class="flex items-center gap-2.5 px-6 py-2.5 bg-indigo-600 text-white rounded-2xl text-sm font-black shadow-lg shadow-indigo-500/25 hover:bg-indigo-700 transition active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i>
                New Deal
            </a>
        </div>
    </div>

    {{-- KPI Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Deals --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm relative group">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                <i data-lucide="briefcase" class="w-6 h-6 text-indigo-500"></i>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->total_deals }}</h3>
            <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">Total Deals</p>
        </div>

        {{-- Won Value --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm relative group">
            <div class="absolute top-6 right-6 px-2 py-1 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-100 dark:border-emerald-800/50">
                <span class="text-[10px] font-black text-emerald-600">{{ $stats->won_trend }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                <i data-lucide="trophy" class="w-6 h-6 text-emerald-500"></i>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->won_value }}</h3>
            <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">Won Value</p>
        </div>

        {{-- Pipeline Value --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm relative group">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                <i data-lucide="layers" class="w-6 h-6 text-amber-500"></i>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->pipeline_value }}</h3>
            <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">Pipeline Value</p>
        </div>

        {{-- Win Rate --}}
        <div class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm relative group">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                <i data-lucide="percent" class="w-6 h-6 text-rose-500"></i>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->win_rate }}</h3>
            <p class="text-[11px] font-black uppercase tracking-widest text-slate-400">Win Rate</p>
        </div>
    </div>

    {{-- Funnel Chart Container --}}
    <div class="bg-white dark:bg-slate-800 p-10 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-sm relative overflow-hidden">
        <h4 class="text-[11px] font-black uppercase tracking-widest text-slate-400 mb-8 pl-1">Deal Pipeline</h4>
        <div class="flex items-end justify-between h-48 gap-8 px-4">
            @foreach($pipelineChart as $bar)
            <div class="flex-1 flex flex-col items-center group relative">
                <div class="w-full rounded-2xl transition-all duration-500 group-hover:filter group-hover:brightness-110 shadow-lg shadow-black/5" 
                     style="height: {{ $bar['value'] }}px; background-color: {{ $bar['color'] }};">
                     <div class="absolute -top-8 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap bg-slate-800 text-white text-[10px] font-black px-2.5 py-1 rounded-lg">
                        {{ $bar['value'] }} Deals
                     </div>
                </div>
                <div class="mt-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $bar['stage'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Kanban Board --}}
    <div>
        <h4 class="text-[11px] font-black uppercase tracking-widest text-slate-400 mb-6 pl-1">Pipeline Board</h4>
        <div class="flex gap-6 overflow-x-auto pb-6 -mx-6 px-6 scrollbar-hide">
            @foreach($deals as $stage => $stageDeals)
            <div class="min-w-[320px] flex-1">
                <div class="flex items-center justify-between mb-4 px-2">
                    <div class="flex items-center gap-2">
                        @php
                            $dotColor = match($stage) {
                                'Prospect' => 'indigo',
                                'Qualified' => 'emerald',
                                'Proposal' => 'amber',
                                'Negotiation' => 'orange',
                                'Won' => 'green',
                                default => 'slate'
                            };
                        @endphp
                        <div class="w-2.5 h-2.5 rounded-full bg-{{ $dotColor }}-500 animate-pulse"></div>
                        <h5 class="text-sm font-black text-slate-700 dark:text-white uppercase tracking-wider">{{ $stage }}</h5>
                    </div>
                    <span class="text-[11px] font-black text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-lg">{{ count($stageDeals) }}</span>
                </div>

                <div class="space-y-4">
                    @foreach($stageDeals as $deal)
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-xl hover:shadow-slate-200/40 dark:hover:shadow-none transition-all cursor-move group">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <a href="{{ route('deals.edit', $deal->id) }}" class="text-sm font-black text-slate-800 dark:text-white mb-1 group-hover:text-indigo-600 transition-colors block">{{ $deal->title }}</a>
                                <p class="text-lg font-black text-indigo-600">${{ number_format($deal->value) }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-[10px] font-black text-indigo-600 uppercase">
                                    {{ substr($deal->customer->name ?? 'NA', 0, 2) }}
                                </div>
                                <form id="delete-deal-{{ $deal->id }}" action="{{ route('deals.destroy', $deal->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" 
                                            class="swal-delete p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all opacity-0 group-hover:opacity-100" 
                                            data-form-id="delete-deal-{{ $deal->id }}"
                                            data-name="{{ $deal->title }}"
                                            title="Delete Deal">
                                        <i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-400 truncate pr-4">{{ $deal->customer->company ?? $deal->customer->name ?? 'N/A' }}</span>
                            <div class="flex -space-x-2">
                                <div class="w-6 h-6 rounded-full border-2 border-white dark:border-slate-800 bg-slate-100 flex items-center justify-center overflow-hidden">
                                     <i data-lucide="user" class="w-3 h-3 text-slate-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    {{-- Add Deal Placeholder --}}
                    <a href="{{ route('deals.create') }}" class="w-full py-4 border-2 border-dashed border-slate-100 dark:border-slate-800 rounded-3xl text-sm font-black text-slate-300 hover:border-indigo-200 hover:text-indigo-300 transition-all flex items-center justify-center gap-2 group">
                        <i data-lucide="plus" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                        Add Deal
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
