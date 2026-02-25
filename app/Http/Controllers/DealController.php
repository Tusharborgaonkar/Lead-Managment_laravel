<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class DealController extends Controller
{
    /**
     * Display a listing of deals.
     */
    public function index()
    {
        $stats = (object)[
            'total_deals' => 77,
            'won_value' => '$624K',
            'pipeline_value' => '$342K',
            'win_rate' => '34%',
            'won_trend' => '+18%'
        ];

        $pipelineChart = [
            ['stage' => 'Prospect', 'value' => 60, 'color' => '#6366f1'],
            ['stage' => 'Qualified', 'value' => 140, 'color' => '#10b981'],
            ['stage' => 'Proposal', 'value' => 160, 'color' => '#f59e0b'],
            ['stage' => 'Negotiation', 'value' => 45, 'color' => '#f97316'],
            ['stage' => 'Won', 'value' => 180, 'color' => '#22c55e'],
        ];

        $deals = [
            'Prospect' => [
                (object)['id' => 101, 'title' => 'Website Redesign', 'value' => '$15,000', 'client' => 'Acme Corp', 'color' => 'indigo'],
                (object)['id' => 102, 'title' => 'Mobile App Dev', 'value' => '$48,000', 'client' => 'TechStart Inc', 'color' => 'violet'],
                (object)['id' => 103, 'title' => 'SEO Audit', 'value' => '$5,000', 'client' => 'Miller Industries', 'color' => 'blue'],
                (object)['id' => 104, 'title' => 'Branding Package', 'value' => '$8,500', 'client' => 'Wilson Design', 'color' => 'sky'],
                (object)['id' => 105, 'title' => 'Social Media Strategy', 'value' => '$3,000', 'client' => 'Apex Media', 'color' => 'indigo'],
            ],
            'Qualified' => [
                (object)['id' => 201, 'title' => 'Enterprise CRM', 'value' => '$85,000', 'client' => 'DataFlow Ltd', 'color' => 'emerald'],
                (object)['id' => 202, 'title' => 'Cloud Migration', 'value' => '$62,000', 'client' => 'CloudNine', 'color' => 'teal'],
                (object)['id' => 203, 'title' => 'Data Analysis', 'value' => '$20,000', 'client' => 'Anderson Logistics', 'color' => 'indigo'],
                (object)['id' => 204, 'title' => 'Security Upgrade', 'value' => '$12,000', 'client' => 'Martin Law', 'color' => 'slate'],
            ],
            'Proposal' => [
                (object)['id' => 301, 'title' => 'Data Analytics Suite', 'value' => '$120,000', 'client' => 'GreenLeaf Bio', 'color' => 'amber'],
                (object)['id' => 302, 'title' => 'API Integration', 'value' => '$35,000', 'client' => 'NexGen Labs', 'color' => 'indigo'],
                (object)['id' => 303, 'title' => 'Consulting Retainer', 'value' => '$10,000', 'client' => 'White Architecture', 'color' => 'blue'],
            ],
            'Negotiation' => [
                (object)['id' => 401, 'title' => 'Security Audit', 'value' => '$28,000', 'client' => 'Stellar Mktg', 'color' => 'orange'],
                (object)['id' => 402, 'title' => 'Licensing Agreement', 'value' => '$50,000', 'client' => 'Scott Holdings', 'color' => 'indigo'],
            ],
            'Won' => [
                (object)['id' => 501, 'title' => 'Platform License', 'value' => '$95,000', 'client' => 'InnovateTech', 'color' => 'emerald'],
                (object)['id' => 502, 'title' => 'Annual Contract', 'value' => '$72,000', 'client' => 'BluePeak Co', 'color' => 'indigo'],
                (object)['id' => 503, 'title' => 'Upgrade Package', 'value' => '$30,000', 'client' => 'King Enterprises', 'color' => 'violet'],
            ],
        ];

        return view('deals.index', compact('stats', 'pipelineChart', 'deals'));
    }

    public function create()
    {
        return view('deals.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('deals.index')->with('success', 'Deal created successfully (Static Mock).');
    }

    public function edit($id)
    {
        // Simple mock for editing
        $deal = (object)[
            'id' => $id,
            'title' => 'Sample Deal',
            'value' => '10000',
            'client' => 'Sample Client',
            'stage' => 'Prospect'
        ];
        return view('deals.edit', compact('deal'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('deals.index')->with('success', 'Deal updated successfully (Static Mock).');
    }

    public function destroy($id)
    {
        return redirect()->route('deals.index')->with('success', 'Deal deleted successfully (Static Mock).');
    }
}

