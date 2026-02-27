@extends('layouts.app')
@section('title', 'Roles & Permissions — CRM Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Roles &amp; Permissions</h1>
        <p class="text-sm text-slate-400 mt-0.5">{{ $roles->count() }} roles defined</p>
    </div>
    <a href="{{ route('users.index') }}"
       class="flex items-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-semibold text-sm hover:bg-slate-200 transition">
        <i data-lucide="user-cog" class="w-4 h-4"></i> Manage Users
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5 mb-6">
    @foreach($roles as $role)
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-5">
        <div class="flex items-start justify-between mb-3">
            <div>
                <h2 class="text-base font-bold text-slate-800 dark:text-white">{{ $role->name }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ $role->users_count }} {{ Str::plural('user', $role->users_count) }}</p>
            </div>
            @if($role->users_count === 0)
            <form method="POST" action="{{ route('users.roles.destroy', $role->id) }}" data-confirm="Delete role: {{ $role->name }}?">

                @csrf @method('DELETE')
                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete role">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </form>
            @endif
        </div>
        @if($role->permissions)
        <div class="flex flex-wrap gap-1.5">
            @foreach($role->permissions as $perm)
            @if($perm === '*')
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-700">Full Access</span>
            @else
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500">{{ $perm }}</span>
            @endif
            @endforeach
        </div>
        @endif
    </div>
    @endforeach
</div>

{{-- Add New Role --}}
<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6">
    <h2 class="text-sm font-bold text-slate-700 dark:text-white mb-4">Create New Role</h2>
    <form method="POST" action="{{ route('users.roles.store') }}" class="flex gap-3 flex-wrap">
        @csrf
        <input type="text" name="name" placeholder="Role name (e.g. Supervisor)" required
               class="flex-1 min-w-40 px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
        <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-violet-600 text-white rounded-xl font-bold text-sm hover:from-indigo-600 hover:to-violet-700 transition shadow-lg shadow-indigo-500/25">
            Create Role
        </button>
    </form>
</div>
@endsection
