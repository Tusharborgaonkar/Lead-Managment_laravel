@extends('layouts.app')
@section('title', 'Lead Management — CRM Admin')

@section('content')
{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Lead Management</h1>
        <p class="text-sm text-slate-400 font-medium">Track and manage leads by category</p>
    </div>
    <div class="flex items-center gap-3 relative">
        <button onclick="toggleDropdown('leadsExportDropdown')" id="btnLeadsExport" class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all shadow-sm">
            <i data-lucide="download" class="w-4 h-4 text-slate-400"></i>
            Export
        </button>
        <div id="leadsExportDropdown" class="hidden absolute top-12 right-0 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700/60 z-[100] overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
            <div class="p-1.5 space-y-0.5">
                <button onclick="exportReport('CSV', 'Leads List')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl transition-colors flex items-center gap-2.5">
                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Export as CSV
                </button>
                <button onclick="exportReport('Excel', 'Leads List')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-colors flex items-center gap-2.5">
                    <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i> Export as Excel
                </button>
                <button onclick="exportReport('PDF', 'Leads List')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 dark:hover:text-rose-400 rounded-xl transition-colors flex items-center gap-2.5">
                    <i data-lucide="file-type-2" class="w-3.5 h-3.5"></i> Export as PDF
                </button>
            </div>
        </div>
        <a href="{{ route('leads.create') }}" class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/25">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add Lead
        </a>
    </div>
</div>

{{-- Filters Row --}}
<div class="flex flex-wrap items-center gap-3 mb-8">
    <a href="{{ route('leads.index', array_merge(request()->query(), ['category' => 'all', 'page' => 1])) }}" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 {{ request('category', 'all') === 'all' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 active-filter' : 'bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-500 dark:text-slate-400' }} rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
        <i data-lucide="layout-grid" class="w-3.5 h-3.5"></i>
        All Leads <span class="ml-1 opacity-70">{{ $stats->total }}</span>
    </a>
    <a href="{{ route('leads.index', array_merge(request()->query(), ['category' => 'Not Interested', 'page' => 1])) }}" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 {{ request('category') === 'Not Interested' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 active-filter' : 'bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-500 dark:text-slate-400' }} rounded-2xl text-xs font-bold hover:bg-slate-50 transition-all">
        <i data-lucide="x" class="w-3.5 h-3.5 text-rose-500"></i>
        Not Interested <span class="px-1.5 py-0.5 rounded-md bg-rose-50 text-rose-600 ml-1 text-[10px]">{{ $stats->not_interested }}</span>
    </a>
    <a href="{{ route('leads.index', array_merge(request()->query(), ['category' => 'Followup', 'page' => 1])) }}" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 {{ request('category') === 'Followup' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 active-filter' : 'bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-500 dark:text-slate-400' }} rounded-2xl text-xs font-bold hover:bg-slate-50 transition-all">
        <i data-lucide="phone" class="w-3.5 h-3.5 text-amber-500"></i>
        Followup <span class="px-1.5 py-0.5 rounded-md bg-amber-50 text-amber-600 ml-1 text-[10px]">{{ $stats->followup }}</span>
    </a>
    <a href="{{ route('leads.index', array_merge(request()->query(), ['category' => 'Pending', 'page' => 1])) }}" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 {{ request('category') === 'Pending' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 active-filter' : 'bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-500 dark:text-slate-400' }} rounded-2xl text-xs font-bold hover:bg-slate-50 transition-all">
        <i data-lucide="history" class="w-3.5 h-3.5 text-sky-500"></i>
        Pending <span class="px-1.5 py-0.5 rounded-md bg-sky-50 text-sky-600 ml-1 text-[10px]">{{ $stats->pending }}</span>
    </a>
    <a href="{{ route('leads.index', array_merge(request()->query(), ['category' => 'Confirm', 'page' => 1])) }}" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 {{ request('category') === 'Confirm' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 active-filter' : 'bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-500 dark:text-slate-400' }} rounded-2xl text-xs font-bold hover:bg-slate-50 transition-all">
        <i data-lucide="check-square" class="w-3.5 h-3.5 text-emerald-500"></i>
        Confirm <span class="px-1.5 py-0.5 rounded-md bg-emerald-50 text-emerald-600 ml-1 text-[10px]">{{ $stats->confirm }}</span>
    </a>
    <a href="{{ route('leads.index', array_merge(request()->query(), ['category' => 'notes', 'page' => 1])) }}" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 {{ request('category') === 'notes' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 active-filter' : 'bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-500 dark:text-slate-400' }} rounded-2xl text-xs font-bold hover:bg-slate-50 transition-all">
        <i data-lucide="file-edit" class="w-3.5 h-3.5 text-slate-500"></i>
        Notes <span class="px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-600 ml-1 text-[10px]">{{ $stats->has_notes }}</span>
    </a>
</div>

<div id="table-view-container">
    {{-- Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6 mb-10">
        {{-- Total Leads --}}
        <div onclick="filterByCategory('all')" class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm relative overflow-hidden group cursor-pointer transition-all hover:border-indigo-200">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                <i data-lucide="target" class="w-6 h-6 text-indigo-500"></i>
            </div>
            <div class="absolute top-6 right-6">
                <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest">+15%</span>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->total }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Leads</p>
        </div>

        {{-- Not Interested --}}
        <div onclick="filterByCategory('Not Interested')" class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm group cursor-pointer transition-all hover:border-rose-200">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                <i data-lucide="x-circle" class="w-6 h-6 text-rose-500"></i>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->not_interested }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Not Interested</p>
        </div>

        {{-- Followup --}}
        <div onclick="filterByCategory('Followup')" class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm group cursor-pointer transition-all hover:border-amber-200">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                <i data-lucide="phone-call" class="w-6 h-6 text-amber-500"></i>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->followup }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Followup</p>
        </div>

        {{-- Pending --}}
        <div onclick="filterByCategory('Pending')" class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm group cursor-pointer transition-all hover:border-sky-200">
            <div class="w-12 h-12 rounded-2xl bg-sky-50 dark:bg-sky-900/20 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                <i data-lucide="clock" class="w-6 h-6 text-sky-500"></i>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->pending }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending</p>
        </div>

        {{-- Confirm --}}
        <div onclick="filterByCategory('Confirm')" class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm group cursor-pointer transition-all hover:border-emerald-200">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                <i data-lucide="check-circle" class="w-6 h-6 text-emerald-500"></i>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->confirm }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Confirm</p>
        </div>

        {{-- Notes --}}
        <div onclick="filterByCategory('notes')" class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm group cursor-pointer transition-all hover:border-slate-300">
            <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-900/20 flex items-center justify-center mb-4 transition-transform group-hover:scale-110">
                <i data-lucide="file-edit" class="w-6 h-6 text-slate-500"></i>
            </div>
            <h3 class="text-3xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->has_notes }}</h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Notes</p>
        </div>
    </div>

    {{-- Main Content Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/60 shadow-sm overflow-hidden">
        {{-- Internal Toolbar --}}
        <div class="px-8 py-6 border-b border-slate-50 dark:border-slate-800/60 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 id="table-title" class="text-lg font-black text-slate-800 dark:text-white">All Leads</h2>
                <p class="text-xs text-slate-400 font-medium">Showing all leads in the system</p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('leads.index') }}" method="GET" class="relative min-w-[240px]">
                    @foreach(request()->except('search', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input type="text" name="search" id="lead-search" value="{{ request('search') }}" placeholder="Search leads..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all">
                </form>
                <form action="{{ route('leads.index') }}" method="GET">
                    @foreach(request()->except('source', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="source" onchange="this.form.submit()" class="pl-4 pr-10 py-2.5 bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl text-sm font-bold text-slate-500 appearance-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                        <option value="All Sources" {{ request('source') === 'All Sources' ? 'selected' : '' }}>All Sources</option>
                        @foreach(['Website', 'Referral', 'Social Media', 'Cold Call', 'WhatsApp', 'Events'] as $source)
                            <option value="{{ $source }}" {{ request('source') === $source ? 'selected' : '' }}>{{ $source }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        {{-- Tabulator Table --}}
        <div class="crm-table-wrapper overflow-x-auto overflow-y-visible">
            <div id="leads-table"></div>
        </div>

        @if($leads->hasPages())
        <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800/60 bg-slate-50/50 dark:bg-slate-900/50">
            {{ $leads->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Notes View Container (Hidden by default) --}}
<div id="notes-view-container" class="hidden">
    {{-- Notes Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        {{-- Total Notes --}}
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm relative group overflow-hidden">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center mb-5 transition-transform group-hover:scale-110">
                <i data-lucide="files" class="w-6 h-6 text-indigo-500"></i>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->has_notes }}</h3>
            <p class="text-[13px] font-bold text-slate-400">Total Notes</p>
        </div>
        {{-- Added Today --}}
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm relative group overflow-hidden">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center mb-5 transition-transform group-hover:scale-110">
                <i data-lucide="calendar" class="w-6 h-6 text-emerald-500"></i>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->notes_added_today ?? 0 }}</h3>
            <p class="text-[13px] font-bold text-slate-400">Added Today</p>
        </div>
        {{-- Categories Used --}}
        <div class="bg-white dark:bg-slate-800 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm relative group overflow-hidden">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center mb-5 transition-transform group-hover:scale-110">
                <i data-lucide="tag" class="w-6 h-6 text-amber-500"></i>
            </div>
            <h3 class="text-4xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->notes_categories_count ?? 0 }}</h3>
            <p class="text-[13px] font-bold text-slate-400">Categories Used</p>
        </div>
    </div>

    {{-- Notes Toolbar --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div class="flex flex-wrap items-center gap-4">
            <div class="relative min-w-[320px]">
                <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 w-4.5 h-4.5 text-slate-400"></i>
                <input type="text" id="notes-search" oninput="applyNotesFilters()" placeholder="Search notes..." class="w-full pl-12 pr-6 py-3.5 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl text-[14px] focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm">
            </div>
            <select id="notes-category-filter" onchange="applyNotesFilters()" class="px-6 py-3.5 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl text-[14px] font-bold text-slate-500 appearance-none focus:ring-2 focus:ring-indigo-500 cursor-pointer shadow-sm">
                <option value="all">All Categories</option>
                <option value="General">General</option>
                <option value="Lead">Lead</option>
                <option value="Customer">Customer</option>
                <option value="Deal">Deal</option>
                <option value="Follow-up">Follow-up</option>
                <option value="Important">Important</option>
            </select>
            <select id="notes-sort" onchange="sortNotesList()" class="px-6 py-3.5 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl text-[14px] font-bold text-slate-500 appearance-none focus:ring-2 focus:ring-indigo-500 cursor-pointer shadow-sm">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
            </select>
        </div>
        <button onclick="openAddNoteModal()" class="flex items-center gap-3 px-8 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-[14px] hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/25 ml-auto">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Add Note
        </button>
    </div>

    {{-- Notes List --}}
    <div id="notes-list-container" class="space-y-8 bg-white dark:bg-slate-900 p-12 rounded-[2.5rem] border border-slate-50 dark:border-slate-800 shadow-sm min-h-[400px]">
        @foreach($leads->where('has_notes', true) as $nlead)
        @php
            $noteCategories = ['General', 'Lead', 'Customer', 'Deal', 'Follow-up', 'Important'];
            $noteCategory = $noteCategories[$loop->index % count($noteCategories)];
            $noteColor = [
                'General' => 'slate',
                'Lead' => 'indigo',
                'Customer' => 'sky',
                'Deal' => 'emerald',
                'Follow-up' => 'amber',
                'Important' => 'rose'
            ][$noteCategory];
            $noteIcon = [
                'General' => 'file-text',
                'Lead' => 'target',
                'Customer' => 'users',
                'Deal' => 'briefcase',
                'Follow-up' => 'phone',
                'Important' => 'alert-circle'
            ][$noteCategory];
            // Mock timestamp for sorting
            $timestamp = now()->subHours($loop->index * 2)->timestamp;
        @endphp
        <div class="note-item relative pl-8 border-l-2 border-slate-100 dark:border-slate-800 pb-8 last:pb-0" 
             data-category="{{ $noteCategory }}" 
             data-lead="{{ strtolower($nlead->name) }}" 
             data-timestamp="{{ $timestamp }}">
            <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-white dark:bg-slate-900 border-4 border-{{ $noteColor }}-500"></div>
            
            <div class="flex items-center gap-3 mb-4">
                <span class="px-3 py-1 rounded-lg bg-{{ $noteColor }}-50 text-[10px] font-black text-{{ $noteColor }}-600 uppercase tracking-widest border border-{{ $noteColor }}-100">
                    <i data-lucide="{{ $noteIcon }}" class="w-3 h-3 inline-block mr-1"></i> {{ $noteCategory }}
                </span>
                <span class="text-slate-400 font-bold text-sm">→ {{ $nlead->name }}</span>
            </div>

            <h4 class="text-xl font-black text-slate-800 dark:text-white mb-3">Notes for {{ $nlead->name }}</h4>
            <div class="note-text text-slate-500 dark:text-slate-400 text-sm font-medium space-y-4 max-w-2xl leading-relaxed">
                {{ $nlead->notes ?? 'Reviewing lead status and next steps for collaboration.' }}
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Add Note Modal --}}
<div id="add-note-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeAddNoteModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-4">
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden transform transition-all">
            <div class="px-6 py-6 border-b border-slate-50 dark:border-slate-800/60">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xl font-black text-slate-800 dark:text-white">Add New Note</h3>
                    <button onclick="closeAddNoteModal()" class="p-2 rounded-xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
                <p class="text-sm text-slate-400 font-medium">Record an interaction or update for quick reference</p>
            </div>
            
            <div class="p-6 space-y-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Select Lead</label>
                    <select id="note-lead-id" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-[14px] font-bold text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-indigo-500 transition-all">
                        @foreach($leads as $lead)
                            <option value="{{ $lead->id }}">{{ $lead->name }} ({{ $lead->company }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Category</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(['General', 'Lead', 'Customer', 'Deal', 'Follow-up', 'Important'] as $cat)
                            <label class="relative flex items-center gap-2.5 p-3.5 bg-slate-50 dark:bg-slate-800 rounded-xl cursor-pointer hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition-all group border border-transparent has-[:checked]:border-indigo-200 has-[:checked]:bg-indigo-50/50">
                                <input type="radio" name="note-category" value="{{ $cat }}" class="hidden" {{ $cat === 'General' ? 'checked' : '' }}>
                                <div class="w-4 h-4 rounded-full border-2 border-slate-200 dark:border-slate-700 flex items-center justify-center group-hover:border-indigo-400">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500 scale-0 transition-transform"></div>
                                </div>
                                <span class="text-sm font-bold text-slate-600 dark:text-slate-300">{{ $cat }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Note Content</label>
                    <textarea id="note-content" rows="4" placeholder="Type your note here..." class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-[14px] font-medium text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-indigo-500 transition-all resize-none"></textarea>
                </div>
            </div>

            <div class="px-6 py-6 bg-slate-50/50 dark:bg-slate-800/30 border-t border-slate-50 dark:border-slate-800/60 flex items-center justify-end gap-3">
                <button onclick="closeAddNoteModal()" class="px-6 py-3 text-sm font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400 transition-all">Cancel</button>
                <button onclick="saveNote()" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-black text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/25">Save Note</button>
            </div>
        </div>
    </div>
</div>

{{-- Hidden delete forms for SweetAlert --}}
@foreach($leads as $lead)
<form id="delete-lead-{{ $lead->id }}" action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>
@endforeach

@php
    $leadsData = $leads->map(function($lead) {
        $badgeClass = null;
        $badgeText = null;

        if ($lead->followup_date) {
            $diff = now()->startOfDay()->diffInDays($lead->followup_date->startOfDay(), false);
            if ($diff == 0) {
                $badgeClass = 'bg-amber-50 text-amber-600 border-amber-100';
                $badgeText = 'Today';
            } elseif ($diff == 1) {
                $badgeClass = 'bg-amber-50 text-amber-600 border-amber-100';
                $badgeText = 'Tomorrow';
            } elseif ($diff < 0) {
                $badgeClass = 'bg-rose-50 text-rose-600 border-rose-100';
                $badgeText = ($diff == -1) ? 'Yesterday' : abs($diff) . ' days ago';
            } else {
                $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                $badgeText = 'in ' . $diff . ' days';
            }
        }

        return [
            'id' => $lead->id,
            'name' => $lead->name,
            'initials' => $lead->initials,
            'color' => $lead->color,
            'company' => $lead->company,
            'email' => $lead->email,
            'source' => $lead->source,
            'category' => $lead->category,
            'value' => $lead->value,
            'created_at' => $lead->created_at,
            'has_notes' => $lead->has_notes,
            'followup_date' => $lead->followup_date ? $lead->followup_date->format('d M Y') : null,
            'followup_time' => $lead->followup_date ? $lead->followup_date->format('H:i') : null,
            'followup_badge_class' => $badgeClass,
            'followup_badge_text' => $badgeText,
            'show_url' => route('leads.show', $lead->id),
            'edit_url' => route('leads.edit', $lead->id),
        ];
    })->values();
@endphp

@push('scripts')
<script>
var leadsTable;
var currentCategory = 'all';

// Serialize data from Blade
var leadsData = @json($leadsData);

// Color map for category badges
var categoryColors = {
    'Not Interested': 'rose',
    'Followup': 'amber',
    'Pending': 'sky',
    'Confirm': 'emerald'
};

document.addEventListener('DOMContentLoaded', function() {
    leadsTable = createCRMTable('#leads-table', [
        {
            title: '<input type="checkbox" id="select-all-leads" class="rounded border-slate-200 text-indigo-500 focus:ring-indigo-500">',
            field: '_checkbox',
            headerSort: false,
            width: 60,
            formatter: function(cell) {
                var isSelected = cell.getRow().isSelected();
                return '<input type="checkbox" class="lead-checkbox rounded border-slate-200 text-indigo-500 focus:ring-indigo-500" ' + (isSelected ? 'checked' : '') + '>';
            },
            cellClick: function(e, cell) {
                cell.getRow().toggleSelect();
            }
        },
        {
            title: 'Name',
            field: 'name',
            minWidth: 180,
            formatter: function(cell) {
                var d = cell.getData();
                return '<div class="flex items-center gap-3">' +
                    '<div class="w-9 h-9 rounded-xl bg-' + d.color + '-500/10 flex items-center justify-center">' +
                        '<span class="text-xs font-black text-' + d.color + '-600">' + d.initials + '</span>' +
                    '</div>' +
                    '<span class="text-sm font-black text-slate-700 dark:text-slate-200">' + d.name + '</span>' +
                '</div>';
            }
        },
        {
            title: 'Company',
            field: 'company',
            minWidth: 120,
            formatter: function(cell) {
                return '<span class="text-sm font-bold text-slate-500 dark:text-slate-400">' + (cell.getValue() || '') + '</span>';
            }
        },
        {
            title: 'Email',
            field: 'email',
            minWidth: 180,
            formatter: function(cell) {
                return '<span class="text-sm text-slate-400">' + (cell.getValue() || '') + '</span>';
            }
        },
        {
            title: 'Source',
            field: 'source',
            minWidth: 100,
            formatter: function(cell) {
                return '<span class="text-sm font-bold text-slate-500 dark:text-slate-400">' + (cell.getValue() || '') + '</span>';
            }
        },
        {
            title: 'Category',
            field: 'category',
            minWidth: 130,
            formatter: function(cell) {
                var cat = cell.getValue() || 'N/A';
                var color = categoryColors[cat] || 'slate';
                return '<span class="px-3 py-1 rounded-lg bg-' + color + '-50 dark:bg-' + color + '-900/20 text-[10px] font-black text-' + color + '-600 dark:text-' + color + '-400 uppercase tracking-widest border border-' + color + '-100 dark:border-' + color + '-800/50">' + cat + '</span>';
            }
        },
        {
            title: 'Value',
            field: 'value',
            minWidth: 90,
            formatter: function(cell) {
                return '<span class="text-sm font-black text-slate-800 dark:text-white">' + (cell.getValue() || '') + '</span>';
            }
        },
        {
            title: 'Created',
            field: 'created_at',
            minWidth: 100,
            formatter: function(cell) {
                return '<span class="text-[11px] font-bold text-slate-400">' + (cell.getValue() || '') + '</span>';
            }
        },
        {
            title: '<div class="flex flex-col items-start gap-1"><i data-lucide="phone-call" class="w-4 h-4 text-amber-500"></i><span class="text-[10px] font-black uppercase tracking-widest text-amber-500">Followup<br>Date</span></div>',
            field: 'followup_date',
            minWidth: 130,
            formatter: function(cell) {
                var d = cell.getData();
                if (!d.followup_date) {
                    return '<span class="text-slate-300 font-black">___</span>';
                }
                return '<div class="flex flex-col gap-1">' +
                    '<span class="text-[13px] font-black text-slate-700 dark:text-slate-200 leading-none">' + d.followup_date + '</span>' +
                    '<span class="text-[11px] text-slate-400 font-bold leading-none">' + d.followup_time + '</span>' +
                    '<div class="mt-1"><span class="px-2.5 py-1 rounded-lg text-[10px] font-black ' + d.followup_badge_class + ' border inline-block">' + d.followup_badge_text + '</span></div>' +
                '</div>';
            }
        },
        {
            title: 'Actions',
            field: 'id',
            headerSort: false,
            hozAlign: 'right',
            minWidth: 160,
            formatter: function(cell) {
                var d = cell.getData();
                return '<div class="flex items-center justify-end gap-1.5">' +
                    '<a href="' + d.show_url + '" class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-slate-100 transition-all" title="Add Note"><i data-lucide="file-text" class="w-4 h-4"></i></a>' +
                    '<a href="' + d.show_url + '" class="p-2 rounded-xl text-slate-400 hover:text-sky-600 hover:bg-slate-100 transition-all" title="View"><i data-lucide="eye" class="w-4 h-4"></i></a>' +
                    '<a href="' + d.edit_url + '" class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-slate-100 transition-all" title="Edit"><i data-lucide="pencil" class="w-4 h-4"></i></a>' +
                    '<button type="button" class="swal-delete p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-slate-100 transition-all shadow-sm border border-transparent hover:border-rose-100" data-form-id="delete-lead-' + d.id + '" data-name="' + d.name + '" title="Delete Lead"><i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i></button>' +
                '</div>';
            }
        }
    ], leadsData, {
        selectable: true,
        rowSelectionChanged: function(data, rows) {
            // Update checkbox state in DOM if visible
            var allSelected = rows.length > 0 && rows.length === leadsTable.getRows().length;
            var selectAllCheckbox = document.getElementById('select-all-leads');
            if (selectAllCheckbox) selectAllCheckbox.checked = allSelected;
        }
    });

    // Select-all checkbox (event delegation)
    document.querySelector('#leads-table').addEventListener('click', function(e) {
        if (e.target && e.target.id === 'select-all-leads') {
            var isChecked = e.target.checked;
            if (isChecked) {
                leadsTable.selectRow();
            } else {
                leadsTable.deselectRow();
            }
        }
    });
});

// --- Filter Logic (rewired to Tabulator) ---
// Note: Category filtering is now handled server-side via links.
// Local view toggling for 'notes' view is still needed.
document.addEventListener('DOMContentLoaded', function() {
    var category = "{{ request('category', 'all') }}";
    var tableContainer = document.getElementById('table-view-container');
    var notesContainer = document.getElementById('notes-view-container');

    if (category === 'notes') {
        tableContainer.classList.add('hidden');
        notesContainer.classList.remove('hidden');
    }
});

function applyFilters() {
    // No-op for leads as it's now server-side
}

function applyNotesFilters() {
    var query = document.getElementById('notes-search').value.toLowerCase();
    var category = document.getElementById('notes-category-filter').value;
    var items = document.querySelectorAll('.note-item');

    items.forEach(function(item) {
        var itemCategory = item.dataset.category;
        var leadName = item.dataset.lead;
        var text = item.querySelector('.note-text').innerText.toLowerCase();

        var matchesCategory = category === 'all' || itemCategory === category;
        var matchesSearch = leadName.includes(query) || text.includes(query);

        if (matchesCategory && matchesSearch) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

function sortNotesList() {
    var sort = document.getElementById('notes-sort').value;
    var container = document.getElementById('notes-list-container');
    var items = Array.from(container.querySelectorAll('.note-item'));

    items.sort(function(a, b) {
        var timeA = parseInt(a.dataset.timestamp);
        var timeB = parseInt(b.dataset.timestamp);
        return sort === 'newest' ? timeB - timeA : timeA - timeB;
    });

    items.forEach(function(item) { container.appendChild(item); });
}

// Add Note Modal Logic
function openAddNoteModal() {
    document.getElementById('add-note-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAddNoteModal() {
    document.getElementById('add-note-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

function saveNote() {
    var leadId = document.getElementById('note-lead-id').value;
    var leadName = document.querySelector('#note-lead-id option[value="' + leadId + '"]').text.split(' (')[0];
    var category = document.querySelector('input[name="note-category"]:checked').value;
    var content = document.getElementById('note-content').value;

    if (!content) {
        alert('Please enter some note content.');
        return;
    }

    var config = {
        'General': { icon: 'file-text', color: 'slate' },
        'Lead': { icon: 'target', color: 'indigo' },
        'Customer': { icon: 'users', color: 'sky' },
        'Deal': { icon: 'briefcase', color: 'emerald' },
        'Follow-up': { icon: 'phone', color: 'amber' },
        'Important': { icon: 'alert-circle', color: 'rose' }
    }[category];

    var timeline = document.querySelector('#notes-view-container .space-y-8');
    var newItem = document.createElement('div');
    var timestamp = Math.floor(Date.now() / 1000);
    newItem.className = 'note-item relative pl-8 border-l-2 border-slate-100 dark:border-slate-800 pb-8 last:pb-0';
    newItem.dataset.category = category;
    newItem.dataset.lead = leadName.toLowerCase();
    newItem.dataset.timestamp = timestamp;

    newItem.innerHTML = '<div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-white dark:bg-slate-900 border-4 border-' + config.color + '-500"></div>' +
        '<div class="flex items-center gap-3 mb-4">' +
            '<span class="px-3 py-1 rounded-lg bg-' + config.color + '-50 text-[10px] font-black text-' + config.color + '-600 uppercase tracking-widest border border-' + config.color + '-100">' +
                '<i data-lucide="' + config.icon + '" class="w-3 h-3 inline-block mr-1"></i> ' + category +
            '</span>' +
            '<span class="text-slate-400 font-bold text-sm">→ ' + leadName + '</span>' +
        '</div>' +
        '<h4 class="text-xl font-black text-slate-800 dark:text-white mb-3">Notes for ' + leadName + '</h4>' +
        '<div class="note-text text-slate-500 dark:text-slate-400 text-sm font-medium space-y-4 max-w-2xl leading-relaxed">' + content + '</div>';

    timeline.insertBefore(newItem, timeline.firstChild);
    lucide.createIcons();

    document.getElementById('note-content').value = '';
    closeAddNoteModal();
    showToast('Note added successfully! ✨');
}
</script>
@endpush
@endsection
