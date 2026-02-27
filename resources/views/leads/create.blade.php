@extends('layouts.app')
@section('title', 'Add New Lead — CRM Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">Add New Lead</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Create a new lead (project) for a customer</p>
        </div>
        <a href="{{ route('leads.index') }}" class="flex items-center gap-2.5 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-2xl text-sm font-bold shadow-sm hover:bg-slate-50 transition active:scale-95">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <form method="POST" action="{{ route('leads.store') }}" class="divide-y divide-slate-50">
            @csrf

            <div class="p-8 md:p-10">
                <div class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Client Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="client_name" value="{{ old('client_name') }}" required placeholder="e.g. John Doe" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                        </div>

                        <div class="flex flex-col gap-2.5">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Project Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="project_name" value="{{ old('project_name') }}" required placeholder="e.g. eCommerce Website Redesign" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. +1 234 567 890" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                        </div>

                        <div class="flex flex-col gap-2.5">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. john@example.com" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Status <span class="text-rose-500">*</span></label>
                        <select name="status" required class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                            <option value="Pending" {{ old('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Won" {{ old('status') === 'Won' ? 'selected' : '' }}>Won</option>
                            <option value="Lost" {{ old('status') === 'Lost' ? 'selected' : '' }}>Lost</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-10 bg-slate-50/50 flex items-center justify-end gap-4">
                <button type="submit" class="px-10 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/25 active:scale-95">
                    Save Lead
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
