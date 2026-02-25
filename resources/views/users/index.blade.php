@extends('layouts.app')
@section('title', 'Users — CRM Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Users</h1>
        <p class="text-sm text-slate-400 mt-0.5">{{ $users->count() }} total users</p>
    </div>
    <a href="{{ route('users.roles') }}"
       class="flex items-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-semibold text-sm hover:bg-slate-200 transition">
        <i data-lucide="shield" class="w-4 h-4"></i> Manage Roles
    </a>
</div>

{{-- Filters --}}
<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-4 mb-4 flex gap-4 flex-wrap">
    <input type="text" id="filterSearch" placeholder="Search name, email…"
           class="flex-1 min-w-40 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
    <select id="filterRole" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
        <option value="">All Roles</option>
        @foreach($roles as $role)
        <option value="{{ $role->name }}">{{ $role->name }}</option>
        @endforeach
    </select>
    <select id="filterStatus" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
        <option value="">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="crm-table-wrapper overflow-x-auto">
        <div id="users-table"></div>
    </div>
</div>

{{-- Hidden delete forms for SweetAlert --}}
@foreach($users as $user)
@if(auth()->id() !== $user->id)
<form id="delete-user-{{ $user->id }}" method="POST" action="{{ route('users.destroy', $user->id) }}" class="hidden">
    @csrf @method('DELETE')
</form>
@endif
@endforeach

@php
    $usersData = $users->map(function($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'initials' => strtoupper(substr($user->name, 0, 2)),
            'email' => $user->email,
            'role' => $user->role ? $user->role->name : 'No Role',
            'status' => $user->status,
            'joined' => $user->created_at->format('M d, Y'),
        ];
    })->values();
@endphp

@push('scripts')
<script>
var usersTable;
var authUserId = {{ auth()->id() }};

var usersData = @json($usersData);

document.addEventListener('DOMContentLoaded', function() {
    usersTable = createCRMTable('#users-table', [
        {
            title: 'User',
            field: 'name',
            minWidth: 180,
            formatter: function(cell) {
                var d = cell.getData();
                return '<div class="flex items-center gap-3">' +
                    '<div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">' + d.initials + '</div>' +
                    '<span class="font-semibold text-slate-800 dark:text-white">' + d.name + '</span>' +
                '</div>';
            }
        },
        {
            title: 'Email',
            field: 'email',
            minWidth: 200,
            formatter: function(cell) {
                return '<span class="text-slate-500">' + (cell.getValue() || '') + '</span>';
            }
        },
        {
            title: 'Role',
            field: 'role',
            minWidth: 120,
            formatter: function(cell) {
                var val = cell.getValue() || 'No Role';
                return '<span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">' + val + '</span>';
            }
        },
        {
            title: 'Status',
            field: 'status',
            minWidth: 100,
            formatter: function(cell) {
                var val = cell.getValue() || '';
                var isActive = val === 'active';
                var cls = isActive ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500';
                return '<span class="px-2.5 py-1 rounded-full text-xs font-semibold ' + cls + '">' + val.charAt(0).toUpperCase() + val.slice(1) + '</span>';
            }
        },
        {
            title: 'Joined',
            field: 'joined',
            minWidth: 120,
            formatter: function(cell) {
                return '<span class="text-slate-400">' + (cell.getValue() || '') + '</span>';
            }
        },
        {
            title: 'Actions',
            field: 'id',
            headerSort: false,
            hozAlign: 'right',
            minWidth: 80,
            formatter: function(cell) {
                var d = cell.getData();
                if (d.id === authUserId) {
                    return '<span class="text-xs text-slate-300">You</span>';
                }
                return '<button type="button" class="swal-delete p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" data-form-id="delete-user-' + d.id + '" data-name="' + d.name + '" title="Delete User"><i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i></button>';
            }
        }
    ], usersData);

    // Wire existing filter inputs to Tabulator
    var searchEl = document.getElementById('filterSearch');
    var roleEl = document.getElementById('filterRole');
    var statusEl = document.getElementById('filterStatus');

    function applyFilters() {
        if (!usersTable) return;
        var q = searchEl.value.toLowerCase();
        var r = roleEl.value.toLowerCase();
        var s = statusEl.value.toLowerCase();

        usersTable.setFilter(function(data) {
            var nameMatch = !q || data.name.toLowerCase().includes(q) || data.email.toLowerCase().includes(q);
            var roleMatch = !r || data.role.toLowerCase() === r;
            var statusMatch = !s || data.status === s;
            return nameMatch && roleMatch && statusMatch;
        });
    }

    searchEl.addEventListener('input', applyFilters);
    roleEl.addEventListener('input', applyFilters);
    statusEl.addEventListener('input', applyFilters);
});
</script>
@endpush
@endsection
