<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Lead, Customer, Deal, Followup, ActivityLog};
class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $totalLeads = Lead::count();
        $totalCustomers = Customer::count();
        $totalDeals = Deal::count();
        $openDeals = Deal::whereNotIn('stage', ['Won', 'Lost'])->count();

        // Dynamic Sales Target from settings or default
        $targetValue = (float) \App\Models\Setting::get(auth()->id() ?? 1, 'sales_target', 500000);
        $wonValue = Deal::where('stage', 'Won')->sum('value');
        $salesTarget = (object)[
            'current' => $wonValue,
            'target' => $targetValue,
            'percentage' => $targetValue > 0 ? min(round(($wonValue / $targetValue) * 100), 100) : 0
        ];

        // Revenue Aggregates for the last 6 months - Efficient query
        $revenueOverview = Deal::where('stage', 'Won')
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('SUM(value) as value'),
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw("YEAR(created_at) as year"),
                DB::raw("MONTH(created_at) as month_num")
            )
            ->groupBy('year', 'month_num', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month_num', 'asc')
            ->get()
            ->map(fn($item) => ['month' => $item->month, 'value' => (float)$item->value])
            ->toArray();

        // Funnel metrics - calculated from real deals table
        $total = Deal::count() ?: 1; // avoid div by zero
        $funnelMetrics = [
            ['label' => 'Total Leads', 'count' => $totalLeads, 'color' => 'indigo', 'percentage' => 100],
            ['label' => 'Qualified', 'count' => Deal::where('stage', 'Qualified')->count(), 'color' => 'emerald', 'percentage' => round((Deal::where('stage', 'Qualified')->count() / $total) * 100)],
            ['label' => 'Proposals', 'count' => Deal::where('stage', 'Proposal')->count(), 'color' => 'amber', 'percentage' => round((Deal::where('stage', 'Proposal')->count() / $total) * 100)],
            ['label' => 'Won Deals', 'count' => Deal::where('stage', 'Won')->count(), 'color' => 'rose', 'percentage' => round((Deal::where('stage', 'Won')->count() / $total) * 100)],
        ];

        // Leads by source - Aggregated from DB
        $sourceCounts = Lead::select('source', DB::raw('count(*) as count'))
            ->groupBy('source')
            ->get();
        
        $totalLeadsForSource = $sourceCounts->sum('count') ?: 1;
        $colors = ['#6366f1', '#10b981', '#f59e0b', '#f43f5e', '#8b5cf6'];
        
        $leadsBySource = $sourceCounts->map(function ($item, $index) use ($totalLeadsForSource, $colors) {
            return [
                'source' => $item->source ?: 'Unknown',
                'percentage' => round(($item->count / $totalLeadsForSource) * 100),
                'color' => $colors[$index % count($colors)]
            ];
        })->toArray();

        $hotLeads = Lead::whereNotNull('value')->orderByDesc('value')->limit(4)->get()->map(function ($lead) {
            return (object)[
                'name' => $lead->name,
                'email' => $lead->email,
                'value' => '$' . number_format($lead->value),
                'score' => $lead->value > 10000 ? 99 : ($lead->value > 5000 ? 85 : 75)
            ];
        });

        $todayFollowups = Followup::with('lead')->whereDate('scheduled_at', today())->limit(4)->get()->map(function ($fup) {
            return (object)[
                'time' => $fup->scheduled_at->format('H:i'),
                'task' => $fup->description,
                'lead' => $fup->lead->name ?? 'Unknown'
            ];
        });

        $recentActivities = ActivityLog::with('user')->latest()->limit(4)->get()->map(function ($log) {
            return (object)[
                'user' => $log->user->name ?? 'System',
                'action' => strtolower($log->action),
                'target' => $log->description ?: 'Item',
                'time' => $log->created_at->diffForHumans(),
                'icon' => 'check-circle', 
                'color' => 'emerald'
            ];
        });

        $unreadNotifications = \App\Models\Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->count();

        return view('dashboard.index', compact(
            'totalLeads', 'totalCustomers', 'totalDeals', 'openDeals',
            'salesTarget', 'revenueOverview', 'funnelMetrics', 'leadsBySource',
            'hotLeads', 'todayFollowups', 'recentActivities', 'unreadNotifications'
        ));

    }
}
