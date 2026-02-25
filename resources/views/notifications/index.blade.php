@extends('layouts.app')
@section('title', 'Notifications — CRM Admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Notifications</h1>
        <p class="text-sm text-slate-400 mt-0.5">{{ $notifications->count() }} total</p>
    </div>
    <form method="POST" action="{{ route('notifications.markAllRead') }}">
        @csrf
        <button type="submit" class="flex items-center gap-2 px-4 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-semibold text-sm hover:bg-indigo-100 transition">
            <i data-lucide="check-circle" class="w-4 h-4"></i> Mark all read
        </button>
    </form>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm divide-y divide-slate-50 dark:divide-slate-700">
    @forelse($notifications as $notification)
    <div class="flex items-start gap-4 px-6 py-4 {{ $notification->is_read ? '' : 'bg-indigo-50/40 dark:bg-indigo-900/10' }}">
        <div class="w-9 h-9 rounded-xl {{ $notification->is_read ? 'bg-slate-100' : 'bg-indigo-100' }} flex items-center justify-center flex-shrink-0">
            <i data-lucide="{{ $notification->is_read ? 'bell' : 'bell-ring' }}" class="w-4 h-4 {{ $notification->is_read ? 'text-slate-400' : 'text-indigo-500' }}"></i>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm {{ $notification->is_read ? 'text-slate-500' : 'font-semibold text-slate-800 dark:text-white' }}">
                {{ $notification->text }}
            </p>
            <p class="text-xs text-slate-400 mt-0.5">{{ $notification->created_at->diffForHumans() }}</p>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            @unless($notification->is_read)
            <form method="POST" action="{{ route('notifications.markRead', $notification->id) }}">
                @csrf
                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition" title="Mark as read">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </button>
            </form>
            @endunless
            <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                @csrf @method('DELETE')
                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="px-6 py-16 text-center text-slate-400">
        <i data-lucide="bell-off" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
        <p class="text-sm">No notifications yet.</p>
    </div>
    @endforelse
</div>
@endsection
