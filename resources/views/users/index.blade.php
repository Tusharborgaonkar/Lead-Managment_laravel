@extends('layouts.app')
@section('title', 'Users — CRM Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Users</h1>
        <p class="text-sm text-slate-400 mt-0.5">{{ $users->count() }} total users</p>
    </div>
    <a href="{{ route('users.roles') }}"
       class="flex items-center gap-2 px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-semibold text-sm hover:bg-slate-200 transition">
        <i data-lucide="shield" class="w-4 h-4"></i> Manage Roles
    </a>
</div>

{{-- Filters --}}
<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-4 mb-4 flex gap-4 flex-wrap">
    <input type="text" id="filterSearch" placeholder="Search name, email…"
           class="flex-1 min-w-40 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
    <select id="filterRole" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
        <option value="">All Roles</option>
        @foreach($roles as $role)
        <option value="{{ $role->name }}">{{ $role->name }}</option>
        @endforeach
    </select>
    <select id="filterStatus" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
        <option value="">All Status</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="usersTable">
            <thead class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700">
                <tr>
                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Role</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Joined</th>
                    <th class="text-right px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 dark:divide-slate-700" id="usersTbody">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition user-row"
                    data-name="{{ strtolower($user->name) }}"
                    data-email="{{ strtolower($user->email) }}"
                    data-role="{{ strtolower($user->role?->name) }}"
                    data-status="{{ $user->status }}">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-400 to-violet-500 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <span class="font-semibold text-slate-800 dark:text-white">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-500">{{ $user->email }}</td>
                    <td class="px-5 py-3.5">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                            {{ $user->role?->name ?? 'No Role' }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $user->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-400">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-5 py-3.5 text-right">
                        <form id="delete-user-{{ $user->id }}" method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" 
                                    class="swal-delete p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" 
                                    data-form-id="delete-user-{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    title="Delete User">
                                <i data-lucide="trash-2" class="w-4 h-4 pointer-events-none"></i>
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-slate-300">You</span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
(function() {
    const search = document.getElementById('filterSearch');
    const role   = document.getElementById('filterRole');
    const status = document.getElementById('filterStatus');

    function applyFilters() {
        const q = search.value.toLowerCase();
        const r = role.value.toLowerCase();
        const s = status.value.toLowerCase();

        document.querySelectorAll('.user-row').forEach(row => {
            const nameMatch   = row.dataset.name.includes(q) || row.dataset.email.includes(q);
            const roleMatch   = !r || row.dataset.role === r;
            const statusMatch = !s || row.dataset.status === s;
            row.style.display = (nameMatch && roleMatch && statusMatch) ? '' : 'none';
        });
    }

    [search, role, status].forEach(el => el.addEventListener('input', applyFilters));
})();
</script>
@endpush
@endsection
