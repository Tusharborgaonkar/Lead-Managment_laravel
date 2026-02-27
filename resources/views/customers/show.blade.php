@extends('layouts.app')
@section('title', $customer->name . ' — Customer Details')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('customers.index') }}" class="text-sm text-indigo-500 hover:text-indigo-600 font-bold flex items-center gap-1.5 mb-2 transition-colors">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Customers
            </a>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white">{{ $customer->name }}</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium mt-1">{{ $customer->company_name ?? 'No Company' }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('customers.edit', $customer->id) }}" class="px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all shadow-sm">
                Edit Details
            </a>
            <a href="{{ route('leads.create', ['customer_id' => $customer->id]) }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/25 flex items-center gap-2">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Lead (Project)
            </a>
        </div>
    </div>

    <!-- Customer Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 flex flex-shrink-0 items-center justify-center text-indigo-600">
                <i data-lucide="mail" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Email Address</p>
                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $customer->email ?? '—' }}</p>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-100 dark:border-slate-700 shadow-sm flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex flex-shrink-0 items-center justify-center text-emerald-600">
                <i data-lucide="phone" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Phone Number</p>
                <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $customer->phone ?? '—' }}</p>
            </div>
        </div>
    </div>

    <!-- Leads/Projects List -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 dark:border-slate-700/50 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-slate-800 dark:text-white">Projects</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">All ongoing and past projects for this customer</p>
            </div>
        </div>
        
        @if($customer->leads->count() > 0)
        <div class="divide-y divide-slate-50 dark:divide-slate-700/50">
            @foreach($customer->leads as $lead)
            <div class="p-6 md:px-8 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                <div>
                    <a href="{{ route('leads.show', $lead->id) }}" class="text-base font-black text-slate-800 dark:text-white hover:text-indigo-600 transition-colors">
                        {{ $lead->project_name }}
                    </a>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs font-bold text-slate-400"><i data-lucide="calendar" class="w-3.5 h-3.5 inline mr-1"></i>{{ $lead->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @php
                        $statusColors = [
                            'Pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'Won' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'Lost' => 'bg-rose-50 text-rose-600 border-rose-100',
                        ];
                        $statusClass = $statusColors[$lead->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                    @endphp
                    <span class="px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest border {{ $statusClass }}">
                        {{ $lead->status }}
                    </span>
                    <a href="{{ route('leads.show', $lead->id) }}" class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group-hover:scale-105 active:scale-95">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-50 dark:bg-slate-800/50 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="folder-open" class="w-8 h-8 text-slate-300"></i>
            </div>
            <h3 class="text-base font-bold text-slate-700 dark:text-slate-300">No Leads Found</h3>
            <p class="text-sm font-medium text-slate-400 mt-1 max-w-sm mx-auto">This customer doesn't have any projects associated with them yet.</p>
            <a href="{{ route('leads.create', ['customer_id' => $customer->id]) }}" class="inline-flex items-center gap-2 mt-6 px-5 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-bold hover:bg-indigo-100 transition-colors">
                <i data-lucide="plus" class="w-4 h-4"></i> Add First Lead
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
