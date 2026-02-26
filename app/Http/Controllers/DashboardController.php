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

        // Target Mock - Keep simple calculation or fetch from settings
        $salesTarget = (object)[
            'current' => Deal::where('stage', 'Won')->sum('value'),
            'target' => 500000,
            'percentage' => Deal::where('stage', 'Won')->sum('value') > 0 ? min(round((Deal::where('stage', 'Won')->sum('value') / 500000) * 100), 100) : 0
        ];

        // Revenue Mock - Alternatively generate real aggregates per month here
        $revenueOverview = [
            ['month' => 'Jan', 'value' => 12],
            ['month' => 'Feb', 'value' => 15],
            ['month' => 'Mar', 'value' => 14],
            ['month' => 'Apr', 'value' => 18],
            ['month' => 'May', 'value' => 16],
            ['month' => 'Jun', 'value' => 20],
        ];

        // Funnel metrics - calculated from real deals table
        $total = Deal::count() ?: 1; // avoid div by zero
        $funnelMetrics = [
            ['label' => 'Total Leads', 'count' => Lead::count(), 'color' => 'indigo', 'percentage' => 100],
            ['label' => 'Qualified', 'count' => Deal::where('stage', 'Qualified')->count(), 'color' => 'emerald', 'percentage' => round((Deal::where('stage', 'Qualified')->count() / $total) * 100)],
            ['label' => 'Proposals', 'count' => Deal::where('stage', 'Proposal')->count(), 'color' => 'amber', 'percentage' => round((Deal::where('stage', 'Proposal')->count() / $total) * 100)],
            ['label' => 'Won Deals', 'count' => Deal::where('stage', 'Won')->count(), 'color' => 'rose', 'percentage' => round((Deal::where('stage', 'Won')->count() / $total) * 100)],
        ];

        // Leads by source
        $leadsBySource = [
            ['source' => 'Website', 'percentage' => 35, 'color' => '#6366f1'],
            ['source' => 'Referral', 'percentage' => 25, 'color' => '#10b981'],
            ['source' => 'Cold Call', 'percentage' => 15, 'color' => '#f59e0b'],
            ['source' => 'Social', 'percentage' => 15, 'color' => '#f43f5e'],
            ['source' => 'Events', 'percentage' => 10, 'color' => '#8b5cf6'],
        ];

        $hotLeads = Lead::whereNotNull('value')->orderByDesc('value')->limit(4)->get()->map(function ($lead) {
            return (object)[
            'name' => $lead->name,
            'email' => $lead->email,
            'value' => '$' . number_format($lead->value),
            'score' => rand(75, 99)
            ];
        });

        $todayFollowups = Followup::with('lead')->whereDate('scheduled_at', today())->limit(4)->get()->map(function ($fup) {
            return (object)[
            'time' => $fup->scheduled_at->format('H:i'),
            'task' => $fup->description,
            'lead' => $fup->lead_name ?? ($fup->lead->name ?? 'Unknown')
            ];
        });

        $recentActivities = ActivityLog::latest()->limit(4)->get()->map(function ($log) {
            return (object)[
            'user' => $log->user->name ?? 'System',
            'action' => strtolower($log->action),
            'target' => $log->details ? json_encode($log->details) : 'Item',
            'time' => $log->created_at->diffForHumans(),
            'icon' => 'check-circle', // placeholder
            'color' => 'emerald' // placeholder
            ];
        });

        // Fallback for empty activities
        if ($recentActivities->isEmpty()) {
            $recentActivities = collect([
                (object)['user' => 'Admin Demo', 'action' => 'updated lead status for', 'target' => 'Sarah Johnson', 'time' => '10 mins ago', 'icon' => 'edit-3', 'color' => 'amber'],
            ]);
        }

        $unreadNotifications = 3;

        return view('dashboard.index', compact(
            'totalLeads', 'totalCustomers', 'totalDeals', 'openDeals',
            'salesTarget', 'revenueOverview', 'funnelMetrics', 'leadsBySource',
            'hotLeads', 'todayFollowups', 'recentActivities', 'unreadNotifications'
        ));

    }
}
