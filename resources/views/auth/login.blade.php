@extends('layouts.guest')
@section('title', 'Login — CRM Admin')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl p-8 border border-slate-100 dark:border-slate-800">
    {{-- Logo --}}
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg">
            <i data-lucide="zap" class="w-5 h-5 text-white"></i>
        </div>
        <div>
            <div class="text-lg font-black text-slate-800 dark:text-white">AcmeCRM</div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sign in to your account</div>
        </div>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" for="email">Email Address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                   class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-rose-500 ring-2 ring-rose-500/10' : 'border-slate-200 dark:border-slate-700' }} bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                   placeholder="admin@crm-industries.com" />
            @error('email')
                <p class="mt-1.5 text-xs font-bold text-rose-500 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" for="password">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                   class="w-full px-4 py-3 rounded-xl border {{ $errors->has('password') ? 'border-rose-500 ring-2 ring-rose-500/10' : 'border-slate-200 dark:border-slate-700' }} bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                   placeholder="••••••••" />
            @error('password')
                <p class="mt-1.5 text-xs font-bold text-rose-500 flex items-center gap-1">
                    <i data-lucide="alert-circle" class="w-3 h-3"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded">
                Remember me
            </label>
            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Forgot password?</a>
        </div>

        <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-500 to-violet-600 text-white py-3 rounded-xl font-bold text-sm hover:from-indigo-600 hover:to-violet-700 transition-all shadow-lg shadow-indigo-500/30">
            Sign In
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">Register</a>
    </p>
</div>
@endsection
