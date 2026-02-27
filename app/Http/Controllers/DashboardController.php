<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Lead, Customer, Followup};

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $totalLeads = Lead::count();
        $totalCustomers = Customer::count();
        $pendingLeads = Lead::where('status', 'Pending')->count();
        $wonLeads = Lead::where('status', 'Won')->count();

        // Target / Revenue - Placeholder for now
        $salesTarget = (object)[
            'current' => 325000,
            'target' => 500000,
            'percentage' => 65
        ];

        $revenueOverview = [
            ['month' => 'Jan', 'value' => 12.5],
            ['month' => 'Feb', 'value' => 15.2],
            ['month' => 'Mar', 'value' => 18.7],
            ['month' => 'Apr', 'value' => 14.3],
            ['month' => 'May', 'value' => 20.1],
            ['month' => 'Jun', 'value' => 22.4],
        ];

        $funnelMetrics = [
            ['label' => 'Total Leads', 'count' => $totalLeads, 'color' => 'indigo', 'percentage' => 100],
            ['label' => 'Pending', 'count' => $pendingLeads, 'color' => 'amber', 'percentage' => $totalLeads ? ($pendingLeads/$totalLeads)*100 : 0],
            ['label' => 'Won', 'count' => $wonLeads, 'color' => 'emerald', 'percentage' => $totalLeads ? ($wonLeads/$totalLeads)*100 : 0],
        ];

        $leadsBySource = [
            ['source' => 'Google', 'percentage' => 35, 'color' => '#6366f1'],
            ['source' => 'Direct', 'percentage' => 25, 'color' => '#10b981'],
            ['source' => 'Referral', 'percentage' => 20, 'color' => '#f59e0b'],
            ['source' => 'Email', 'percentage' => 15, 'color' => '#f43f5e'],
            ['source' => 'Other', 'percentage' => 5, 'color' => '#8b5cf6'],
        ];

        $hotLeads = Lead::with('customer')->latest()->take(4)->get();

        $todayFollowups = Followup::with(['lead.customer'])
            ->where('status', 'Pending')
            ->whereDate('followup_date', '>=', now()->toDateString())
            ->orderBy('followup_date', 'asc')
            ->take(5)
            ->get();

        $recentActivities = collect([]);

        $unreadNotifications = 0;

        return view('dashboard.index', compact(
            'totalLeads', 'totalCustomers', 'pendingLeads', 'wonLeads',
            'salesTarget', 'revenueOverview', 'funnelMetrics', 'leadsBySource',
            'hotLeads', 'todayFollowups', 'recentActivities', 'unreadNotifications'
        ));
    }
}
