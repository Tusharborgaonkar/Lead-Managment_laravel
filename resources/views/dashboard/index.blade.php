@extends('layouts.app')
@section('title', 'Dashboard — CRM Admin')

@section('content')
{{-- Page Header --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-black text-slate-800 dark:text-white leading-tight">Dashboard</h1>
        <div class="flex items-center gap-2 mt-1">
            <p class="text-sm text-slate-400 font-medium tracking-tight">Welcome back, Admin Demo!</p>
            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ now()->format('l, F j') }}</div>
        </div>
    </div>

    <div class="flex items-center gap-2.5">
        {{-- Date Filter Dropdown --}}
        <div class="relative">
            <button onclick="toggleDropdown('dateFilterDropdown')" id="btnDateFilter"
                    class="flex items-center gap-2.5 px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/60 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-all active:scale-95 shadow-sm">
                <i data-lucide="calendar" class="w-4 h-4 text-indigo-500"></i>
                <span id="selectedPeriod">Last 30 days</span>
                <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
            </button>
            <div id="dateFilterDropdown" class="hidden absolute top-12 right-0 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700/60 z-50 overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                <div class="p-1.5 space-y-0.5">
                    @foreach(['Today', 'Yesterday', 'Last 7 days', 'Last 30 days', 'This Year'] as $period)
                    <button onclick="setPeriod('{{ $period }}')" 
                            class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:text-indigo-600 dark:hover:text-indigo-400 rounded-xl transition-colors">
                        {{ $period }}
                    </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Export Dropdown --}}
        <div class="relative">
            <button onclick="toggleDropdown('exportDropdown')" id="btnExport"
                    class="flex items-center gap-2.5 px-4 py-2.5 bg-indigo-500 text-white rounded-xl text-sm font-bold hover:bg-indigo-600 transition-all active:scale-95 shadow-lg shadow-indigo-500/25">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Export Report</span>
                <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-white/70"></i>
            </button>
            <div id="exportDropdown" class="hidden absolute top-12 right-0 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-700/60 z-50 overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                <div class="p-1.5 space-y-0.5">
                    <button onclick="exportReport('CSV', 'Dashboard Report')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Export as CSV
                    </button>
                    <button onclick="exportReport('Excel', 'Dashboard Report')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-spreadsheet" class="w-3.5 h-3.5"></i> Export as Excel
                    </button>
                    <button onclick="exportReport('PDF', 'Dashboard Report')" class="w-full text-left px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 dark:hover:text-rose-400 rounded-xl transition-colors flex items-center gap-2.5">
                        <i data-lucide="file-type-2" class="w-3.5 h-3.5"></i> Export as PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Alerts Section --}}
<div class="mb-8">
    <div class="bg-gradient-to-r from-rose-500 to-rose-600 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-lg shadow-rose-500/20">
        <div class="flex items-center gap-4 text-center sm:text-left">
            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0 animate-pulse">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-white"></i>
            </div>
            <div>
                <h3 class="text-white font-black text-lg leading-tight">7 overdue follow-ups require your attention</h3>
                <p class="text-rose-100 text-sm font-medium mt-0.5">Last action was more than 3 days ago on these leads</p>
            </div>
        </div>
        <a href="{{ route('followups.index') }}" 
           class="px-6 py-2.5 bg-white text-rose-600 rounded-xl font-bold text-sm hover:bg-rose-50 transition-all active:scale-95 shadow-sm whitespace-nowrap">
            overdue follow ups
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                <i data-lucide="target" class="w-5 h-5 text-indigo-500"></i>
            </div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Leads</span>
        </div>
        <div class="text-3xl font-black text-slate-800 dark:text-white">{{ number_format($totalLeads) }}</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                <i data-lucide="users" class="w-5 h-5 text-emerald-500"></i>
            </div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Customers</span>
        </div>
        <div class="text-3xl font-black text-slate-800 dark:text-white">{{ number_format($totalCustomers) }}</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center">
                <i data-lucide="handshake" class="w-5 h-5 text-amber-500"></i>
            </div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Deals</span>
        </div>
        <div class="text-3xl font-black text-slate-800 dark:text-white">{{ number_format($totalDeals) }}</div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-sky-50 dark:bg-sky-900/30 flex items-center justify-center">
                <i data-lucide="trending-up" class="w-5 h-5 text-sky-500"></i>
            </div>
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Open Deals</span>
        </div>
        <div class="text-3xl font-black text-slate-800 dark:text-white">{{ number_format($openDeals) }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Revenue Overview (Analytical) --}}
    <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800/60 shadow-sm p-6">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-base font-black text-slate-800 dark:text-white">Revenue Overview</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Live Performance</p>
                </div>
            </div>
            <div class="relative">
                <button class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 dark:bg-slate-800 rounded-lg text-xs font-bold text-slate-500 dark:text-slate-300 border border-slate-100 dark:border-slate-700/50">
                    This Year <i data-lucide="chevron-down" class="w-3 h-3"></i>
                </button>
            </div>
        </div>

        <div class="relative h-80 flex gap-4">
            {{-- Y-Axis Labels --}}
            <div class="flex flex-col justify-between text-[11px] font-bold text-slate-400 pb-8 pr-2">
                @foreach(['₹22L', '₹20L', '₹18L', '₹16L', '₹14L', '₹12L', '₹10L', '₹8L'] as $label)
                <span>{{ $label }}</span>
                @endforeach
            </div>

            <div class="flex-1 relative flex flex-col">
                {{-- Chart Area --}}
                <div class="flex-1 relative">
                    {{-- Grid Lines --}}
                    <div class="absolute inset-0 flex flex-col justify-between">
                        @foreach(range(0, 7) as $i)
                        <div class="border-t border-slate-50 dark:border-slate-800/40 w-full h-0"></div>
                        @endforeach
                    </div>

                    {{-- SVG Line Chart --}}
                    <svg class="absolute inset-0 w-full h-full overflow-visible" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="areaGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:#6366f1;stop-opacity:0.3" />
                                <stop offset="100%" style="stop-color:#6366f1;stop-opacity:0" />
                            </linearGradient>
                        </defs>
                        @php
                            $pts = [];
                            foreach($revenueOverview as $index => $item) {
                                $x = ($index / (count($revenueOverview) - 1)) * 100;
                                // Scale: 8L is 100% (bottom), 22L is 0% (top) -> 100 - ((val - 8) / (22 - 8) * 100)
                                $y = 100 - (($item['value'] - 8) / (22 - 8)) * 100;
                                $pts[] = [$x, $y];
                            }
                            
                            // Bezier Path Generator for smooth curves
                            function generateSmoothPath($points) {
                                if (count($points) < 2) return "";
                                $path = "M " . $points[0][0] . "," . $points[0][1];
                                
                                for ($i = 0; $i < count($points) - 1; $i++) {
                                    $curr = $points[$i];
                                    $next = $points[$i + 1];
                                    
                                    // Calculate control points for smooth curve
                                    $cpX = ($curr[0] + $next[0]) / 2;
                                    $path .= " C $cpX,$curr[1] $cpX,$next[1] $next[0],$next[1]";
                                }
                                return $path;
                            }
                            $smoothPath = generateSmoothPath($pts);
                        @endphp
                        
                        {{-- Area Fill --}}
                        <path d="{{ $smoothPath }} L 100,100 L 0,100 Z" 
                              fill="url(#areaGradient)" 
                              class="transition-all duration-700" />

                        {{-- Main Smooth Line --}}
                        <path d="{{ $smoothPath }}" 
                              fill="none" 
                              stroke="#7c3aed" 
                              stroke-width="1.5" 
                              stroke-linecap="round" 
                              stroke-linejoin="round"
                              class="transition-all duration-700" />

                        {{-- Data Point Markers (rendered as dots that match the viewBox) --}}
                        @foreach($pts as $p)
                            <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="1.2" fill="white" stroke="#7c3aed" stroke-width="0.5" />
                        @endforeach
                    </svg>

                </div>

                {{-- X-Axis Labels --}}
                <div class="flex justify-between mt-4">
                    @foreach($revenueOverview as $item)
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">{{ $item['month'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



    {{-- Sales Target (Small Analytical) --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6">
        <h2 class="text-base font-bold text-slate-800 dark:text-white mb-6">Sales Target</h2>
        <div class="flex flex-col items-center justify-center p-4">
            <div class="relative w-32 h-32 flex items-center justify-center">
                <svg class="w-full h-full -rotate-90">
                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-100 dark:text-slate-700" />
                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" 
                            class="text-indigo-500" 
                            stroke-dasharray="364.4" 
                            stroke-dashoffset="{{ 364.4 * (1 - ($salesTarget->percentage / 100)) }}" />
                </svg>
                <div class="absolute flex flex-col items-center">
                    <span class="text-2xl font-black text-slate-800 dark:text-white">{{ $salesTarget->percentage }}%</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Reached</span>
                </div>
            </div>
            <div class="mt-8 w-full space-y-3">
                <div class="flex justify-between text-xs">
                    <span class="font-bold text-slate-500">Current Sales</span>
                    <span class="font-black text-slate-800 dark:text-white">${{ number_format($salesTarget->current) }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="font-bold text-slate-500">Monthly Target</span>
                    <span class="font-black text-slate-800 dark:text-white">${{ number_format($salesTarget->target) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Lead Conversion Funnel --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6 overflow-hidden">
        <h2 class="text-base font-bold text-slate-800 dark:text-white mb-6">Lead Conversion Funnel</h2>
        <div class="space-y-4">
            @foreach($funnelMetrics as $metric)
            <div class="relative">
                <div class="flex justify-between mb-1.5 px-1">
                    <span class="text-xs font-bold text-slate-600 dark:text-slate-400 capitalize">{{ $metric['label'] }}</span>
                    <span class="text-xs font-black text-slate-800 dark:text-white">{{ number_format($metric['count']) }}</span>
                </div>
                <div class="w-full h-2.5 bg-slate-50 dark:bg-slate-700/50 rounded-full overflow-hidden">
                    <div class="h-full bg-{{ $metric['color'] }}-500 rounded-full" style="width: {{ $metric['percentage'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Leads by Source --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800/60 shadow-sm p-6">
        <h2 class="text-base font-black text-slate-800 dark:text-white mb-8">Leads by Source</h2>
        
        <div class="flex flex-col items-center">
            {{-- High-Fidelity Donut Chart --}}
            <div class="relative w-64 h-64 mb-10 group">
                <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                    @php
                        $cumulativePercentage = 0;
                    @endphp
                    @foreach($leadsBySource as $src)
                        @php
                            $dashArray = $src['percentage'] . " " . (100 - $src['percentage']);
                            $offset = 100 - $cumulativePercentage;
                            $cumulativePercentage += $src['percentage'];
                        @endphp
                        <circle cx="18" cy="18" r="15.915" fill="transparent" 
                                stroke="{{ $src['color'] }}" 
                                stroke-width="4.5" 
                                stroke-dasharray="{{ $dashArray }}" 
                                stroke-dashoffset="{{ $offset }}"
                                class="transition-all duration-300 ease-in-out cursor-pointer hover:stroke-[5] segment-hover"
                                onmouseenter="showChartTooltip(event, '{{ $src['source'] }}', '{{ $src['percentage'] }}', '{{ $src['color'] }}')"
                                onmouseleave="hideChartTooltip()" />
                    @endforeach
                </svg>

                {{-- Chart Tooltip Container --}}
                <div id="chartTooltip" class="hidden absolute z-50 pointer-events-none transition-all duration-200">
                    <div class="bg-slate-900 border border-slate-800 rounded-lg p-2.5 shadow-2xl flex flex-col gap-1 min-w-[100px] relative">
                        <span id="tooltipName" class="text-[11px] font-black text-white"></span>
                        <div class="flex items-center gap-2">
                            <span id="tooltipColor" class="w-3.5 h-3.5 rounded border border-white/20"></span>
                            <span id="tooltipValue" class="text-sm font-black text-white"></span>
                        </div>
                        {{-- Tooltip Arrow --}}
                        <div class="absolute -right-1 top-1/2 -translate-y-1/2 w-2 h-2 bg-slate-900 border-r border-t border-slate-800 rotate-45"></div>
                    </div>
                </div>
            </div>


            {{-- Horizontal Legend --}}
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-y-4 gap-x-2 w-full">
                @foreach($leadsBySource as $src)
                <div class="flex items-center gap-2">
                    <span class="w-3.5 h-1.5 rounded-sm flex-shrink-0" style="background-color: {{ $src['color'] }}"></span>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 whitespace-nowrap">{{ $src['source'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Hot Leads --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700 flex justify-between items-center">
            <h2 class="text-base font-bold text-slate-800 dark:text-white">Hot Leads</h2>
            <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[10px] font-black rounded uppercase tracking-widest">High Potential</span>
        </div>
        <div class="divide-y divide-slate-50 dark:divide-slate-700/50 flex-1">
            @foreach($hotLeads as $lead)
            <div class="px-6 py-3.5 flex items-center justify-between hover:bg-slate-50/50 dark:hover:bg-slate-700/20 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-400 to-rose-500 flex items-center justify-center text-white text-xs font-black flex-shrink-0 shadow-sm">
                        {{ strtoupper(substr($lead->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $lead->name }}</p>
                        <p class="text-xs text-slate-400 font-medium">{{ $lead->email }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-black text-slate-800 dark:text-white">{{ $lead->value }}</p>
                    <div class="flex items-center gap-1 justify-end mt-0.5">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                        <span class="text-[10px] font-bold text-emerald-500">{{ $lead->score }}/100</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="px-6 py-3 border-t border-slate-50 dark:border-slate-700 bg-slate-50/30 text-center">
            <a href="{{ route('leads.index') }}" class="text-xs font-bold text-indigo-500 hover:text-indigo-600 transition-colors">Prioritize all leads →</a>
        </div>
    </div>

    {{-- Today's Follow-ups --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700 flex justify-between items-center">
            <h2 class="text-base font-bold text-slate-800 dark:text-white">Today's Follow-ups</h2>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ now()->format('M d') }}</span>
        </div>
        <div class="divide-y divide-slate-50 dark:divide-slate-700/50 flex-1">
            @foreach($todayFollowups as $task)
            <div class="px-6 py-3.5 flex items-start gap-4 hover:bg-slate-50/50 dark:hover:bg-slate-700/20 transition-colors group">
                <div class="flex flex-col items-center flex-shrink-0 pt-0.5">
                    <span class="text-[10px] font-black text-indigo-500 group-hover:scale-110 transition-transform">{{ $task->time }}</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $task->task }}</p>
                    <div class="flex items-center gap-1 mt-0.5">
                        <i data-lucide="user" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-xs text-slate-400 font-medium">{{ $task->lead }}</span>
                    </div>
                </div>
                <button class="w-8 h-8 rounded-lg border border-slate-100 dark:border-slate-700 flex items-center justify-center text-slate-300 hover:text-emerald-500 hover:border-emerald-100 hover:bg-emerald-50 transition-all">
                    <i data-lucide="check" class="w-4 h-4"></i>
                </button>
            </div>
            @endforeach
        </div>
        <div class="px-6 py-3 border-t border-slate-50 dark:border-slate-700 bg-slate-50/30 text-center">
            <a href="{{ route('followups.all') }}" class="text-xs font-bold text-indigo-500 hover:text-indigo-600 transition-colors">View all Followups →</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-700 flex items-center justify-between">
            <h2 class="text-base font-bold text-slate-800 dark:text-white">Recent Activity</h2>
            <a href="{{ route('activity.index') }}" class="text-xs font-bold text-indigo-500 hover:text-indigo-600 transition-colors">View all →</a>
        </div>
        <div class="p-6">
            <div class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-100 before:to-transparent">
                @foreach($recentActivities as $act)
                <div class="relative flex items-center justify-between group">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-{{ $act->color }}-50 dark:bg-{{ $act->color }}-900/20 flex items-center justify-center flex-shrink-0 z-10 border-4 border-white dark:border-slate-800 shadow-sm transition-transform group-hover:scale-110">
                            <i data-lucide="{{ $act->icon }}" class="w-4 h-4 text-{{ $act->color }}-500"></i>
                        </div>
                        <div>
                            <p class="text-[13px] text-slate-600 dark:text-slate-300">
                                <span class="font-black text-slate-800 dark:text-white">{{ $act->user }}</span> 
                                {{ $act->action }} <span class="font-bold text-indigo-500">{{ $act->target }}</span>
                            </p>
                            <span class="text-[10px] font-bold text-slate-400 mt-1 uppercase">{{ $act->time }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm p-6">
        <h2 class="text-base font-bold text-slate-800 dark:text-white mb-6">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-4">
            <button onclick="alert('Static Demo: Create Lead flow would open here.')" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-700/50 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 border border-transparent hover:border-indigo-100 transition-all flex flex-col items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center transition-transform group-hover:-translate-y-1">
                    <i data-lucide="user-plus" class="w-5 h-5 text-indigo-500"></i>
                </div>
                <span class="text-xs font-bold text-slate-500 group-hover:text-indigo-600 transition-colors">Add Lead</span>
            </button>
            <button onclick="alert('Static Demo: New Deal flow would open here.')" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-700/50 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 border border-transparent hover:border-emerald-100 transition-all flex flex-col items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center transition-transform group-hover:-translate-y-1">
                    <i data-lucide="handshake" class="w-5 h-5 text-emerald-500"></i>
                </div>
                <span class="text-xs font-bold text-slate-500 group-hover:text-emerald-600 transition-colors">Add Deal</span>
            </button>
            <button onclick="alert('Static Demo: Report generator would open here.')" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-700/50 hover:bg-amber-50 dark:hover:bg-amber-900/20 border border-transparent hover:border-amber-100 transition-all flex flex-col items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center transition-transform group-hover:-translate-y-1">
                    <i data-lucide="file-text" class="w-5 h-5 text-amber-500"></i>
                </div>
                <span class="text-xs font-bold text-slate-500 group-hover:text-amber-600 transition-colors">Generate Report</span>
            </button>
            <button onclick="alert('Static Demo: User settings would open here.')" class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-700/50 hover:bg-sky-50 dark:hover:bg-sky-900/20 border border-transparent hover:border-sky-100 transition-all flex flex-col items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center transition-transform group-hover:-translate-y-1">
                    <i data-lucide="settings" class="w-5 h-5 text-sky-500"></i>
                </div>
                <span class="text-xs font-bold text-slate-500 group-hover:text-sky-600 transition-colors">Settings</span>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function setPeriod(period) {
    document.getElementById('selectedPeriod').innerText = period;
    document.getElementById('dateFilterDropdown').classList.add('hidden');
    // Simplified: Just flash a success message for the mock
    const alert = document.createElement('div');
    alert.className = 'fixed top-6 right-6 z-50 alert-success animate-in slide-in-from-right-full';
    alert.innerText = `Dashboard filtered for: ${period}`;
    document.body.appendChild(alert);
    setTimeout(() => {
        alert.classList.add('animate-out', 'fade-out');
        setTimeout(() => alert.remove(), 500);
    }, 3000);
}

// Donut Chart Tooltip Logic
function showChartTooltip(e, name, value, color) {
    const tooltip = document.getElementById('chartTooltip');
    const nameEl = document.getElementById('tooltipName');
    const valueEl = document.getElementById('tooltipValue');
    const colorEl = document.getElementById('tooltipColor');
    
    nameEl.innerText = name;
    valueEl.innerText = value;
    colorEl.style.backgroundColor = color;
    
    tooltip.classList.remove('hidden');
    
    // Position tooltip relative to the hover point
    const rect = e.target.closest('.group').getBoundingClientRect();
    const x = e.clientX - rect.left + 15;
    const y = e.clientY - rect.top - 40;
    
    tooltip.style.left = `${x}px`;
    tooltip.style.top = `${y}px`;
}

function hideChartTooltip() {
    document.getElementById('chartTooltip').classList.add('hidden');
}

// Reuse toggleDropdown from header but handle dashboard-specific ones too
// Dropdowns are now handled globally in app.js
</script>
@endpush
@endsection

