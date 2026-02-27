@extends('layouts.app')
@section('title', 'Customer Management — CRM Admin')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Customer Management</h1>
        <p class="text-sm text-slate-400 mt-1">View and manage your customer relationships</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('customers.create') }}" class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/25">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add Customer
        </a>
    </div>
</div>

<!-- Stats Dashboard -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Customers -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700/60 shadow-sm relative overflow-hidden group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center transition-colors group-hover:bg-emerald-100">
                <i data-lucide="users" class="w-6 h-6 text-emerald-600"></i>
            </div>
        </div>
        <div class="text-3xl font-black text-slate-800 dark:text-white mb-1">{{ $stats->total }}</div>
        <div class="text-sm font-bold text-slate-400">Total Customers</div>
    </div>
</div>

<!-- Toolbar -->
<div class="flex flex-wrap items-center gap-4 mb-6">
    <form action="{{ route('customers.index') }}" method="GET" class="flex items-center gap-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-2.5 flex-1 max-w-md shadow-sm transition-all focus-within:border-slate-400 dark:focus-within:border-slate-500 focus-within:ring-0 focus-within:outline-none">
        @foreach(request()->except('search', 'page') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <i data-lucide="search" class="w-5 h-5 text-slate-400"></i>
        <input type="text" name="search" id="customer-search" value="{{ request('search') }}" placeholder="Search customers..." class="bg-transparent border-none outline-none focus:ring-0 focus:outline-none text-sm text-slate-700 dark:text-slate-300 w-full placeholder:text-slate-400" />
    </form>
</div>

<!-- Customers Table -->
<div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/60 shadow-sm overflow-hidden">
    <div class="crm-table-wrapper overflow-x-auto">
        <div id="customers-table"></div>
    </div>
    @if($customers->hasPages())
    <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800/60 bg-slate-50/50 dark:bg-slate-900/50">
        {{ $customers->appends(request()->query())->links() }}
    </div>
    @endif
</div>

{{-- Hidden delete forms for SweetAlert --}}
@foreach($customers as $customer)
<form id="delete-form-{{ $customer->id }}" action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="hidden">
    @csrf @method('DELETE')
</form>
@endforeach

@endsection

@php
    $customersData = $customers->map(function($customer) {
        $initials = collect(explode(' ', $customer->name))->map(fn($n) => substr($n, 0, 1))->take(2)->join('');
        return [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'initials' => strtoupper($initials),
            'company' => $customer->company_name,
            'phone' => $customer->phone,
            'show_url' => route('customers.show', $customer->id),
            'edit_url' => route('customers.edit', $customer->id),
        ];
    })->values();
@endphp

@push('scripts')
<script>
var customersTable;

var customersData = @json($customersData);

document.addEventListener('DOMContentLoaded', function() {
    customersTable = createCRMTable('#customers-table', [
        {
            title: 'Customer',
            field: 'name',
            minWidth: 220,
            formatter: function(cell) {
                var d = cell.getData();
                return '<div class="flex items-center gap-4">' +
                    '<div class="w-10 h-10 rounded-xl bg-indigo-500 text-white flex items-center justify-center font-bold text-xs ring-2 ring-white dark:ring-slate-700 shadow-sm">' + d.initials + '</div>' +
                    '<div><a href="' + d.show_url + '" class="font-bold text-indigo-600 dark:text-indigo-400 leading-tight mb-0.5 hover:underline">' + d.name + '</a>' +
                    '<p class="text-xs text-slate-400 font-medium">' + (d.email || 'No email') + '</p></div>' +
                '</div>';
            }
        },
        {
            title: 'Company',
            field: 'company',
            minWidth: 150,
            formatter: function(cell) {
                return '<span class="text-slate-600 dark:text-slate-300 font-medium">' + (cell.getValue() || '-') + '</span>';
            }
        },
        {
            title: 'Phone',
            field: 'phone',
            minWidth: 150,
            formatter: function(cell) {
                return '<span class="text-slate-600 dark:text-slate-300 font-medium">' + (cell.getValue() || '-') + '</span>';
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
                    '<a href="' + d.edit_url + '" class="p-2 rounded-xl text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/40 transition-all shadow-sm border border-transparent hover:border-blue-100"><i data-lucide="edit-3" class="w-4 h-4"></i></a>' +
                    '<button type="button" class="swal-delete p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/40 transition-all shadow-sm border border-transparent hover:border-rose-100" data-form-id="delete-form-' + d.id + '" data-name="' + d.name + '" title="Delete Customer"><i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i></button>' +
                '</div>';
            }
        }
    ], customersData);
});
</script>
@endpush
