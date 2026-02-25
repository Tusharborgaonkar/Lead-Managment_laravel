@extends('layouts.guest')
@section('title', 'Register — CRM Admin')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl p-8 border border-slate-100 dark:border-slate-800">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg">
            <i data-lucide="zap" class="w-5 h-5 text-white"></i>
        </div>
        <div>
            <div class="text-lg font-black text-slate-800 dark:text-white">AcmeCRM</div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Create your account</div>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" for="name">Full Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                   placeholder="John Doe" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" for="email">Email Address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                   placeholder="you@example.com" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" for="password">Password</label>
            <input id="password" name="password" type="password" required
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                   placeholder="Min. 8 characters" />
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                   placeholder="Repeat password" />
        </div>

        <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-500 to-violet-600 text-white py-3 rounded-xl font-bold text-sm hover:from-indigo-600 hover:to-violet-700 transition-all shadow-lg shadow-indigo-500/30">
            Create Account
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        Already have an account?
        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">Sign in</a>
    </p>
</div>
@endsection
