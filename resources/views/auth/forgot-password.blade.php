@extends('layouts.guest')
@section('title', 'Forgot Password — CRM Admin')

@section('content')
<div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl p-8 border border-slate-100 dark:border-slate-800">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg">
            <i data-lucide="lock" class="w-5 h-5 text-white"></i>
        </div>
        <div>
            <div class="text-lg font-black text-slate-800 dark:text-white">AcmeCRM</div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Reset your password</div>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
            @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <p class="text-sm text-slate-500 mb-5">Enter your email and we'll send you a link to reset your password.</p>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5" for="email">Email Address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                   class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
                   placeholder="you@example.com" />
        </div>
        <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-500 to-violet-600 text-white py-3 rounded-xl font-bold text-sm hover:from-indigo-600 hover:to-violet-700 transition-all shadow-lg shadow-indigo-500/30">
            Send Reset Link
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-500">
        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">← Back to login</a>
    </p>
</div>
@endsection
