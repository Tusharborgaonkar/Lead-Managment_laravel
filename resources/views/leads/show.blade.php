@extends('layouts.app')
@section('title', $lead->name . ' — Lead Detail')

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-start gap-4">
            <a href="{{ route('leads.index') }}" class="mt-1.5 p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm text-slate-400 hover:text-indigo-600 transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-800 dark:text-white leading-tight font-display">{{ $lead->name }}</h1>
                <p class="text-sm text-slate-400 font-medium mt-1">
                    {{ $lead->company }} <span class="mx-2 text-slate-300">•</span> Created on {{ $lead->created_at }}
                </p>
            </div>
        </div>
        <div>
            <a href="{{ route('leads.edit', $lead->id) }}"
               class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-violet-600 text-white rounded-2xl font-bold text-sm hover:from-indigo-600 hover:to-violet-700 transition shadow-lg shadow-indigo-500/25">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit Lead
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Left Column: Status & Contact --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Status Card --}}
            <div class="bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm p-8">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-6">Current Status</span>
                
                @php
                    $tagColor = [
                        'Not Interested' => 'rose',
                        'Followup' => 'amber',
                        'Pending' => 'sky',
                        'Confirm' => 'emerald'
                    ][$lead->category] ?? 'slate';
                @endphp
                
                <div class="inline-block px-5 py-2.5 rounded-2xl bg-{{ $tagColor }}-50 dark:bg-{{ $tagColor }}-900/20 text-sm font-black text-{{ $tagColor }}-600 dark:text-{{ $tagColor }}-400 border border-{{ $tagColor }}-100 dark:border-{{ $tagColor }}-800/50 mb-10">
                    {{ $lead->category }}
                </div>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-3">Source</span>
                        <div class="flex items-center gap-2">
                            <i data-lucide="share-2" class="w-4 h-4 text-indigo-500"></i>
                            <span class="text-[15px] font-black text-slate-700 dark:text-slate-200">{{ $lead->source ?? '—' }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-3">Deal Value</span>
                        <span class="text-[15px] font-black text-slate-700 dark:text-slate-200">{{ $lead->value ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- Contact Information Card --}}
            <div class="bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="p-8 pb-0">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-2">Contact Information</span>
                </div>
                
                <div class="p-8 space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="mail" class="w-5 h-5 text-indigo-500"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.1em] block mb-1">Email Address</span>
                            <a href="mailto:{{ $lead->email }}" class="text-[15px] font-black text-slate-700 dark:text-slate-200 hover:text-indigo-600 transition-colors">{{ $lead->email }}</a>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="phone" class="w-5 h-5 text-emerald-500"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.1em] block mb-1">Phone Number</span>
                            <span class="text-[15px] font-black text-slate-700 dark:text-slate-200">{{ $lead->phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Timeline --}}
        <div class="lg:col-span-8">
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] border border-slate-100 dark:border-slate-700 shadow-sm min-h-[500px] flex flex-col">
                <div class="p-8 border-b border-slate-50 dark:border-slate-700/50 flex items-center justify-between">
                    <h3 class="text-xl font-black text-slate-800 dark:text-white">Activity Timeline</h3>
                    <button onclick="openLogModal()" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-2xl font-bold text-[13px] hover:bg-indigo-700 transition shadow-lg shadow-indigo-600/20">
                        <i data-lucide="plus" class="w-4 h-4"></i> Add Log
                    </button>
                </div>
                
                <div id="timeline-container" class="flex-grow flex flex-col p-8">
                    {{-- Empty State --}}
                    <div id="timeline-empty-state" class="flex-grow flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-20 h-20 rounded-[2rem] bg-slate-50 dark:bg-slate-700/50 flex items-center justify-center mb-6">
                            <i data-lucide="message-square" class="w-10 h-10 text-slate-200 dark:text-slate-600"></i>
                        </div>
                        <h4 class="text-[17px] font-black text-slate-400 dark:text-slate-500">No activity recorded for this lead yet.</h4>
                        <p class="text-sm text-slate-300 dark:text-slate-600 mt-2 font-medium">Click <span class="text-indigo-400 font-bold italic">Add Log</span> to record the first activity.</p>
                    </div>

                    {{-- Timeline Entries (Dynamic) --}}
                    <div id="timeline-list" class="space-y-8 hidden">
                        {{-- Log entries will be prepended here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Log Modal --}}
<div id="log-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeLogModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg p-4">
        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="p-8 border-b border-slate-50 dark:border-slate-700/50 flex items-center justify-between">
                <h3 id="modal-title" class="text-xl font-black text-slate-800 dark:text-white">Add Activity Log</h3>
                <button onclick="closeLogModal()" class="p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-400 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="log-form" class="p-8 space-y-6" onsubmit="submitLog(event)">
                <input type="hidden" id="log-edit-index" value="">
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Activity Type</label>
                        <select id="log-type" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border-none text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="Call">Call</option>
                            <option value="Meeting">Meeting</option>
                            <option value="Email">Email</option>
                            <option value="Note">Note</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Update Status</label>
                        <select id="log-status" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border-none text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="Not Interested">Not Interested</option>
                            <option value="Followup">Followup</option>
                            <option value="Pending">Pending</option>
                            <option value="Confirm">Confirm</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Detailed Note</label>
                    <textarea id="log-note" rows="4" required placeholder="Describe the activity..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border-none text-sm font-medium text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all resize-none"></textarea>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" id="modal-submit-btn" class="flex-grow py-4 bg-indigo-600 text-white rounded-2xl font-bold text-sm hover:bg-indigo-700 transition shadow-xl shadow-indigo-600/20">
                        Save Activity
                    </button>
                    <button type="button" onclick="closeLogModal()" class="px-8 py-4 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-2xl font-black text-sm hover:bg-slate-200 dark:hover:bg-slate-600 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let logCounter = 0;
    let currentEditTarget = null;

    function openLogModal(editTarget = null) {
        const modal = document.getElementById('log-modal');
        const title = document.getElementById('modal-title');
        const submitBtn = document.getElementById('modal-submit-btn');
        const form = document.getElementById('log-form');
        
        currentEditTarget = editTarget;
        
        if (editTarget) {
            title.innerText = 'Edit Activity Log';
            submitBtn.innerText = 'Update Activity';
            
            // Populate data from attributes
            document.getElementById('log-type').value = editTarget.dataset.type;
            document.getElementById('log-status').value = editTarget.dataset.status;
            document.getElementById('log-note').value = editTarget.dataset.note;
        } else {
            title.innerText = 'Add Activity Log';
            submitBtn.innerText = 'Save Activity';
            form.reset();
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLogModal() {
        document.getElementById('log-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentEditTarget = null;
    }

    function submitLog(event) {
        event.preventDefault();
        
        const type = document.getElementById('log-type').value;
        const status = document.getElementById('log-status').value;
        const note = document.getElementById('log-note').value;
        const now = new Date();
        const timeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
        const dateStr = now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });

        const typeIcons = {
            'Call': 'phone',
            'Meeting': 'users',
            'Email': 'mail',
            'Note': 'file-text'
        };

        const statusColors = {
            'Not Interested': 'rose',
            'Followup': 'amber',
            'Pending': 'sky',
            'Confirm': 'emerald'
        };

        const color = statusColors[status] || 'indigo';
        const icon = typeIcons[type] || 'message-circle';

        if (currentEditTarget) {
            // Update existing entry
            currentEditTarget.dataset.type = type;
            currentEditTarget.dataset.status = status;
            currentEditTarget.dataset.note = note;
            
            // Update the HTML content
            const iconContainer = currentEditTarget.querySelector('.w-8.h-8');
            iconContainer.className = `absolute left-0 top-0 w-8 h-8 rounded-xl bg-${color}-500/10 flex items-center justify-center border border-${color}-100`;
            iconContainer.innerHTML = `<i data-lucide="${icon}" class="w-4 h-4 text-${color}-600"></i>`;
            
            currentEditTarget.querySelector('h5').innerText = `${type} Logged`;
            
            const badge = currentEditTarget.querySelector('.px-2.py-0.5');
            badge.className = `px-2 py-0.5 rounded-lg bg-${color}-50 text-[10px] font-black text-${color}-600 border border-${color}-100 lowercase first-letter:uppercase`;
            badge.innerText = status;
            
            currentEditTarget.querySelector('p').innerText = note;
        } else {
            // Create new entry
            const logId = `log-${++logCounter}`;
            const logHtml = `
                <div id="${logId}" class="relative pl-10 animate-fade-in-up" 
                     data-type="${type}" data-status="${status}" data-note="${note}">
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-xl bg-${color}-500/10 flex items-center justify-center border border-${color}-100">
                        <i data-lucide="${icon}" class="w-4 h-4 text-${color}-600"></i>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <h5 class="text-sm font-black text-slate-700 dark:text-slate-200">${type} Logged</h5>
                        <div class="flex items-center gap-3">
                            <span class="text-[11px] font-bold text-slate-400">${dateStr} at ${timeStr}</span>
                            <div class="flex items-center gap-1.5 ml-2">
                                <button onclick="openLogModal(this.closest('.relative.pl-10'))" class="p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-600 text-slate-400 hover:text-indigo-500 transition-colors" title="Edit Log">
                                    <i data-lucide="pencil" class="w-3 h-3"></i>
                                </button>
                                <button onclick="this.closest('.relative.pl-10').remove(); checkTimelineEmpty();" class="p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-600 text-slate-400 hover:text-rose-500 transition-colors" title="Delete Log">
                                    <i data-lucide="trash-2" class="w-3 h-3"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50/50 dark:bg-slate-700/30 rounded-2xl p-5 border border-slate-100/50 dark:border-slate-700/50">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Status Update:</span>
                            <span class="px-2 py-0.5 rounded-lg bg-${color}-50 text-[10px] font-black text-${color}-600 border border-${color}-100 lowercase first-letter:uppercase">${status}</span>
                        </div>
                        <p class="text-[13px] text-slate-500 dark:text-slate-400 font-medium leading-relaxed">${note}</p>
                    </div>
                </div>
            `;

            document.getElementById('timeline-empty-state').classList.add('hidden');
            document.getElementById('timeline-list').classList.remove('hidden');
            const list = document.getElementById('timeline-list');
            list.insertAdjacentHTML('afterbegin', logHtml);
        }
        
        // Refresh Lucide icons
        if (window.lucide) {
            lucide.createIcons();
        }

        // Close modal and reset form
        closeLogModal();
        document.getElementById('log-form').reset();
    }

    function checkTimelineEmpty() {
        const list = document.getElementById('timeline-list');
        if (list.children.length === 0) {
            document.getElementById('timeline-empty-state').classList.remove('hidden');
            list.classList.add('hidden');
        }
    }
</script>

<style>
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.4s ease-out forwards;
    }
</style>
@endpush
@endsection
