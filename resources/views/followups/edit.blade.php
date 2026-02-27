@extends('layouts.app')
@section('title', 'Edit Follow-up — CRM Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('followups.index') }}" class="p-2.5 rounded-xl bg-white dark:bg-slate-800 text-slate-400 hover:text-indigo-600 shadow-sm border border-slate-100 dark:border-slate-700 transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">Edit Follow-up</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Update the scheduled activity</p>
        </div>
    </div>

    <form action="{{ route('followups.update', $followup->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-50 dark:border-slate-800 shadow-sm overflow-hidden p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Lead --}}
                <div class="space-y-3 col-span-full">
                    <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Related Lead <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="lead_id" required class="w-full px-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 appearance-none shadow-sm cursor-pointer">
                            <option value="">Select a Lead</option>
                            @foreach($leads as $lead)
                                <option value="{{ $lead->id }}" {{ old('lead_id', $followup->lead_id) == $lead->id ? 'selected' : '' }}>{{ $lead->project_name }} ({{ $lead->client_name }})</option>
                            @endforeach
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300 pointer-events-none"></i>
                    </div>
                </div>

                {{-- Date --}}
                <div class="space-y-3">
                    <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Date <span class="text-rose-500">*</span></label>
                    <input type="date" name="followup_date" value="{{ old('followup_date', $followup->followup_date ? \Carbon\Carbon::parse($followup->followup_date)->format('Y-m-d') : '') }}" required
                           class="w-full px-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 shadow-sm" />
                </div>

                {{-- Time --}}
                <div class="space-y-3">
                    <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Time</label>
                    <input type="time" name="followup_time" value="{{ old('followup_time', $followup->followup_time ? \Carbon\Carbon::parse($followup->followup_time)->format('H:i') : '') }}"
                           class="w-full px-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 shadow-sm" />
                </div>

                {{-- Status --}}
                <div class="space-y-3">
                    <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Status <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="status" required class="w-full px-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 appearance-none shadow-sm cursor-pointer">
                            <option value="Pending" {{ old('status', $followup->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Completed" {{ old('status', $followup->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Cancelled" {{ old('status', $followup->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300 pointer-events-none"></i>
                    </div>
                </div>


            </div>

            <div class="mt-12 flex items-center justify-end gap-4">
                <a href="{{ route('followups.index') }}" class="px-8 py-4 text-sm font-black text-slate-400 hover:text-slate-600 transition-colors">Cancel</a>
                <button type="submit" class="flex items-center gap-3 px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black text-[15px] hover:bg-indigo-700 shadow-xl shadow-indigo-500/25 active:scale-95 transition-all">
                    Update Follow-up
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
