@extends('layouts.app')
@section('title', 'Lead Management — CRM Admin')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Lead Management</h1>
        <p class="text-sm text-slate-400 font-medium">Track and manage leads (Projects)</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('leads.create') }}" class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/25">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add Lead
        </a>
    </div>
</div>

<div class="flex flex-wrap items-center gap-3 mb-8">
    <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'all', 'page' => 1])) }}" class="flex items-center gap-2 px-5 py-2.5 {{ request('status', 'all') === 'all' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-white border border-slate-100 text-slate-500' }} rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
        <i data-lucide="layout-grid" class="w-3.5 h-3.5"></i>
        All <span class="ml-1 opacity-70">{{ $stats->total }}</span>
    </a>
    <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'Pending', 'page' => 1])) }}" class="flex items-center gap-2 px-5 py-2.5 {{ request('status') === 'Pending' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-white border border-slate-100 text-slate-500' }} rounded-2xl text-xs font-bold transition-all">
        <i data-lucide="clock" class="w-3.5 h-3.5 text-amber-500"></i>
        Pending <span class="px-1.5 py-0.5 rounded-md bg-amber-50 text-amber-600 ml-1 text-[10px]">{{ $stats->pending }}</span>
    </a>
    <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'Won', 'page' => 1])) }}" class="flex items-center gap-2 px-5 py-2.5 {{ request('status') === 'Won' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-white border border-slate-100 text-slate-500' }} rounded-2xl text-xs font-bold transition-all">
        <i data-lucide="check-circle" class="w-3.5 h-3.5 text-emerald-500"></i>
        Won <span class="px-1.5 py-0.5 rounded-md bg-emerald-50 text-emerald-600 ml-1 text-[10px]">{{ $stats->won }}</span>
    </a>
    <a href="{{ route('leads.index', array_merge(request()->query(), ['status' => 'Lost', 'page' => 1])) }}" class="flex items-center gap-2 px-5 py-2.5 {{ request('status') === 'Lost' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-white border border-slate-100 text-slate-500' }} rounded-2xl text-xs font-bold transition-all">
        <i data-lucide="x-circle" class="w-3.5 h-3.5 text-rose-500"></i>
        Lost <span class="px-1.5 py-0.5 rounded-md bg-rose-50 text-rose-600 ml-1 text-[10px]">{{ $stats->lost }}</span>
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

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700/50">
                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Project Title</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Customer</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Created</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-700/50">
                @forelse($leads as $lead)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 group transition-colors">
                    <td class="px-6 py-4">
                        <a href="{{ route('leads.show', $lead->id) }}" class="text-sm font-black text-slate-800 dark:text-white hover:text-indigo-600 transition-colors">
                            {{ $lead->project_name }}
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-700 dark:text-slate-300 drop-shadow-sm">{{ $lead->client_name }}</span>
                            <span class="text-[11px] font-medium text-slate-400">{{ $lead->phone ?? '—' }} | {{ $lead->email ?? '—' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $colors = ['Pending' => 'amber', 'Won' => 'emerald', 'Lost' => 'rose'];
                            $c = $colors[$lead->status] ?? 'slate';
                        @endphp
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-{{$c}}-50 text-{{$c}}-600 border border-{{$c}}-100">
                            {{ $lead->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-bold text-slate-400">{{ $lead->created_at->format('M d, Y') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('leads.show', $lead->id) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors" title="View Detail">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('leads.edit', $lead->id) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors" title="Edit">
                                <i data-lucide="edit" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this lead?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium">No leads found. Switch filters or clear search.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($leads->hasPages())
    <div class="px-8 py-6 border-t border-slate-50 dark:border-slate-800/60 bg-slate-50/50 dark:bg-slate-900/50">
        {{ $leads->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
