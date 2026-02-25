@extends('layouts.app')
@section('title', 'Activity Log — CRM Admin')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <a href="{{ route('dashboard') }}" class="text-sm text-indigo-500 hover:text-indigo-600 font-medium flex items-center gap-1.5 mb-3 leading-none">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Dashboard
        </a>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Activity Log</h1>
        <p class="text-sm text-slate-400 mt-0.5">A complete history of all system events and user actions.</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="alert('Static Demo: Activity filter options.')" class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/60 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all active:scale-95">
            <i data-lucide="filter" class="w-4 h-4 text-slate-400"></i>
            Filter Activity
        </button>
        <div class="relative">
            <button onclick="toggleDropdown('activityExportDropdown')" class="flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/60 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all active:scale-95 shadow-sm">
                <i data-lucide="download" class="w-4 h-4 text-slate-400"></i>
                Export Log
            </button>
            <div id="activityExportDropdown" class="hidden absolute top-12 right-0 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700/60 z-[100] overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                <div class="p-1.5 space-y-0.5">
                    <button onclick="exportReport('CSV', 'Activity Log')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Export as CSV
                    </button>
                    <button onclick="exportReport('Excel', 'Activity Log')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i> Export as Excel
                    </button>
                    <button onclick="exportReport('PDF', 'Activity Log')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 dark:hover:text-rose-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-type-2" class="w-3.5 h-3.5"></i> Export as PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800/60 shadow-sm overflow-hidden">
    <div class="p-8">
        <div class="relative space-y-12 before:absolute before:inset-0 before:ml-6 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-100 dark:before:via-slate-800 before:to-transparent">
            @foreach($activities as $act)
            <div class="relative flex items-start gap-8 group" data-user="{{ $act->user }}" data-action="{{ $act->action }}" data-target="{{ $act->target }}" data-type="{{ $act->type }}" data-color="{{ $act->color }}" data-icon="{{ $act->icon }}">
                {{-- Icon Indicator --}}
                <div class="w-12 h-12 rounded-2xl bg-{{ $act->color }}-50 dark:bg-{{ $act->color }}-900/20 flex items-center justify-center flex-shrink-0 z-10 border-4 border-white dark:border-slate-900 shadow-sm transition-all duration-300 group-hover:scale-110 group-hover:shadow-md">
                    <i data-lucide="{{ $act->icon }}" class="w-5 h-5 text-{{ $act->color }}-500"></i>
                </div>
                
                {{-- Content Panel --}}
                <div class="flex-1 bg-slate-50 dark:bg-slate-800/40 rounded-2xl p-5 border border-transparent hover:border-slate-100 dark:hover:border-slate-700/50 transition-all hover:bg-white dark:hover:bg-slate-800 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 dark:hover:shadow-none">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-black uppercase tracking-widest text-{{ $act->color }}-500 bg-{{ $act->color }}-50 dark:bg-{{ $act->color }}-900/40 px-2 py-0.5 rounded-md type-badge">{{ $act->type }}</span>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-tighter">{{ $act->time }}</span>
                            </div>
                            <p class="text-sm font-medium text-slate-600 dark:text-slate-300 activity-text">
                                <span class="font-black text-slate-800 dark:text-white user-name">{{ $act->user }}</span> 
                                <span class="action-text">{{ $act->action }}</span> <span class="font-bold text-indigo-500 target-text">{{ $act->target }}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="alert('Static Demo: Showing record details for ' + this.closest('.group').dataset.target)" class="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-indigo-500 hover:border-indigo-100 transition-all shadow-sm">
                                View Record
                            </button>
                            <div class="flex items-center gap-1.5 ml-2">
                                <button onclick="openEditModal(this.closest('.group'))" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-400 hover:text-indigo-600 transition-all shadow-sm" title="Edit Log">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                </button>
                                <button onclick="this.closest('.relative.flex.items-start.gap-8').remove();" class="p-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-400 hover:text-rose-500 transition-all shadow-sm" title="Delete Log">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="bg-slate-50/50 dark:bg-slate-900/50 p-6 border-t border-slate-100 dark:border-slate-800/60 text-center">
        <button class="text-xs font-bold text-slate-400 cursor-default">You've reached the end of the activity history for this week</button>
    </div>
</div>

{{-- Edit Activity Modal --}}
<div id="edit-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg p-4">
        <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-700 overflow-hidden">
            <div class="p-8 border-b border-slate-50 dark:border-slate-700/50 flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-800 dark:text-white">Edit Activity Log</h3>
                <button onclick="closeEditModal()" class="p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-400 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="edit-form" class="p-8 space-y-6" onsubmit="updateActivity(event)">
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">User</label>
                        <input type="text" id="edit-user" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border-none text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Activity Type</label>
                        <select id="edit-type" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border-none text-sm font-bold text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all">
                            <option value="Info">Info</option>
                            <option value="Success">Success</option>
                            <option value="Update">Update</option>
                            <option value="Activity">Activity</option>
                            <option value="Warning">Warning</option>
                            <option value="System">System</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Action Description</label>
                    <input type="text" id="edit-action" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border-none text-sm font-medium text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Target</label>
                    <input type="text" id="edit-target" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900 border-none text-sm font-black text-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-grow py-4 bg-indigo-600 text-white rounded-2xl font-bold text-sm hover:bg-indigo-700 transition shadow-xl shadow-indigo-600/20">
                        Update Activity
                    </button>
                    <button type="button" onclick="closeEditModal()" class="px-8 py-4 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-2xl font-black text-sm hover:bg-slate-200 dark:hover:bg-slate-600 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let currentEditRow = null;

    function openEditModal(row) {
        currentEditRow = row;
        document.getElementById('edit-user').value = row.dataset.user;
        document.getElementById('edit-type').value = row.dataset.type;
        document.getElementById('edit-action').value = row.dataset.action;
        document.getElementById('edit-target').value = row.dataset.target;
        
        document.getElementById('edit-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('edit-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentEditRow = null;
    }

    function updateActivity(event) {
        event.preventDefault();
        if (!currentEditRow) return;

        const user = document.getElementById('edit-user').value;
        const type = document.getElementById('edit-type').value;
        const action = document.getElementById('edit-action').value;
        const target = document.getElementById('edit-target').value;

        const typeColors = {
            'Success': 'emerald',
            'Info': 'indigo',
            'Update': 'amber',
            'Activity': 'indigo',
            'Warning': 'rose',
            'System': 'slate'
        };

        const color = typeColors[type] || 'slate';

        // Update dataset
        currentEditRow.dataset.user = user;
        currentEditRow.dataset.type = type;
        currentEditRow.dataset.action = action;
        currentEditRow.dataset.target = target;
        currentEditRow.dataset.color = color;

        // Update UI
        const iconContainer = currentEditRow.querySelector('.w-12.h-12');
        iconContainer.className = `w-12 h-12 rounded-2xl bg-${color}-50 dark:bg-${color}-900/20 flex items-center justify-center flex-shrink-0 z-10 border-4 border-white dark:border-slate-900 shadow-sm transition-all duration-300 group-hover:scale-110 group-hover:shadow-md`;
        
        const badge = currentEditRow.querySelector('.type-badge');
        badge.className = `text-xs font-black uppercase tracking-widest text-${color}-500 bg-${color}-50 dark:bg-${color}-900/40 px-2 py-0.5 rounded-md type-badge`;
        badge.innerText = type;

        currentEditRow.querySelector('.user-name').innerText = user;
        currentEditRow.querySelector('.action-text').innerText = action;
        currentEditRow.querySelector('.target-text').innerText = target;

        closeEditModal();
        if (window.lucide) lucide.createIcons();
    }
</script>
@endsection
