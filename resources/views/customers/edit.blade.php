@extends('layouts.app')
@section('title', 'Edit Customer — CRM Admin')

@section('content')
<div class="space-y-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">Edit Customer</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Update profile, contact details, and internal notes</p>
        </div>
        <a href="{{ route('customers.index') }}" class="flex items-center gap-2.5 px-5 py-2.5 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-2xl text-sm font-bold shadow-sm border border-slate-100 dark:border-slate-700/60 hover:bg-slate-50 transition active:scale-95">
            <i data-lucide="arrow-left" class="w-4 h-4 text-slate-400"></i>
            Back to List
        </a>
    </div>

    {{-- Form Content --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700/60 shadow-sm overflow-hidden">
        <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="divide-y divide-slate-50 dark:divide-slate-700/50">
            @csrf
            @method('PUT')
            
            {{-- Section 1: Basic Info --}}
            <div class="p-8 md:p-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center">
                        <i data-lucide="user" class="w-5 h-5 text-indigo-500"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-black text-slate-800 dark:text-white uppercase tracking-wider">Basic Information</h2>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Primary contact and group classification</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Full Name</label>
                        <input type="text" name="name" value="{{ $customer->name }}" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all" required>
                    </div>
                    
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Email Address</label>
                        <input type="email" name="email" value="{{ $customer->email }}" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all" required>
                    </div>

                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Company</label>
                        <input type="text" name="company" value="{{ $customer->company }}" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Customer Group</label>
                        <div class="relative">
                            <select name="group" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer">
                                <option value="Millennials" {{ $customer->group == 'Millennials' ? 'selected' : '' }}>Millennials</option>
                                <option value="Generation Z" {{ $customer->group == 'Generation Z' ? 'selected' : '' }}>Generation Z</option>
                                <option value="Generation X" {{ $customer->group == 'Generation X' ? 'selected' : '' }}>Generation X</option>
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Contact Details --}}
            <div class="p-8 md:p-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center">
                        <i data-lucide="phone" class="w-5 h-5 text-emerald-500"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-black text-slate-800 dark:text-white uppercase tracking-wider">Contact & Status</h2>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Communication channels and account state</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ $customer->phone }}" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Account Status</label>
                        <div class="relative">
                            <select name="status" class="w-full bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all appearance-none cursor-pointer">
                                <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="pending" {{ $customer->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2.5 md:col-span-2 lg:col-span-1">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Alternative Phone <span class="text-slate-400 font-medium normal-case tracking-normal">(Optional)</span></label>
                        <input type="text" name="phone_alt" value="{{ old('phone_alt', $customer->phone_alt) }}" placeholder="e.g. +1 (555) 999-9999" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            {{-- Section 3: Notes --}}
            <div class="p-8 md:p-10">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center">
                        <i data-lucide="sticky-note" class="w-5 h-5 text-amber-500"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-black text-slate-800 dark:text-white uppercase tracking-wider">Internal Notes</h2>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">Strategic observations and customer history</p>
                    </div>
                </div>

                <div class="flex flex-col gap-2.5">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Observation & History</label>
                    <textarea name="notes" rows="5" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-700 rounded-3xl px-6 py-5 text-sm font-bold text-slate-700 dark:text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all resize-none">{{ $customer->notes }}</textarea>
                </div>
            </div>

            {{-- Footer Actions --}}
            <div class="p-8 md:p-10 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-end gap-4">
                <button type="button" onclick="window.history.back()" class="px-8 py-3.5 border border-slate-200 dark:border-slate-700 rounded-2xl font-black text-xs uppercase tracking-widest text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition active:scale-95">
                    Discard Changes
                </button>
                <button type="submit" class="px-10 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/25 active:scale-95">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
