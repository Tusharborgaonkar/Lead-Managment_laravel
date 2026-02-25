@extends('layouts.app')
@section('title', $customer->name . ' — Customer')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <a href="{{ route('customers.index') }}" class="text-sm text-indigo-500 hover:text-indigo-600 font-medium flex items-center gap-1.5 mb-3">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Customers
            </a>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white">{{ $customer->name }}</h1>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 space-y-5">
        <div class="grid grid-cols-2 gap-5">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status</span>
                <div class="mt-1">
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $customer->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                        {{ ucfirst($customer->status) }}
                    </span>
                </div>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Email</span>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 mt-1">{{ $customer->email ?? '—' }}</p>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Phone</span>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 mt-1">{{ $customer->phone ?? '—' }}</p>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Address</span>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 mt-1">{{ $customer->address ?? '—' }}</p>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Deals</span>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 mt-1">{{ $customer->deals?->count() ?? 0 }} deals</p>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Member Since</span>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 mt-1">{{ $customer->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
