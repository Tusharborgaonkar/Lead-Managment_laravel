@extends('layouts.app')
@section('title', 'Add New Deal — CRM Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('deals.index') }}" class="p-2.5 rounded-xl bg-white dark:bg-slate-800 text-slate-400 hover:text-indigo-600 shadow-sm border border-slate-100 dark:border-slate-700 transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">Add New Deal</h1>
            <p class="text-sm text-slate-400 mt-1 font-medium">Create a new opportunity in your sales pipeline</p>
        </div>
    </div>

    {{-- Form Card --}}
    <form action="{{ route('deals.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-50 dark:border-slate-800 shadow-sm overflow-hidden p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Deal Title --}}
                <div class="space-y-3 col-span-full">
                    <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Deal Title <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                            <i data-lucide="briefcase" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input type="text" name="title" required placeholder="e.g. Enterprise Software License"
                               class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm" />
                    </div>
                </div>

                {{-- Client Name --}}
                <div class="space-y-3">
                    <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Client / Company <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                            <i data-lucide="building-2" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input type="text" name="client" required placeholder="e.g. Acme Corp"
                               class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm" />
                    </div>
                </div>

                {{-- Deal Value --}}
                <div class="space-y-3">
                    <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Deal Value ($) <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                            <i data-lucide="dollar-sign" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input type="number" name="value" required placeholder="e.g. 15000"
                               class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm" />
                    </div>
                </div>

                {{-- Pipeline Stage --}}
                <div class="space-y-3">
                    <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Pipeline Stage <span class="text-rose-500">*</span></label>
                    <div class="relative group group-select">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none z-10">
                            <i data-lucide="layers" class="w-5 h-5 text-indigo-500"></i>
                        </div>
                        <select name="stage" required
                                class="w-full pl-14 pr-10 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all appearance-none cursor-pointer shadow-sm">
                            <option value="Prospect">Prospect</option>
                            <option value="Qualified">Qualified</option>
                            <option value="Proposal">Proposal</option>
                            <option value="Negotiation">Negotiation</option>
                            <option value="Won">Won</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none">
                            <i data-lucide="chevron-down" class="w-5 h-5 text-slate-300"></i>
                        </div>
                    </div>
                </div>

                {{-- Expected Close Date --}}
                <div class="space-y-3">
                    <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Expected Close</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                            <i data-lucide="calendar" class="w-5 h-5 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                        </div>
                        <input type="date" name="close_date"
                               class="w-full pl-14 pr-6 py-4.5 rounded-2xl bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm" />
                    </div>
                </div>

                {{-- Description / Notes --}}
                <div class="space-y-3 col-span-full">
                    <label class="block text-[13px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest pl-1">Deal Details</label>
                    <textarea name="description" rows="4" placeholder="Brief overview of the deal, key contacts, or next steps..."
                              class="w-full px-8 py-5 rounded-[2rem] bg-[#f8faff] dark:bg-slate-800 border-none text-[15px] font-medium text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-indigo-500 transition-all shadow-sm resize-none"></textarea>
                </div>
            </div>

            <div class="mt-12 flex items-center justify-end gap-4">
                <a href="{{ route('deals.index') }}" class="px-8 py-4 text-sm font-black text-slate-400 hover:text-slate-600 transition-colors">Cancel</a>
                <button type="submit" class="flex items-center gap-3 px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black text-[15px] hover:bg-indigo-700 transition shadow-xl shadow-indigo-500/25 active:scale-95">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    Save Deal
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
