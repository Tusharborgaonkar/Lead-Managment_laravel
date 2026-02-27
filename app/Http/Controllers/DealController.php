<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deal;
use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
class DealController extends Controller
{
    /**
     * Display a listing of deals.
     */
    public function index(Request $request)
    {
        // STATIC DEMO DATA - NO DATABASE CONNECTION
        $stats = (object)[
            'total_deals' => 450,
            'won_value' => '$325,000',
            'pipeline_value' => '$157,000',
            'win_rate' => '42%',
            'won_trend' => '+15%'
        ];

        $pipelineChart = [
            ['stage' => 'Prospect', 'value' => 85, 'color' => '#6366f1'],
            ['stage' => 'Qualified', 'value' => 65, 'color' => '#10b981'],
            ['stage' => 'Proposal', 'value' => 45, 'color' => '#f59e0b'],
            ['stage' => 'Negotiation', 'value' => 25, 'color' => '#f97316'],
            ['stage' => 'Won', 'value' => 180, 'color' => '#22c55e'],
        ];

        $deals = collect([
            (object)['id' => 1, 'title' => 'Mobile App Dev', 'value' => 15000, 'stage' => 'Negotiation', 'customer' => (object)['id' => 1, 'name' => 'Acme Corp', 'company' => 'Acme Industries'], 'owner' => (object)['name' => 'Admin']],
            (object)['id' => 2, 'title' => 'SEO Optimization', 'value' => 2500, 'stage' => 'Qualified', 'customer' => (object)['id' => 2, 'name' => 'Global Tech', 'company' => 'Global Tech Solutions'], 'owner' => (object)['name' => 'Admin']],
            (object)['id' => 3, 'title' => 'Cloud Migration', 'value' => 50000, 'stage' => 'Proposal', 'customer' => (object)['id' => 3, 'name' => 'Stellar Inc', 'company' => 'Stellar Marketing'], 'owner' => (object)['name' => 'Admin']],
        ])->groupBy('stage');

        return view('deals.index', compact('stats', 'pipelineChart', 'deals'));
    }

    public function create()
    {
        $customers = collect([(object)['id' => 1, 'name' => 'Acme Corp', 'company' => 'Acme Industries']]);
        return view('deals.create', compact('customers'));
    }

    public function store(StoreDealRequest $request)
    {
        return redirect()->route('deals.index')->with('success', 'Static Demo: Deal creation simulated.');
    }

    public function edit($id)
    {
        $deal = (object)['id' => $id, 'name' => 'Mock Deal', 'value' => 5000, 'stage' => 'Prospect'];
        $customers = collect([(object)['id' => 1, 'name' => 'Acme Corp', 'company' => 'Acme Industries']]);
        return view('deals.edit', compact('deal', 'customers'));
    }

    public function update(UpdateDealRequest $request, $id)
    {
        return redirect()->route('deals.index')->with('success', 'Static Demo: Deal update simulated.');
    }

    public function destroy($id)
    {
        return redirect()->route('deals.index')->with('success', 'Static Demo: Deal deletion simulated.');
    }
}
