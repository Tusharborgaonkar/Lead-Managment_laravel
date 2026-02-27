@extends('layouts.app')
@section('title', 'Project Workspace — CRM Admin')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('leads.index') }}" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-indigo-600 transition-colors">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                </a>
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-600 border border-indigo-100">Project / Lead</span>
                @php
                    $colors = ['Pending' => 'amber', 'Confirm' => 'emerald', 'Not Interested' => 'rose', 'Followup' => 'indigo'];
                    $c = $colors[$lead->status] ?? 'slate';
                @endphp
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-{{$c}}-50 text-{{$c}}-600 border border-{{$c}}-100">
                    {{ $lead->status }}
                </span>
            </div>
            <h1 class="text-3xl font-black text-slate-800 dark:text-white">{{ $lead->project_name }}</h1>
            
            <div class="inline-flex items-center gap-2 mt-2 group">
                <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600 group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                    <i data-lucide="user" class="w-3 h-3"></i>
                </div>
                <span class="text-sm font-bold text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 transition-colors">{{ $lead->client_name }} <span class="font-medium text-slate-400">({{ $lead->phone ?? 'No Phone' }})</span></span>
            </div>
        </div>

        <div class="flex gap-3">
            @if($lead->status === 'Confirm' && !$lead->customer_id)
            <form action="{{ route('leads.convert', $lead->id) }}" method="POST" data-confirm="Convert this Lead to a Customer?">
                @csrf
                <button type="submit" class="px-5 py-2.5 bg-emerald-600 border border-emerald-500 text-white rounded-xl font-bold shadow-sm hover:bg-emerald-700 transition active:scale-95 flex items-center gap-2">
                    <i data-lucide="user-check" class="w-4 h-4"></i> Convert to Customer
                </button>
            </form>
            @endif
            @if($lead->customer_id)
            <a href="{{ route('customers.show', $lead->customer_id) }}" class="px-5 py-2.5 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-xl font-bold shadow-sm hover:bg-indigo-100 transition active:scale-95 flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4"></i> View Customer Profile
            </a>
            @endif
            <a href="{{ route('leads.edit', $lead->id) }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold shadow-sm hover:bg-slate-50 transition active:scale-95 flex items-center gap-2">
                <i data-lucide="settings" class="w-4 h-4"></i> Adjust Status
            </a>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Left Column: Notes --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between pointer-events-none">
                <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                    <i data-lucide="message-square" class="w-5 h-5 text-indigo-500"></i> Interaction Notes
                </h2>
            </div>
            
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <form action="{{ route('notes.store', $lead->id) }}" method="POST">
                    @csrf
                    <textarea name="note" required rows="3" placeholder="Log details from a call, meeting, or email here..." class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 resize-none outline-none"></textarea>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-md hover:bg-indigo-700 transition active:scale-95">Save Note</button>
                    </div>
                </form>
            </div>

            <div class="space-y-4">
                @forelse($lead->notes as $note)
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm flex gap-4 transition hover:border-indigo-100">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex-shrink-0 flex items-center justify-center text-slate-400 pt-0.5">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-bold text-slate-400">{{ $note->created_at->format('M d, Y • h:i A') }}</span>
                            <span class="text-[10px] text-slate-300">•</span>
                            <span class="text-xs font-medium text-slate-400">{{ $note->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm font-medium text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $note->note }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <i data-lucide="inbox" class="w-8 h-8 text-slate-300 mx-auto mb-3"></i>
                    <p class="text-sm font-bold text-slate-500 mb-1">No notes yet</p>
                    <p class="text-xs font-medium text-slate-400">Start adding notes to keep track of this project</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Right Column: Follow-ups --}}
        <div class="space-y-6">
            <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                <i data-lucide="calendar" class="w-5 h-5 text-emerald-500"></i> Next Steps
            </h2>

            <div class="bg-white rounded-3xl border border-emerald-100 shadow-sm p-6 bg-emerald-50/30">
                <h3 class="text-sm font-bold text-slate-700 mb-4">Schedule Follow-up</h3>
                <form action="{{ route('followups.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                    <input type="hidden" name="status" value="Pending">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <input type="date" name="followup_date" required class="w-full bg-white border border-slate-200 rounded-xl p-3 text-sm font-bold text-slate-700 outline-none focus:border-emerald-500">
                        <input type="time" name="followup_time" required class="w-full bg-white border border-slate-200 rounded-xl p-3 text-sm font-bold text-slate-700 outline-none focus:border-emerald-500">
                    </div>
                    <button type="submit" class="w-full py-3 bg-emerald-600 text-white rounded-xl font-bold text-sm shadow-md hover:bg-emerald-700 transition active:scale-95 text-center">Set Reminder</button>
                </form>
            </div>

            <h3 class="text-sm font-bold text-slate-600 mt-8 mb-4 uppercase tracking-widest pl-1">Scheduled Activities</h3>
            <div class="space-y-3">
                @forelse($lead->followups as $followup)
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm {{ $followup->status === 'Completed' ? 'opacity-60' : '' }}">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-bold {{ $followup->status === 'Completed' ? 'line-through text-slate-400' : 'text-slate-800' }}">Call Customer</p>
                            <p class="text-xs font-bold text-indigo-500 mt-1">{{ \Carbon\Carbon::parse($followup->followup_date)->format('M d, Y') }} • {{ \Carbon\Carbon::parse($followup->followup_time)->format('h:i A') }}</p>
                        </div>
                        @if($followup->status === 'Pending')
                        <form action="{{ route('followups.complete', $followup->id) }}" method="POST">
                            @csrf
                            <button type="submit" title="Mark Completed" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-emerald-50 flex items-center justify-center text-slate-400 hover:text-emerald-500 border border-slate-200 transition-colors">
                                <i data-lucide="check" class="w-4 h-4"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-xs font-medium text-slate-400 pl-1">No follow-ups scheduled.</p>
                @endforelse
            </div>
        </div>
        
    </div>
</div>
@endsection
