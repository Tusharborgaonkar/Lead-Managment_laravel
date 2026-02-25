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
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700 text-left">
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Customer</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Company</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Group</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Spent</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Orders</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Rating</th>
                    <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="customers-tbody" class="divide-y divide-slate-50 dark:divide-slate-700/50">
                @foreach($customers as $customer)
                <tr class="customer-row hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors group" 
                    data-id="{{ $customer->id }}"
                    data-name="{{ strtolower($customer->name) }}" 
                    data-email="{{ strtolower($customer->email) }}"
                    data-group="{{ $customer->group }}" 
                    data-status="{{ strtolower($customer->status) }}"
                    data-spent="{{ $customer->spent_raw }}"
                    data-orders="{{ $customer->orders }}"
                    data-rating="{{ $customer->rating }}">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-4">
                            @php
                                $initials = collect(explode(' ', $customer->name))->map(fn($n) => substr($n, 0, 1))->join('');
                                $colorMap = [
                                    'indigo' => 'bg-indigo-500 text-white',
                                    'emerald' => 'bg-emerald-500 text-white',
                                    'orange' => 'bg-orange-500 text-white',
                                    'rose' => 'bg-rose-500 text-white',
                                    'slate' => 'bg-slate-500 text-white',
                                ];
                            @endphp
                            <div class="w-10 h-10 rounded-xl {{ $colorMap[$customer->avatar_color] ?? 'bg-indigo-500 text-white' }} flex items-center justify-center font-bold text-xs ring-2 ring-white dark:ring-slate-700 shadow-sm">
                                {{ strtoupper($initials) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 dark:text-white leading-tight mb-0.5">{{ $customer->name }}</p>
                                <p class="text-xs text-slate-400 font-medium">{{ $customer->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-slate-600 dark:text-slate-300 font-medium">{{ $customer->company }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20">
                            {{ $customer->group }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $customer->status === 'active' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600' : 'bg-slate-50 dark:bg-slate-500/10 text-slate-500' }} border {{ $customer->status === 'active' ? 'border-emerald-100 dark:border-emerald-500/20' : 'border-slate-100 dark:border-slate-500/20' }}">
                            {{ $customer->status }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="font-bold text-slate-800 dark:text-white">{{ $customer->spent }}</span>
                    </td>
                    <td class="px-6 py-5 text-slate-600 dark:text-slate-400 font-medium">
                        {{ $customer->orders }}
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="star" class="w-4 h-4 text-amber-400 fill-amber-400"></i>
                            <span class="font-bold text-slate-800 dark:text-white">{{ number_format($customer->rating, 1) }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('customers.show', $customer->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/40 transition-all shadow-sm border border-transparent hover:border-indigo-100">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/40 transition-all shadow-sm border border-transparent hover:border-blue-100">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <button type="button" 
                                    class="swal-delete p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/40 transition-all shadow-sm border border-transparent hover:border-rose-100" 
                                    data-form-id="delete-form-{{ $customer->id }}"
                                    data-name="{{ $customer->name }}"
                                    title="Delete Customer">
                                <i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i>
                            </button>
                            <form id="delete-form-{{ $customer->id }}" action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function filterCustomers() {
    const search = document.getElementById('customer-search').value.toLowerCase();
    const group = document.getElementById('filter-group').value;
    const status = document.getElementById('filter-status').value;
    const rows = document.querySelectorAll('.customer-row');

    rows.forEach(row => {
        const name = row.dataset.name;
        const email = row.dataset.email;
        const cGroup = row.dataset.group;
        const cStatus = row.dataset.status;

        const matchesSearch = name.includes(search) || email.includes(search);
        const matchesGroup = group === 'all' || cGroup === group;
        const matchesStatus = status === 'all' || cStatus === status;

        if (matchesSearch && matchesGroup && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });

    // Handle empty state if needed
    const visibleRows = Array.from(rows).filter(r => r.style.display !== 'none');
    // Show/hide no results row if you had one
}

function sortCustomers() {
    const sortBy = document.getElementById('customer-sort').value;
    const tbody = document.getElementById('customers-tbody');
    const rows = Array.from(tbody.querySelectorAll('.customer-row'));

    rows.sort((a, b) => {
        if (sortBy === 'name-asc') {
            return a.dataset.name.localeCompare(b.dataset.name);
        } else if (sortBy === 'spent-desc') {
            return parseFloat(b.dataset.spent) - parseFloat(a.dataset.spent);
        } else {
            // Newest (ID desc as proxy for static)
            return parseInt(b.dataset.id || 0) - parseInt(a.dataset.id || 0);
        }
    });

    rows.forEach(row => tbody.appendChild(row));
}

</script>
@endpush
