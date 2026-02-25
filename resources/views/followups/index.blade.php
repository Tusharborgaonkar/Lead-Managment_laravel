@extends('layouts.app')
@section('title', 'Follow-ups — CRM Admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <a href="{{ route('dashboard') }}" class="text-sm text-indigo-500 hover:text-indigo-600 font-medium flex items-center gap-1.5 mb-3 leading-none">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Dashboard
        </a>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Overdue Follow-ups</h1>
        <p class="text-sm text-slate-400 mt-0.5">7 items require your attention based on inactivity.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative">
            <button onclick="toggleDropdown('followupsExportDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all shadow-sm">
                <i data-lucide="download" class="w-4 h-4 text-slate-400"></i>
                Export
            </button>
            <div id="followupsExportDropdown" class="hidden absolute top-12 right-0 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700/60 z-[100] overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                <div class="p-1.5 space-y-0.5">
                    <button onclick="exportReport('CSV', 'Follow-ups List')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Export as CSV
                    </button>
                    <button onclick="exportReport('Excel', 'Follow-ups List')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i> Export as Excel
                    </button>
                    <button onclick="exportReport('PDF', 'Follow-ups List')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 dark:hover:text-rose-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-type-2" class="w-3.5 h-3.5"></i> Export as PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-slate-50 dark:bg-slate-900 border-b border-slate-100 dark:border-slate-700">
            <tr>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Lead</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Description</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Follow-up Date</th>
                <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
            @foreach($followups as $followup)
            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors group">
                <td class="px-6 py-4">
                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $followup->lead_name }}</p>
                    <p class="text-xs text-slate-400 font-medium">{{ $followup->contact_person }}</p>
                </td>
                <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate" title="{{ $followup->description }}">
                    {{ $followup->description }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex flex-col gap-1">
                        <span class="text-[13px] font-black text-slate-700 dark:text-slate-200 leading-none">
                            {{ $followup->followup_at->format('d M Y') }}
                        </span>
                        <span class="text-[11px] text-slate-400 font-bold leading-none">
                            {{ $followup->followup_at->format('H:i') }}
                        </span>
                        
                        @php
                            $diff = now()->startOfDay()->diffInDays($followup->followup_at->startOfDay(), false);
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
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-100">
                        {{ $followup->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <button class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm border border-transparent hover:border-indigo-100" title="Complete Follow-up">
                            <i data-lucide="check-check" class="w-4 h-4"></i>
                        </button>
                        <form id="delete-followup-{{ $followup->id }}" method="POST" action="{{ route('followups.destroy', $followup->id) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" 
                                    class="swal-delete p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all shadow-sm border border-transparent hover:border-rose-100" 
                                    data-form-id="delete-followup-{{ $followup->id }}"
                                    data-name="follow-up for {{ $followup->lead_name }}"
                                    title="Dismiss">
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
@endsection
