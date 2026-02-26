{{-- Top Header --}}
<header class="sticky top-0 z-30 glass border-b border-slate-200/50 px-6 py-4 flex items-center justify-between bg-white dark:bg-slate-900">
    <div class="flex items-center gap-4">
        <button class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-500 transition-all active:scale-95" id="sidebarToggle">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>
        <div class="hidden sm:flex items-center gap-3 bg-slate-100/80 border border-slate-200/50 rounded-2xl px-5 py-2.5 w-80 group focus-within:ring-4 focus-within:ring-indigo-500/10 focus-within:border-indigo-500/30 transition-all duration-300">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
            <input type="text" placeholder="Search anything… (Ctrl + K)" class="bg-transparent border-none outline-none focus:outline-none focus:ring-0 text-sm text-slate-700 w-full placeholder:text-slate-400 font-medium" />
        </div>
    </div>

    <div class="flex items-center gap-1">
        {{-- Theme Toggle --}}
        <button id="themeToggle" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 dark:text-slate-400 transition-all duration-200">
            <i data-lucide="sun"  class="w-[18px] h-[18px] sun-icon"></i>
            <i data-lucide="moon" class="w-[18px] h-[18px] moon-icon"></i>
        </button>

        {{-- Notifications --}}
        @php
            $recentNotifications = config('data.recent_notifications', []);
        @endphp
        <div class="relative">
            <button class="relative w-9 h-9 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 transition-all duration-200"
                    id="btnNotifications" onclick="toggleDropdown('notificationDropdown')">
                <i data-lucide="bell" class="w-[18px] h-[18px]"></i>
                <span id="notif-badge" class="absolute top-2.5 right-2.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white"></span>
            </button>
            <div id="notificationDropdown" class="hidden absolute top-12 right-0 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 z-50 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest">Notifications</h3>
                    <form action="{{ route('notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-[10px] text-indigo-500 hover:text-indigo-600 font-bold uppercase tracking-wider">Mark all as read</button>
                    </form>
                </div>
                <div class="max-h-[320px] overflow-y-auto">
                    @forelse($recentNotifications as $n)
                    <div class="px-4 py-3.5 hover:bg-slate-50 border-b border-slate-50 last:border-0 transition flex gap-3 cursor-pointer group">
                        <div class="w-9 h-9 rounded-xl bg-{{ $n['color'] }}-50 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="{{ $n['icon'] }}" class="w-4 h-4 text-{{ $n['color'] }}-500"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] font-bold text-slate-700 leading-none truncate">{{ $n['title'] }}</p>
                            <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">{{ $n['desc'] }}</p>
                            <p class="text-[9px] font-black text-slate-300 mt-1.5 uppercase tracking-tighter">{{ $n['time'] }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="px-4 py-10 text-center text-slate-300 text-xs italic">No new notifications</div>
                    @endforelse
                </div>
                <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/30 text-center">
                    <a href="{{ route('notifications.index') }}" class="text-[10px] font-black text-indigo-500 hover:text-indigo-600 uppercase tracking-widest">View all activity</a>
                </div>
            </div>
        </div>

        {{-- Messages --}}
        @php
            $recentMessages = config('data.recent_messages', []);
        @endphp
        <div class="relative">
            <button class="relative w-9 h-9 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 transition-all duration-200"
                    id="btnMessages" onclick="toggleDropdown('messageDropdown')">
                <i data-lucide="message-square" class="w-[18px] h-[18px]"></i>
                <span id="msg-badge" class="absolute top-2.5 right-2.5 w-2 h-2 bg-indigo-500 rounded-full ring-2 ring-white"></span>
            </button>
            <div id="messageDropdown" class="hidden absolute top-12 right-0 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 z-50 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest">Messages</h3>
                    <button onclick="markMessagesRead()" class="text-[10px] text-indigo-500 hover:text-indigo-600 font-bold uppercase tracking-wider">Mark as read</button>
                </div>
                <div class="max-h-[320px] overflow-y-auto">
                    @forelse($recentMessages as $m)
                    <div class="px-4 py-3.5 hover:bg-slate-50 border-b border-slate-50 last:border-0 transition flex gap-3 cursor-pointer group">
                        <div class="w-9 h-9 rounded-full bg-{{ $m['color'] }}-50 flex items-center justify-center flex-shrink-0 text-xs font-bold text-{{ $m['color'] }}-600 border border-{{ $m['color'] }}-100">
                            {{ $m['avatar'] }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] font-bold text-slate-700 leading-none truncate">{{ $m['user'] }}</p>
                            <p class="text-[11px] text-slate-400 mt-1 truncate leading-relaxed">{{ $m['desc'] }}</p>
                            <p class="text-[9px] font-black text-slate-300 mt-1.5 uppercase tracking-tighter">{{ $m['time'] }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="px-4 py-10 text-center text-slate-300 text-xs italic">No new messages</div>
                    @endforelse
                </div>
                <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/30 text-center">
                    <a href="#" class="text-[10px] font-black text-indigo-500 hover:text-indigo-600 uppercase tracking-widest">Open inbox</a>
                </div>
            </div>
        </div>

        {{-- Logout --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-slate-100 text-slate-500 transition" title="Logout">
                <i data-lucide="log-out" class="w-[18px] h-[18px]"></i>
            </button>
        </form>
    </div>
</header>

<script>
function toggleDropdown(id) {
    ['notificationDropdown', 'messageDropdown'].forEach(d => {
        const el = document.getElementById(d);
        if (d === id) { el.classList.toggle('hidden'); }
        else { el.classList.add('hidden'); }
    });
    if (typeof lucide !== 'undefined') setTimeout(() => lucide.createIcons(), 10);
}
function markNotificationsRead() {
    const badge = document.getElementById('notif-badge');
    if (badge) badge.classList.add('hidden');
}
function markMessagesRead() {
    const badge = document.getElementById('msg-badge');
    if (badge) badge.classList.add('hidden');
}
document.addEventListener('click', function(event) {
    [['notificationDropdown','btnNotifications'],['messageDropdown','btnMessages']].forEach(([ddId, btnId]) => {
        const dd  = document.getElementById(ddId);
        const btn = document.getElementById(btnId);
        if (dd && !dd.classList.contains('hidden') && !dd.contains(event.target) && btn && !btn.contains(event.target)) {
            dd.classList.add('hidden');
        }
    });
});
(function() {
    const btn = document.getElementById('themeToggle');
    if (btn) {
        btn.onclick = function() {
            const isDark   = document.documentElement.classList.contains('dark');
            const newTheme = isDark ? 'light' : 'dark';
            document.documentElement.classList.toggle('dark', newTheme === 'dark');
            localStorage.setItem('theme', newTheme);
            if (window.lucide) lucide.createIcons();
        };
    }
})();
</script>
