@extends('layouts.app')
@section('title', 'Add New Customer — CRM Admin')

@section('content')
<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">Add New Customer</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Create a new customer profile</p>
        </div>
        <a href="{{ route('customers.index') }}" class="flex items-center gap-2.5 px-5 py-2.5 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-2xl text-sm font-bold shadow-sm border border-slate-100 dark:border-slate-700/60 hover:bg-slate-50 transition active:scale-95">
            <i data-lucide="arrow-left" class="w-4 h-4 text-slate-400"></i>
            Back to List
        </a>
    </div>

    {{-- Form Content --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/60 shadow-sm overflow-hidden">
        <form action="{{ route('customers.store') }}" method="POST" class="divide-y divide-slate-50 dark:divide-slate-700/50">
            @csrf
            
            <div class="p-8 md:p-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center">
                        <i data-lucide="user" class="w-5 h-5 text-indigo-500"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-black text-slate-800 dark:text-white uppercase tracking-wider">Basic Information</h2>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Primary contact and company details</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Full Name *</label>
                        <input type="text" name="name" placeholder="e.g. John Doe" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all" required value="{{ old('name') }}">
                    </div>
                    
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Email Address</label>
                        <input type="email" name="email" placeholder="e.g. john@company.com" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all" value="{{ old('email') }}">
                    </div>

                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Phone Number</label>
                        <input type="text" name="phone" placeholder="+1 (555) 000-0000" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all" value="{{ old('phone') }}">
                    </div>

                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Company</label>
                        <input type="text" name="company_name" placeholder="e.g. Acme Corp" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all" value="{{ old('company_name') }}">
                    </div>
                </div>

                <div class="flex flex-col gap-2.5">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Address</label>
                    <textarea name="address" rows="3" placeholder="Full address..." class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-3xl px-6 py-5 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all resize-none">{{ old('address') }}</textarea>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="p-8 md:p-10 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-end gap-4">
                <a href="{{ route('customers.index') }}" class="px-8 py-3.5 border border-slate-200 dark:border-slate-700 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition active:scale-95">
                    Cancel
                </a>
                <button type="submit" class="px-10 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/25 active:scale-95">
                    Create Customer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
