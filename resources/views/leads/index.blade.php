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
    <button id="filter-all" onclick="filterByCategory('all')" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-indigo-500/20 active-filter">
        <i data-lucide="layout-grid" class="w-3.5 h-3.5"></i>
        All Leads <span class="ml-1 opacity-70">{{ $stats->total }}</span>
    </button>
    <button id="filter-NotInterested" onclick="filterByCategory('Not Interested')" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-xs font-bold text-slate-500 dark:text-slate-400 hover:bg-slate-50 transition-all">
        <i data-lucide="x" class="w-3.5 h-3.5 text-rose-500"></i>
        Not Interested <span class="px-1.5 py-0.5 rounded-md bg-rose-50 text-rose-600 ml-1 text-[10px]">{{ $stats->not_interested }}</span>
    </button>
    <button id="filter-Followup" onclick="filterByCategory('Followup')" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-xs font-bold text-slate-500 dark:text-slate-400 hover:bg-slate-50 transition-all">
        <i data-lucide="phone" class="w-3.5 h-3.5 text-amber-500"></i>
        Followup <span class="px-1.5 py-0.5 rounded-md bg-amber-50 text-amber-600 ml-1 text-[10px]">{{ $stats->followup }}</span>
    </button>
    <button id="filter-Pending" onclick="filterByCategory('Pending')" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-xs font-bold text-slate-500 dark:text-slate-400 hover:bg-slate-50 transition-all">
        <i data-lucide="history" class="w-3.5 h-3.5 text-sky-500"></i>
        Pending <span class="px-1.5 py-0.5 rounded-md bg-sky-50 text-sky-600 ml-1 text-[10px]">{{ $stats->pending }}</span>
    </button>
    <button id="filter-Confirm" onclick="filterByCategory('Confirm')" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-xs font-bold text-slate-500 dark:text-slate-400 hover:bg-slate-50 transition-all">
        <i data-lucide="check-square" class="w-3.5 h-3.5 text-emerald-500"></i>
        Confirm <span class="px-1.5 py-0.5 rounded-md bg-emerald-50 text-emerald-600 ml-1 text-[10px]">{{ $stats->confirm }}</span>
    </button>
    <button id="filter-notes" onclick="filterByCategory('notes')" class="lead-filter-btn flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl text-xs font-bold text-slate-500 dark:text-slate-400 hover:bg-slate-50 transition-all">
        <i data-lucide="file-edit" class="w-3.5 h-3.5 text-slate-500"></i>
        Notes <span class="px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-600 ml-1 text-[10px]">{{ $stats->has_notes }}</span>
    </button>
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
                <div class="relative min-w-[240px]">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input type="text" id="lead-search" onkeyup="searchLeads()" placeholder="Search leads..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
                <select class="pl-4 pr-10 py-2.5 bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl text-sm font-bold text-slate-500 appearance-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                    <option>All Sources</option>
                    <option>Website</option>
                    <option>Referral</option>
                    <option>Social Media</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto overflow-y-visible">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 dark:bg-slate-900 border-b border-slate-50 dark:border-slate-800/60">
                    <tr>
                        <th class="px-8 py-5">
                            <input type="checkbox" id="select-all-leads" class="rounded border-slate-200 text-indigo-500 focus:ring-indigo-500">
                        </th>
                        <th class="px-4 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Name</th>
                        <th class="px-4 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Company</th>
                        <th class="px-4 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Email</th>
                        <th class="px-4 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Source</th>
                        <th class="px-4 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Category</th>
                        <th class="px-4 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Value</th>
                        <th class="px-4 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Created</th>
                        <th class="px-4 py-5">
                            <div class="flex flex-col items-start gap-1">
                                <i data-lucide="phone-call" class="w-4 h-4 text-amber-500"></i>
                                <span class="text-[10px] font-black uppercase tracking-widest text-amber-500">Followup<br>Date</span>
                            </div>
                        </th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="leads-table-body" class="divide-y divide-slate-50 dark:divide-slate-800/60">
                    @foreach($leads as $lead)
                    @php
                        $tagColor = [
                            'Not Interested' => 'rose',
                            'Followup' => 'amber',
                            'Pending' => 'sky',
                            'Confirm' => 'emerald'
                        ][$lead->category] ?? 'slate';
                    @endphp
                    <tr class="lead-row hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-all group" data-category="{{ $lead->category }}" data-has-notes="{{ $lead->has_notes ? 'true' : 'false' }}">
                        <td class="px-8 py-5">
                            <input type="checkbox" class="lead-checkbox rounded border-slate-200 text-indigo-500 focus:ring-indigo-500">
                        </td>
                        <td class="px-4 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-{{ $lead->color }}-500/10 flex items-center justify-center">
                                    <span class="text-xs font-black text-{{ $lead->color }}-600">{{ $lead->initials }}</span>
                                </div>
                                <span class="text-sm font-black text-slate-700 dark:text-slate-200 lead-name">{{ $lead->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-5 text-sm font-bold text-slate-500 dark:text-slate-400 lead-company">{{ $lead->company }}</td>
                        <td class="px-4 py-5 text-sm text-slate-400 lead-email">{{ $lead->email }}</td>
                        <td class="px-4 py-5 text-sm font-bold text-slate-500 dark:text-slate-400">{{ $lead->source }}</td>
                        <td class="px-4 py-5">
                            <span class="px-3 py-1 rounded-lg bg-{{ $tagColor }}-50 dark:bg-{{ $tagColor }}-900/20 text-[10px] font-black text-{{ $tagColor }}-600 dark:text-{{ $tagColor }}-400 uppercase tracking-widest border border-{{ $tagColor }}-100 dark:border-{{ $tagColor }}-800/50">
                                {{ $lead->category }}
                            </span>
                        </td>
                        <td class="px-4 py-5 text-sm font-black text-slate-800 dark:text-white">{{ $lead->value }}</td>
                        <td class="px-4 py-5 text-[11px] font-bold text-slate-400">{{ $lead->created_at }}</td>
                        <td class="px-4 py-5">
                            @if($lead->followup_date)
                                <div class="flex flex-col gap-1">
                                    <span class="text-[13px] font-black text-slate-700 dark:text-slate-200 leading-none">
                                        {{ $lead->followup_date->format('d M Y') }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 font-bold leading-none">
                                        {{ $lead->followup_date->format('H:i') }}
                                    </span>
                                    
                                    @php
                                        $diff = now()->startOfDay()->diffInDays($lead->followup_date->startOfDay(), false);
                                        $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                        $text = "in $diff days";
                                        
                                        if ($diff == 0) {
                                            $badgeClass = 'bg-amber-50 text-amber-600 border-amber-100';
                                            $text = 'Today';
                                        } elseif ($diff == 1) {
                                            $badgeClass = 'bg-amber-50 text-amber-600 border-amber-100';
                                            $text = 'Tomorrow';
                                        } elseif ($diff < 0) {
                                            $badgeClass = 'bg-rose-50 text-rose-600 border-rose-100';
                                            $text = abs($diff) . ' days ago';
                                            if ($diff == -1) $text = 'Yesterday';
                                        }
                                    @endphp
                                    
                                    <div class="mt-1">
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black {{ $badgeClass }} border inline-block">
                                            {{ $text }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <span class="text-slate-300 font-black">___</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('leads.show', $lead->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-slate-100 transition-all" title="Add Note">
                                    <i data-lucide="file-text" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('leads.show', $lead->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-sky-600 hover:bg-slate-100 transition-all" title="View">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="{{ route('leads.edit', $lead->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-slate-100 transition-all" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form id="delete-lead-{{ $lead->id }}" action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="swal-delete p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-slate-100 transition-all shadow-sm border border-transparent hover:border-rose-100" 
                                            data-form-id="delete-lead-{{ $lead->id }}"
                                            data-name="{{ $lead->name }}"
                                            title="Delete Lead">
                                        <i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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

@push('scripts')
<script>
let currentCategory = 'all';

function filterByCategory(category) {
    currentCategory = category;
    const buttons = document.querySelectorAll('.lead-filter-btn');
    const tableContainer = document.getElementById('table-view-container');
    const notesContainer = document.getElementById('notes-view-container');
    
    // Toggle View Containers
    if (category === 'notes') {
        tableContainer.classList.add('hidden');
        notesContainer.classList.remove('hidden');
    } else {
        tableContainer.classList.remove('hidden');
        notesContainer.classList.add('hidden');
    }
    
    // Update button styles
    buttons.forEach(btn => {
        btn.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/20', 'active-filter');
        btn.classList.add('bg-white', 'dark:bg-slate-800', 'text-slate-500', 'dark:text-slate-400');
    });
    
    const activeBtn = document.getElementById(`filter-${category.replace(' ', '')}`);
    if (activeBtn) {
        activeBtn.classList.remove('bg-white', 'dark:bg-slate-800', 'text-slate-500', 'dark:text-slate-400');
        activeBtn.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/20', 'active-filter');
    }
    
    if (category !== 'notes') {
        applyFilters();
    }
}

function searchLeads() {
    applyFilters();
}

function applyFilters() {
    const searchInput = document.getElementById('lead-search');
    if (!searchInput) return;
    const query = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('.lead-row');
    const title = document.getElementById('table-title');
    
    title.innerText = currentCategory === 'all' ? 'All Leads' : currentCategory;
    
    rows.forEach(row => {
        const rowCategory = row.dataset.category;
        const name = row.querySelector('.lead-name').innerText.toLowerCase();
        const company = row.querySelector('.lead-company').innerText.toLowerCase();
        const email = row.querySelector('.lead-email').innerText.toLowerCase();
        
        const matchesCategory = currentCategory === 'all' || rowCategory === currentCategory;
        const matchesSearch = name.includes(query) || company.includes(query) || email.includes(query);
        
        if (matchesCategory && matchesSearch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function applyNotesFilters() {
    const query = document.getElementById('notes-search').value.toLowerCase();
    const category = document.getElementById('notes-category-filter').value;
    const items = document.querySelectorAll('.note-item');

    items.forEach(item => {
        const itemCategory = item.dataset.category;
        const leadName = item.dataset.lead;
        const text = item.querySelector('.note-text').innerText.toLowerCase();
        
        const matchesCategory = category === 'all' || itemCategory === category;
        const matchesSearch = leadName.includes(query) || text.includes(query);
        
        if (matchesCategory && matchesSearch) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

function sortNotesList() {
    const sort = document.getElementById('notes-sort').value;
    const container = document.getElementById('notes-list-container');
    const items = Array.from(container.querySelectorAll('.note-item'));

    items.sort((a, b) => {
        const timeA = parseInt(a.dataset.timestamp);
        const timeB = parseInt(b.dataset.timestamp);
        return sort === 'newest' ? timeB - timeA : timeA - timeB;
    });

    items.forEach(item => container.appendChild(item));
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
    const leadId = document.getElementById('note-lead-id').value;
    const leadName = document.querySelector(`#note-lead-id option[value="${leadId}"]`).text.split(' (')[0];
    const category = document.querySelector('input[name="note-category"]:checked').value;
    const content = document.getElementById('note-content').value;

    if (!content) {
        alert('Please enter some note content.');
        return;
    }

    // Mock category icon/color
    const config = {
        'General': { icon: 'file-text', color: 'slate' },
        'Lead': { icon: 'target', color: 'indigo' },
        'Customer': { icon: 'users', color: 'sky' },
        'Deal': { icon: 'briefcase', color: 'emerald' },
        'Follow-up': { icon: 'phone', color: 'amber' },
        'Important': { icon: 'alert-circle', color: 'rose' }
    }[category];

    // Create new timeline item
    const timeline = document.querySelector('#notes-view-container .space-y-8');
    const newItem = document.createElement('div');
    const timestamp = Math.floor(Date.now() / 1000);
    newItem.className = 'note-item relative pl-8 border-l-2 border-slate-100 dark:border-slate-800 pb-8 last:pb-0';
    newItem.dataset.category = category;
    newItem.dataset.lead = leadName.toLowerCase();
    newItem.dataset.timestamp = timestamp;
    
    newItem.innerHTML = `
        <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-white dark:bg-slate-900 border-4 border-${config.color}-500"></div>
        <div class="flex items-center gap-3 mb-4">
            <span class="px-3 py-1 rounded-lg bg-${config.color}-50 text-[10px] font-black text-${config.color}-600 uppercase tracking-widest border border-${config.color}-100">
                <i data-lucide="${config.icon}" class="w-3 h-3 inline-block mr-1"></i> ${category}
            </span>
            <span class="text-slate-400 font-bold text-sm">→ ${leadName}</span>
        </div>
        <h4 class="text-xl font-black text-slate-800 dark:text-white mb-3">Notes for ${leadName}</h4>
        <div class="note-text text-slate-500 dark:text-slate-400 text-sm font-medium space-y-4 max-w-2xl leading-relaxed">
            ${content}
        </div>
    `;

    timeline.insertBefore(newItem, timeline.firstChild);
    lucide.createIcons();
    
    // Clear and close
    document.getElementById('note-content').value = '';
    closeAddNoteModal();
    
    // Global toast
    showToast('Note added successfully! ✨');
}

// Select All Functionality
document.getElementById('select-all-leads').addEventListener('change', function() {
    const isChecked = this.checked;
    const checkboxes = document.querySelectorAll('.lead-checkbox');
    checkboxes.forEach(cb => {
        // Only select checkboxes of visible rows
        if (cb.closest('.lead-row').style.display !== 'none') {
            cb.checked = isChecked;
        }
    });
});
</script>
@endpush
@endsection
