@extends('layouts.app')
@section('title', 'Edit Lead — CRM Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">Edit Lead (Project)</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Update project details and status</p>
        </div>
        <a href="{{ route('leads.index') }}" class="flex items-center gap-2.5 px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-2xl text-sm font-bold shadow-sm hover:bg-slate-50 transition active:scale-95">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <form method="POST" action="{{ route('leads.update', $lead->id) }}" class="divide-y divide-slate-50">
            @csrf
            @method('PUT')

            <div class="p-8 md:p-10">
                <div class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Client Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="client_name" value="{{ old('client_name', $lead->client_name) }}" required class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                        </div>

                        <div class="flex flex-col gap-2.5">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Project Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="project_name" value="{{ old('project_name', $lead->project_name) }}" required class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col gap-2.5">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $lead->phone) }}" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                        </div>

                        <div class="flex flex-col gap-2.5">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $lead->email) }}" class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                        </div>
                    </div>

                    <div class="flex flex-col gap-2.5">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest pl-1">Status <span class="text-rose-500">*</span></label>
                        <select name="status" required class="bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:border-indigo-500 outline-none">
                            <option value="Pending" {{ old('status', $lead->status) === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Confirm" {{ old('status', $lead->status) === 'Confirm' ? 'selected' : '' }}>Confirm</option>
                            <option value="Followup" {{ old('status', $lead->status) === 'Followup' ? 'selected' : '' }}>Followup</option>
                            <option value="Not Interested" {{ old('status', $lead->status) === 'Not Interested' ? 'selected' : '' }}>Not Interested</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-10 bg-slate-50/50 flex items-center justify-end gap-4">
                <button type="submit" class="px-10 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/25 active:scale-95">
                    Update Lead
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
