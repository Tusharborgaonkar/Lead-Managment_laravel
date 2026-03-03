@extends('layouts.app')
@section('title', 'Lead Management — CRM Admin')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Lead Management</h1>
        <p class="text-sm text-slate-400 font-medium">Track and manage leads by category</p>
    </div>
    <div class="flex items-center gap-3">
        <button class="flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 rounded-[0.8rem] font-bold text-sm hover:bg-slate-50 transition shadow-sm">
            <i data-lucide="download" class="w-4 h-4"></i>
            Export
        </button>
        <a href="{{ route('leads.create') }}" class="flex items-center gap-2 px-6 py-2.5 bg-[#7c3aed] text-white rounded-[0.8rem] font-bold text-sm hover:bg-purple-700 transition shadow-lg shadow-purple-500/25">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add Lead
        </a>
    </div>
</div>

{{-- KPI Cards --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <!-- Card 1: Total Leads -->
    <div class="bg-white dark:bg-slate-800 rounded-[1.2rem] p-5 border border-slate-100 dark:border-slate-700/60 shadow-sm flex flex-col justify-between h-36">
        <div class="flex justify-between items-start">
            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-500/10 flex items-center justify-center text-purple-500">
                <i data-lucide="target" class="w-5 h-5"></i>
            </div>
            <div class="px-2 py-1 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500 text-[10px] font-black tracking-wide rounded-full">
                +15%
            </div>
        </div>
        <div class="mt-4">
            <h3 class="text-2xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->total }}</h3>
            <p class="text-[11px] font-bold text-slate-400">Total Leads</p>
        </div>
    </div>
    <!-- Card 2: Not Interested -->
    <div class="bg-white dark:bg-slate-800 rounded-[1.2rem] p-5 border border-slate-100 dark:border-slate-700/60 shadow-sm flex flex-col justify-between h-36">
         <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-500">
             <i data-lucide="x-circle" class="w-5 h-5"></i>
         </div>
         <div class="mt-4">
            <h3 class="text-2xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->lost }}</h3>
            <p class="text-[11px] font-bold text-slate-400">Not Interested</p>
         </div>
    </div>
    <!-- Card 3: Followup -->
    <div class="bg-white dark:bg-slate-800 rounded-[1.2rem] p-5 border border-slate-100 dark:border-slate-700/60 shadow-sm flex flex-col justify-between h-36">
         <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-500">
             <i data-lucide="phone-call" class="w-5 h-5"></i>
         </div>
         <div class="mt-4">
            <h3 class="text-2xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->followup }}</h3>
            <p class="text-[11px] font-bold text-slate-400">Followup</p>
         </div>
    </div>
    <!-- Card 4: Pending -->
    <div class="bg-white dark:bg-slate-800 rounded-[1.2rem] p-5 border border-slate-100 dark:border-slate-700/60 shadow-sm flex flex-col justify-between h-36">
         <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-500 border border-indigo-100 border-opacity-50">
             <i data-lucide="clock" class="w-5 h-5"></i>
         </div>
         <div class="mt-4">
            <h3 class="text-2xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->pending }}</h3>
            <p class="text-[11px] font-bold text-slate-400">Pending</p>
         </div>
    </div>
    <!-- Card 5: Confirm -->
    <div class="bg-white dark:bg-slate-800 rounded-[1.2rem] p-5 border border-slate-100 dark:border-slate-700/60 shadow-sm flex flex-col justify-between h-36">
         <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-500">
             <i data-lucide="check-circle" class="w-5 h-5"></i>
         </div>
         <div class="mt-4">
            <h3 class="text-2xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ $stats->won }}</h3>
            <p class="text-[11px] font-bold text-slate-400">Confirm</p>
         </div>
    </div>
</div>

{{-- Filters Component --}}
<div class="flex flex-wrap items-center gap-3 mb-8">
    <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'all', 'page' => 1])) }}" class="flex items-center gap-2 px-4 py-2 {{ request('status', 'all') == 'all' ? 'bg-[#7c3aed] text-white shadow-md shadow-purple-500/20 border-transparent' : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50' }} border rounded-[0.8rem] text-sm font-bold transition-all">
        <i data-lucide="clipboard-list" class="w-4 h-4 {{ request('status', 'all') == 'all' ? 'text-white' : 'text-[#7c3aed]' }}"></i>
        All Leads <span class="{{ request('status', 'all') == 'all' ? 'bg-white/20' : 'bg-slate-100 dark:bg-slate-700 text-slate-500' }} ml-1 px-2 py-0.5 rounded-full text-xs shrink-0">{{ $stats->total }}</span>
    </a>
    
    <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'Not Interested', 'page' => 1])) }}" class="flex items-center gap-2 px-4 py-2 {{ request('status') == 'Not Interested' ? 'bg-[#7c3aed] text-white shadow-md shadow-purple-500/20 border-transparent' : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50' }} border rounded-[0.8rem] text-sm font-bold transition-all">
        <i data-lucide="x" class="w-4 h-4 {{ request('status') == 'Not Interested' ? 'text-white' : 'text-rose-500' }}"></i>
        Not Interested <span class="{{ request('status') == 'Not Interested' ? 'bg-white/20' : 'bg-rose-50 dark:bg-rose-500/10 text-rose-500' }} ml-1 px-2 py-0.5 rounded-full text-xs shrink-0">{{ $stats->lost }}</span>
    </a>
    
    <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'Followup', 'page' => 1])) }}" class="flex items-center gap-2 px-4 py-2 {{ request('status') == 'Followup' ? 'bg-[#7c3aed] text-white shadow-md shadow-purple-500/20 border-transparent' : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50' }} border rounded-[0.8rem] text-sm font-bold transition-all">
        <i data-lucide="phone-call" class="w-4 h-4 {{ request('status') == 'Followup' ? 'text-white' : 'text-amber-500' }}"></i>
        Followup <span class="{{ request('status') == 'Followup' ? 'bg-white/20' : 'bg-amber-50 dark:bg-amber-500/10 text-amber-500' }} ml-1 px-2 py-0.5 rounded-full text-xs shrink-0">{{ $stats->followup }}</span>
    </a>
    
    <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'Pending', 'page' => 1])) }}" class="flex items-center gap-2 px-4 py-2 {{ request('status') == 'Pending' ? 'bg-[#7c3aed] text-white shadow-md shadow-purple-500/20 border-transparent' : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50' }} border rounded-[0.8rem] text-sm font-bold transition-all">
        <i data-lucide="clock" class="w-4 h-4 {{ request('status') == 'Pending' ? 'text-white' : 'text-slate-400' }}"></i>
        Pending <span class="{{ request('status') == 'Pending' ? 'bg-white/20' : 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-500' }} ml-1 px-2 py-0.5 rounded-full text-xs shrink-0">{{ $stats->pending }}</span>
    </a>
    
    <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'Confirm', 'page' => 1])) }}" class="flex items-center gap-2 px-4 py-2 {{ request('status') == 'Confirm' ? 'bg-[#7c3aed] text-white shadow-md shadow-purple-500/20 border-transparent' : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50' }} border rounded-[0.8rem] text-sm font-bold transition-all">
        <i data-lucide="check-square" class="w-4 h-4 {{ request('status') == 'Confirm' ? 'text-white' : 'text-emerald-500' }}"></i>
        Confirm <span class="{{ request('status') == 'Confirm' ? 'bg-white/20' : 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500' }} ml-1 px-2 py-0.5 rounded-full text-xs shrink-0">{{ $stats->won }}</span>
    </a>
</div>

<div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/60 shadow-sm overflow-hidden">
    <div class="px-8 py-6 border-b border-slate-50 dark:border-slate-800/60 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-black text-slate-800 dark:text-white">Leads Overview</h2>
            <p class="text-xs text-slate-400 font-medium">Search across project titles and customer names</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('leads.index') }}" method="GET" class="relative min-w-[240px]">
                @foreach(request()->except('search', 'page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search leads..." class="w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800/50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all">
            </form>
        </div>
    </div>

    <div class="crm-table-wrapper overflow-x-auto">
        <div id="leads-table"></div>
    </div>

    @if($leads->hasPages())
    <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800/60 bg-slate-50/50 dark:bg-slate-900/50">
        {{ $leads->appends(request()->query())->links() }}
    </div>
    @endif
</div>

{{-- Hidden delete forms for SweetAlert --}}
@foreach($leads as $lead)
<form id="delete-form-{{ $lead->id }}" action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>
@endforeach

@endsection

@php
    $leadsData = $leads->map(function($lead) {
        return [
            'id' => $lead->id,
            'project_name' => $lead->project_name,
            'client_name' => $lead->client_name,
            'email' => $lead->email,
            'phone' => $lead->phone,
            'status' => $lead->status,
            'created_at' => $lead->created_at->format('M d, Y'),
            'show_url' => route('leads.show', $lead->id),
            'edit_url' => route('leads.edit', $lead->id),
            'update_status_url' => route('leads.updateStatus', $lead->id),
            'csrf' => csrf_token(),
        ];
    })->values();
@endphp

@push('scripts')
<script>
var leadsTable;

var leadsData = @json($leadsData);

document.addEventListener('DOMContentLoaded', function() {
    leadsTable = createCRMTable('#leads-table', [
        {
            title: 'Project Title',
            field: 'project_name',
            minWidth: 200,
            formatter: function(cell) {
                var d = cell.getData();
                return '<a href="' + d.show_url + '" class="text-sm font-black text-slate-800 dark:text-white hover:text-indigo-600 transition-colors">' + d.project_name + '</a>';
            }
        },
        {
            title: 'Customer',
            field: 'client_name',
            minWidth: 220,
            formatter: function(cell) {
                var d = cell.getData();
                return '<div class="flex flex-col">' +
                    '<span class="text-sm font-bold text-slate-700 dark:text-slate-300 drop-shadow-sm">' + d.client_name + '</span>' +
                    '<span class="text-[11px] font-medium text-slate-400">' + (d.phone || '—') + ' | ' + (d.email || '—') + '</span>' +
                '</div>';
            }
        },
        {
            title: 'Status',
            field: 'status',
            minWidth: 160,
            formatter: function(cell) {
                var d = cell.getData();
                var colors = { 'Pending': 'amber', 'Confirm': 'emerald', 'Not Interested': 'rose', 'Followup': 'indigo' };
                var c = colors[d.status] || 'slate';
                
                var optionsHtml = '';
                var statuses = ['Pending', 'Followup', 'Confirm', 'Not Interested'];
                statuses.forEach(function(s) {
                    optionsHtml += '<option class="text-slate-700 bg-white" value="' + s + '" ' + (d.status === s ? 'selected' : '') + '>' + s + '</option>';
                });

                return '<form action="' + d.update_status_url + '" method="POST" class="m-0 inline-block w-full">' +
                    '<input type="hidden" name="_token" value="' + d.csrf + '">' +
                    '<input type="hidden" name="_method" value="PATCH">' +
                    '<select name="status" onchange="this.form.submit()" class="w-full px-2.5 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-' + c + '-50 text-' + c + '-600 border border-' + c + '-100 focus:ring-0 focus:outline-none cursor-pointer pr-6 hover:bg-' + c + '-100 transition-colors">' +
                        optionsHtml +
                    '</select>' +
                '</form>';
            }
        },
        {
            title: 'Created',
            field: 'created_at',
            minWidth: 120,
            formatter: function(cell) {
                return '<span class="text-xs font-bold text-slate-400">' + cell.getValue() + '</span>';
            }
        },
        {
            title: 'Actions',
            field: 'id',
            headerSort: false,
            hozAlign: 'right',
            minWidth: 140,
            formatter: function(cell) {
                var d = cell.getData();
                return '<div class="flex items-center justify-end gap-2">' +
                    '<a href="' + d.show_url + '" class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/40 transition-all shadow-sm border border-transparent hover:border-indigo-100"><i data-lucide="eye" class="w-4 h-4"></i></a>' +
                    '<a href="' + d.edit_url + '" class="p-2 rounded-xl text-slate-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/40 transition-all shadow-sm border border-transparent hover:border-amber-100"><i data-lucide="edit-3" class="w-4 h-4"></i></a>' +
                    '<button type="button" class="swal-delete p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/40 transition-all shadow-sm border border-transparent hover:border-rose-100" data-form-id="delete-form-' + d.id + '" data-name="' + d.project_name + '" title="Delete Lead"><i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i></button>' +
                '</div>';
            }
        }
    ], leadsData);
});
</script>
@endpush
