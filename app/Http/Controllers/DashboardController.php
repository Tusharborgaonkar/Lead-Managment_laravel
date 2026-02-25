<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $totalLeads     = 128;
        $totalCustomers = 84;
        $totalDeals     = 42;
        $openDeals      = 15;
        $wonDeals       = 20;
        $lostDeals      = 7;

        $recentLeads     = collect([
            (object)['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'status' => 'new', 'created_at' => now()->subHours(2)],
            (object)['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'status' => 'contacted', 'created_at' => now()->subHours(5)],
            (object)['id' => 3, 'name' => 'Alice Brown', 'email' => 'alice@example.com', 'status' => 'qualified', 'created_at' => now()->subDays(1)],
        ]);
        
        $recentCustomers = collect([
            (object)['id' => 1, 'name' => 'Global Tech Solutions', 'contact_person' => 'Robert Fox', 'email' => 'contact@globaltech.com', 'status' => 'active', 'created_at' => now()->subDays(2)],
            (object)['id' => 2, 'name' => 'Alpha Corp', 'contact_person' => 'Jenny Wilson', 'email' => 'info@alphacorp.com', 'status' => 'inactive', 'created_at' => now()->subDays(4)],
        ]);

        // Sales Target
        $salesTarget = (object)['current' => 84200, 'target' => 120000, 'percentage' => 70];

        // Revenue Overview (Last 12 months - Apr to Mar)
        $revenueOverview = collect([
            ['month' => 'Apr', 'value' => 8.2],
            ['month' => 'May', 'value' => 9.5],
            ['month' => 'Jun', 'value' => 8.8],
            ['month' => 'Jul', 'value' => 11.2],
            ['month' => 'Aug', 'value' => 10.5],
            ['month' => 'Sep', 'value' => 13.0],
            ['month' => 'Oct', 'value' => 11.8],
            ['month' => 'Nov', 'value' => 14.5],
            ['month' => 'Dec', 'value' => 13.8],
            ['month' => 'Jan', 'value' => 15.6],
            ['month' => 'Feb', 'value' => 18.4],
            ['month' => 'Mar', 'value' => 21.0],
        ]);


        // Leads by Source
        $leadsBySource = collect([
            ['source' => 'Website', 'percentage' => 32, 'color' => '#6366f1'],
            ['source' => 'Referral', 'percentage' => 25, 'color' => '#8b5cf6'],
            ['source' => 'Social Media', 'percentage' => 20, 'color' => '#06b6d4'],
            ['source' => 'Cold Call', 'percentage' => 12, 'color' => '#f59e0b'],
            ['source' => 'WhatsApp', 'percentage' => 8, 'color' => '#10b981'],
            ['source' => 'Events', 'percentage' => 3, 'color' => '#ef4444'],
        ]);

        // Conversion Funnel
        $funnelMetrics = collect([
            ['label' => 'Total Leads', 'count' => 2847, 'percentage' => 100, 'color' => 'indigo'],
            ['label' => 'Qualified', 'count' => 1245, 'percentage' => 44, 'color' => 'sky'],
            ['label' => 'Proposal', 'count' => 562, 'percentage' => 20, 'color' => 'amber'],
            ['label' => 'Won Deals', 'count' => 156, 'percentage' => 5, 'color' => 'emerald'],
        ]);

        // Hot Leads
        $hotLeads = collect([
            (object)['id' => 101, 'name' => 'TechCorp Global', 'value' => '$12,500', 'score' => 95, 'email' => 'm.chen@techcorp.com'],
            (object)['id' => 102, 'name' => 'Stellar Systems', 'value' => '$8,200', 'score' => 88, 'email' => 'contact@stellarsys.io'],
            (object)['id' => 103, 'name' => 'Future Works', 'value' => '$15,000', 'score' => 82, 'email' => 'hr@futureworks.com'],
        ]);

        // Today's Follow-ups
        $todayFollowups = collect([
            (object)['id' => 1, 'lead' => 'Global Logistics', 'time' => '10:30 AM', 'task' => 'Proposal Review Call'],
            (object)['id' => 2, 'lead' => 'Alpha Solutions', 'time' => '02:00 PM', 'task' => 'Final Contract Negotiation'],
            (object)['id' => 3, 'lead' => 'Jenny Wilson', 'time' => '04:30 PM', 'task' => 'Product Demo (Module B)'],
        ]);

        // Recent Activity
        $recentActivities = collect([
            (object)['user' => 'Sarah Johnson', 'action' => 'converted a lead', 'target' => 'Urban Developers', 'time' => '12 min ago', 'icon' => 'user-check', 'color' => 'emerald'],
            (object)['user' => 'Michael Chen', 'action' => 'created a new deal', 'target' => 'Apex Systems', 'time' => '1 hour ago', 'icon' => 'plus-circle', 'color' => 'indigo'],
            (object)['user' => 'Emma Wilson', 'action' => 'closed a deal', 'target' => 'Global Tech', 'time' => '3 hours ago', 'icon' => 'award', 'color' => 'amber'],
        ]);

        $unreadNotifications = 3;

        return view('dashboard.index', compact(
            'totalLeads',
            'totalCustomers',
            'totalDeals',
            'openDeals',
            'wonDeals',
            'lostDeals',
            'recentLeads',
            'recentCustomers',
            'salesTarget',
            'revenueOverview',
            'leadsBySource',
            'funnelMetrics',
            'hotLeads',
            'todayFollowups',
            'recentActivities',
            'unreadNotifications'
        ));

    }
}

