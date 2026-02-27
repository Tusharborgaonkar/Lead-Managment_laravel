{{-- Sidebar --}}
<aside id="sidebar" class="sidebar flex flex-col min-h-screen bg-white dark:bg-slate-900 border-r border-slate-200/60 dark:border-slate-700/60 transition-all duration-300 shadow-sm">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-100 dark:border-slate-800">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 flex-shrink-0">
            <i data-lucide="zap" class="w-5 h-5 text-white"></i>
        </div>
        <div>
            <div class="text-sm font-black text-slate-800 dark:text-white tracking-tight">AcmeCRM</div>
            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Enterprise</div>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-6">

        {{-- Main --}}
        <div>
            <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 px-3 mb-2">Main</div>
            <div class="space-y-0.5">
                <a href="{{ route('dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-bold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/60 font-medium' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 flex-shrink-0"></i> Dashboard
                </a>
            </div>
        </div>

        {{-- Sales Pipeline --}}
        <div>
            <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 px-3 mb-2">Sales Pipeline</div>
            <div class="space-y-0.5">
                <a href="{{ route('leads.index') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('leads.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-bold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/60 font-medium' }}">
                    <i data-lucide="user-plus" class="w-4 h-4 flex-shrink-0"></i> Leads
                </a>

                <a href="{{ route('customers.index') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('customers.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-bold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/60 font-medium' }}">
                    <i data-lucide="users" class="w-4 h-4 flex-shrink-0"></i> Customers
                </a>



                <a href="{{ route('followups.index') }}"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('followups.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 font-bold' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/60 font-medium' }}">
                    <i data-lucide="clock" class="w-4 h-4 flex-shrink-0"></i> Follow-ups
                    <span class="ml-auto text-[10px] font-black bg-rose-500 text-white px-1.5 py-0.5 rounded-full">7</span>
                </a>
            </div>
        </div>



    </nav>

    {{-- User Card --}}
    <div class="px-4 py-4 border-t border-slate-100 dark:border-slate-800">
        <div class="flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition group">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-xs font-black flex-shrink-0 shadow-md shadow-indigo-500/20">
                {{ collect(explode(' ', Auth::user()->name))->map(fn($n) => substr($n, 0, 1))->join('') }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->name }}</div>
                <div class="text-[10px] text-slate-400 truncate">Administrator · {{ Auth::user()->email }}</div>
            </div>
            <i data-lucide="chevrons-up-down" class="w-3.5 h-3.5 text-slate-300 flex-shrink-0"></i>
        </div>
    </div>

</aside>

{{-- Mobile overlay --}}
<div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 lg:hidden hidden"
     onclick="document.getElementById('sidebar').classList.remove('mobile-open'); this.classList.add('hidden');"></div>

<script>
(function() {
    const toggle = document.getElementById('sidebarToggle');
    const sb     = document.getElementById('sidebar');
    const ov     = document.getElementById('sidebarOverlay');
    if (toggle && sb) {
        toggle.addEventListener('click', () => {
            sb.classList.toggle('mobile-open');
            if (ov) ov.classList.toggle('hidden');
        });
    }
})();
</script>
