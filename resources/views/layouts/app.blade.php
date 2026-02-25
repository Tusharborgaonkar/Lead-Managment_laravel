<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CRM Admin')</title>

    {{-- Dark mode: prevent FOUC --}}
    <script>
        (function(){
            const t = localStorage.getItem('theme');
            const d = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if(t === 'dark' || (!t && d)) document.documentElement.classList.add('dark');
        })();
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Tailwind CSS (CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                }
            }
        };
    </script>

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body class="min-h-screen" style="font-family: 'Inter', sans-serif;">

<div class="app-layout">
    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Header --}}
        @include('partials.header')

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert-success" data-auto-dismiss="4000">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert-error" data-auto-dismiss="4000">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

{{-- Main JS (Lucide init + dark mode + dropdowns) --}}
<script src="{{ asset('js/app.js') }}"></script>
<script>
    if (typeof lucide !== 'undefined') lucide.createIcons();
</script>
@stack('scripts')
</body>
</html>
