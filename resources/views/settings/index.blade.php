@extends('layouts.app')
@section('title', 'Settings — CRM Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-800 dark:text-white">Settings</h1>
        <p class="text-sm text-slate-400 mt-0.5">Manage your CRM preferences</p>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6">
        <form method="POST" action="{{ route('settings.update') }}" class="space-y-6">
            @csrf @method('PUT')

            {{-- App Info --}}
            <div>
                <h2 class="text-sm font-bold text-slate-700 dark:text-white uppercase tracking-widest mb-4">Application</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300 mb-1.5">App Name</label>
                        <input type="text" name="site_name" value="{{ config('data.app.name', 'CRM Admin') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300 mb-1.5">Admin Email</label>
                        <input type="email" name="admin_email" value="{{ config('data.app.admin_email') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-600 dark:text-slate-300 mb-1.5">Timezone</label>
                        <select name="timezone"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            <option value="UTC">UTC</option>
                            <option value="America/New_York">America/New_York</option>
                            <option value="America/Chicago">America/Chicago</option>
                            <option value="America/Los_Angeles">America/Los_Angeles</option>
                            <option value="Asia/Kolkata">Asia/Kolkata</option>
                            <option value="Europe/London">Europe/London</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100 dark:border-slate-700">

            {{-- Notification Preferences --}}
            <div>
                <h2 class="text-sm font-bold text-slate-700 dark:text-white uppercase tracking-widest mb-4">Notification Preferences</h2>
                <div class="space-y-3">
                    @foreach(config('data.notification_settings', []) as $notif)
                    <label class="flex items-center justify-between p-4 rounded-xl border border-slate-100 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/40 cursor-pointer transition">
                        <div>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $notif['label'] }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $notif['desc'] }}</p>
                        </div>
                        <input type="checkbox" name="notif_{{ Str::slug($notif['label']) }}" {{ $notif['checked'] ? 'checked' : '' }}
                               class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-500">
                    </label>
                    @endforeach
                </div>
            </div>

            <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-violet-600 text-white rounded-xl font-bold text-sm hover:from-indigo-600 hover:to-violet-700 transition shadow-lg shadow-indigo-500/25">
                Save Settings
            </button>
        </form>
    </div>
</div>
@endsection
