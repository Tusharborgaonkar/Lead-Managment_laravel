@extends('layouts.app')
@section('title', 'All Follow-ups — CRM Admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <a href="{{ route('dashboard') }}" class="text-sm text-indigo-500 hover:text-indigo-600 font-medium flex items-center gap-1.5 mb-3 leading-none">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Dashboard
        </a>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">All Follow-ups</h1>
        <p class="text-sm text-slate-400 mt-0.5">All scheduled follow-ups across your pipeline.</p>
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
        <a href="{{ route('followups.create') }}" class="flex items-center gap-2.5 px-6 py-2.5 bg-indigo-600 text-white rounded-2xl text-sm font-black shadow-lg shadow-indigo-500/25 hover:bg-indigo-700 transition active:scale-95">
            <i data-lucide="plus" class="w-4 h-4"></i>
            New Follow-up
        </a>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="crm-table-wrapper overflow-x-auto">
        <div id="followups-table"></div>
    </div>
    @if($followups->hasPages())
    <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800/60 bg-slate-50/50 dark:bg-slate-900/50">
        {{ $followups->links() }}
    </div>
    @endif
</div>

{{-- Hidden delete forms for SweetAlert --}}
@foreach($followups as $followup)
<form id="delete-followup-{{ $followup->id }}" method="POST" action="{{ route('followups.destroy', $followup->id) }}" class="hidden">
    @csrf @method('DELETE')
</form>
@endforeach

@php
    $followupsData = $followups->map(function($followup) {
        $diff = now()->startOfDay()->diffInDays($followup->scheduled_at->startOfDay(), false);
        $badgeClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
        $text = "in $diff days";
        if ($diff == 0) { $badgeClass = 'bg-amber-50 text-amber-600 border-amber-100'; $text = 'Today'; }
        elseif ($diff == 1) { $badgeClass = 'bg-amber-50 text-amber-600 border-amber-100'; $text = 'Tomorrow'; }
        elseif ($diff < 0) { $badgeClass = 'bg-rose-50 text-rose-600 border-rose-100'; $text = $diff == -1 ? 'Yesterday' : abs($diff) . ' days ago'; }

        return [
            'id' => $followup->id,
            'lead_name' => $followup->lead->name ?? $followup->customer->name ?? 'N/A',
            'contact_person' => $followup->lead->company ?? $followup->customer->company ?? 'N/A',
            'description' => $followup->description,
            'followup_date' => $followup->scheduled_at->format('d M Y'),
            'followup_time' => $followup->scheduled_at->format('H:i'),
            'followup_badge_class' => $badgeClass,
            'followup_badge_text' => $text,
            'status' => $followup->status,
        ];
    })->values();
@endphp

@push('scripts')
<script>
var followupsData = @json($followupsData);

document.addEventListener('DOMContentLoaded', function() {
    createCRMTable('#followups-table', [
        {
            title: 'Lead',
            field: 'lead_name',
            minWidth: 160,
            formatter: function(cell) {
                var d = cell.getData();
                return '<p class="text-sm font-bold text-slate-700 dark:text-slate-200">' + d.lead_name + '</p>' +
                       '<p class="text-xs text-slate-400 font-medium">' + d.contact_person + '</p>';
            }
        },
        {
            title: 'Description',
            field: 'description',
            minWidth: 200,
            formatter: function(cell) {
                var val = cell.getValue() || '';
                return '<span class="text-sm text-slate-500 block max-w-xs truncate" title="' + val.replace(/"/g, '&quot;') + '">' + val + '</span>';
            }
        },
        {
            title: 'Follow-up Date',
            field: 'followup_date',
            minWidth: 150,
            formatter: function(cell) {
                var d = cell.getData();
                return '<div class="flex flex-col gap-1">' +
                    '<span class="text-[13px] font-black text-slate-700 dark:text-slate-200 leading-none">' + d.followup_date + '</span>' +
                    '<span class="text-[11px] text-slate-400 font-bold leading-none">' + d.followup_time + '</span>' +
                    '<div class="mt-1"><span class="px-2.5 py-1 rounded-lg text-[10px] font-black ' + d.followup_badge_class + ' border inline-block">' + d.followup_badge_text + '</span></div>' +
                '</div>';
            }
        },
        {
            title: 'Status',
            field: 'status',
            minWidth: 110,
            formatter: function(cell) {
                var val = cell.getValue() || '';
                return '<span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 border border-rose-100">' + val + '</span>';
            }
        },
        {
            title: 'Actions',
            field: 'id',
            headerSort: false,
            hozAlign: 'right',
            minWidth: 100,
            formatter: function(cell) {
                var d = cell.getData();
                return '<div class="flex items-center justify-end gap-2">' +
                    '<a href="/followups/' + d.id + '/edit" class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm border border-transparent hover:border-indigo-100" title="Edit Follow-up"><i data-lucide="pencil" class="w-4 h-4"></i></a>' +
                    '<button type="button" class="swal-delete p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all shadow-sm border border-transparent hover:border-rose-100" data-form-id="delete-followup-' + d.id + '" data-name="follow-up for ' + d.lead_name + '" title="Delete"><i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i></button>' +
                '</div>';
            }
        }
    ], followupsData);
});
</script>
@endpush
@endsection

