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
        <div class="relative">
            <button onclick="toggleDropdown('customersExportDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all shadow-sm">
                <i data-lucide="download" class="w-4 h-4 text-slate-400"></i>
                Export
                <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
            </button>
            <div id="customersExportDropdown" class="hidden absolute top-12 right-0 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700/60 z-[100] overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                <div class="p-1.5 space-y-0.5">
                    <button onclick="exportReport('CSV', 'Customers List')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Export as CSV
                    </button>
                    <button onclick="exportReport('Excel', 'Customers List')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i> Export as Excel
                    </button>
                    <button onclick="exportReport('PDF', 'Customers List')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 dark:hover:text-rose-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-type-2" class="w-3.5 h-3.5"></i> Export as PDF
                    </button>
                </div>
            </div>
        </div>
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
            <span class="px-2.5 py-1 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-700">{{ $stats->trend }}</span>
        </div>
        <div class="text-3xl font-black text-slate-800 dark:text-white mb-1">{{ $stats->total }}</div>
        <div class="text-sm font-bold text-slate-400">Total Customers</div>
    </div>

    <!-- Active Customers -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700/60 shadow-sm relative overflow-hidden group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center transition-colors group-hover:bg-indigo-100">
                <i data-lucide="user-check" class="w-6 h-6 text-indigo-600"></i>
            </div>
        </div>
        <div class="text-3xl font-black text-slate-800 dark:text-white mb-1">{{ $stats->active }}</div>
        <div class="text-sm font-bold text-slate-400">Active</div>
    </div>

    <!-- Avg Lifetime Value -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700/60 shadow-sm relative overflow-hidden group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center transition-colors group-hover:bg-amber-100">
                <i data-lucide="dollar-sign" class="w-6 h-6 text-amber-600"></i>
            </div>
        </div>
        <div class="text-3xl font-black text-slate-800 dark:text-white mb-1">{{ $stats->avg_value }}</div>
        <div class="text-sm font-bold text-slate-400">Avg. Lifetime Value</div>
    </div>

    <!-- Retention Rate -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700/60 shadow-sm relative overflow-hidden group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center transition-colors group-hover:bg-blue-100">
                <i data-lucide="refresh-cw" class="w-6 h-6 text-blue-600"></i>
            </div>
        </div>
        <div class="text-3xl font-black text-slate-800 dark:text-white mb-1">{{ $stats->retention }}</div>
        <div class="text-sm font-bold text-slate-400">Retention Rate</div>
    </div>
</div>

<!-- Toolbar -->
<div class="flex flex-wrap items-center gap-4 mb-6">
    <div class="flex items-center gap-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-2.5 flex-1 max-w-md shadow-sm transition-all focus-within:border-slate-400 dark:focus-within:border-slate-500 focus-within:ring-0 focus-within:outline-none">
        <i data-lucide="search" class="w-5 h-5 text-slate-400"></i>
        <input type="text" id="customer-search" oninput="filterCustomers()" placeholder="Search customers..." class="bg-transparent border-none outline-none focus:ring-0 focus:outline-none text-sm text-slate-700 dark:text-slate-300 w-full placeholder:text-slate-400" />
    </div>

    <div class="flex items-center gap-3 ml-auto">
        <select id="filter-group" onchange="filterCustomers()" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 outline-none focus:border-slate-400 dark:focus:border-slate-500 focus:ring-0 shadow-sm transition-all">
            <option value="all">All Groups</option>
            <option value="Millennials">Millennials</option>
            <option value="Generation Z">Generation Z</option>
            <option value="Generation X">Generation X</option>
        </select>
        <select id="filter-status" onchange="filterCustomers()" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 outline-none focus:border-slate-400 dark:focus:border-slate-500 focus:ring-0 shadow-sm transition-all">
            <option value="all">All Status</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <select id="customer-sort" onchange="sortCustomers()" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 outline-none focus:border-slate-400 dark:focus:border-slate-500 focus:ring-0 shadow-sm transition-all">
            <option value="newest">Sort by</option>
            <option value="newest">Newest</option>
            <option value="spent-desc">Spent: High to Low</option>
            <option value="name-asc">Name: A-Z</option>
        </select>
    </div>
</div>

<!-- Customers Table -->
<div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/60 shadow-sm overflow-hidden">
    <div class="crm-table-wrapper overflow-x-auto">
        <div id="customers-table"></div>
    </div>
    @if($customers->hasPages())
    <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800/60 bg-slate-50/50 dark:bg-slate-900/50">
        {{ $customers->links() }}
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
        $initials = collect(explode(' ', $customer->name))->map(fn($n) => substr($n, 0, 1))->join('');
        $colorMap = [
            'indigo' => 'bg-indigo-500 text-white',
            'emerald' => 'bg-emerald-500 text-white',
            'orange' => 'bg-orange-500 text-white',
            'rose' => 'bg-rose-500 text-white',
            'slate' => 'bg-slate-500 text-white',
        ];
        return [
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'initials' => strtoupper($initials),
            'avatar_class' => $colorMap[$customer->avatar_color] ?? 'bg-indigo-500 text-white',
            'company' => $customer->company,
            'group' => $customer->group,
            'status' => $customer->status,
            'spent' => '$' . number_format($customer->total_spent, 2),
            'spent_raw' => $customer->total_spent,
            'orders' => $customer->total_orders,
            'rating' => number_format($customer->rating, 1),
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
                    '<div class="w-10 h-10 rounded-xl ' + d.avatar_class + ' flex items-center justify-center font-bold text-xs ring-2 ring-white dark:ring-slate-700 shadow-sm">' + d.initials + '</div>' +
                    '<div><p class="font-bold text-slate-800 dark:text-white leading-tight mb-0.5">' + d.name + '</p>' +
                    '<p class="text-xs text-slate-400 font-medium">' + d.email + '</p></div>' +
                '</div>';
            }
        },
        {
            title: 'Company',
            field: 'company',
            minWidth: 120,
            formatter: function(cell) {
                return '<span class="text-slate-600 dark:text-slate-300 font-medium">' + (cell.getValue() || '') + '</span>';
            }
        },
        {
            title: 'Group',
            field: 'group',
            minWidth: 130,
            formatter: function(cell) {
                var val = cell.getValue() || '';
                return '<span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20">' + val + '</span>';
            }
        },
        {
            title: 'Status',
            field: 'status',
            minWidth: 100,
            formatter: function(cell) {
                var val = cell.getValue() || '';
                var isActive = val === 'active';
                var cls = isActive ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 border-emerald-100 dark:border-emerald-500/20' : 'bg-slate-50 dark:bg-slate-500/10 text-slate-500 border-slate-100 dark:border-slate-500/20';
                return '<span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest ' + cls + ' border">' + val + '</span>';
            }
        },
        {
            title: 'Spent',
            field: 'spent_raw',
            minWidth: 100,
            formatter: function(cell) {
                var d = cell.getData();
                return '<span class="font-bold text-slate-800 dark:text-white">' + d.spent + '</span>';
            }
        },
        {
            title: 'Orders',
            field: 'orders',
            minWidth: 80,
            formatter: function(cell) {
                return '<span class="text-slate-600 dark:text-slate-400 font-medium">' + (cell.getValue() || 0) + '</span>';
            }
        },
        {
            title: 'Rating',
            field: 'rating',
            minWidth: 80,
            formatter: function(cell) {
                return '<div class="flex items-center gap-1.5"><i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i><span class="font-bold text-slate-800 dark:text-white">' + cell.getValue() + '</span></div>';
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

function filterCustomers() {
    if (!customersTable) return;
    var search = document.getElementById('customer-search').value.toLowerCase();
    var group = document.getElementById('filter-group').value;
    var status = document.getElementById('filter-status').value;

    customersTable.setFilter(function(data) {
        var matchesSearch = !search ||
            data.name.toLowerCase().includes(search) ||
            data.email.toLowerCase().includes(search);
        var matchesGroup = group === 'all' || data.group === group;
        var matchesStatus = status === 'all' || data.status === status;
        return matchesSearch && matchesGroup && matchesStatus;
    });
}

function sortCustomers() {
    if (!customersTable) return;
    var sortBy = document.getElementById('customer-sort').value;

    if (sortBy === 'name-asc') {
        customersTable.setSort('name', 'asc');
    } else if (sortBy === 'spent-desc') {
        customersTable.setSort('spent_raw', 'desc');
    } else {
        customersTable.setSort('id', 'desc');
    }
}
</script>
@endpush

