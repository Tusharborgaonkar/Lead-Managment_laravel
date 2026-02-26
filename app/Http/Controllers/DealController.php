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
    public function index()
    {
        $stats = (object)[
            'total_deals' => Deal::count(),
            'won_value' => '$' . number_format(Deal::where('stage', 'Won')->sum('value')),
            'pipeline_value' => '$' . number_format(Deal::where('stage', '!=', 'Won')->sum('value')),
            'win_rate' => Deal::count() > 0 ? round((Deal::where('stage', 'Won')->count() / Deal::count()) * 100) . '%' : '0%',
            'won_trend' => '+0%'
        ];

        $pipelineChart = [
            ['stage' => 'Prospect', 'value' => Deal::where('stage', 'Prospect')->count(), 'color' => '#6366f1'],
            ['stage' => 'Qualified', 'value' => Deal::where('stage', 'Qualified')->count(), 'color' => '#10b981'],
            ['stage' => 'Proposal', 'value' => Deal::where('stage', 'Proposal')->count(), 'color' => '#f59e0b'],
            ['stage' => 'Negotiation', 'value' => Deal::where('stage', 'Negotiation')->count(), 'color' => '#f97316'],
            ['stage' => 'Won', 'value' => Deal::where('stage', 'Won')->count(), 'color' => '#22c55e'],
        ];

        $deals = Deal::latest()->get()->groupBy('stage');

        return view('deals.index', compact('stats', 'pipelineChart', 'deals'));
    }

    public function create()
    {
        return view('deals.create');
    }

    public function store(StoreDealRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id() ?? 1;

        Deal::create($validated);

        return redirect()->route('deals.index')->with('success', 'Deal created successfully.');
    }

    public function edit($id)
    {
        $deal = Deal::findOrFail($id);
        return view('deals.edit', compact('deal'));
    }

    public function update(UpdateDealRequest $request, $id)
    {
        $deal = Deal::findOrFail($id);
        $deal->update($request->validated());

        return redirect()->route('deals.index')->with('success', 'Deal updated successfully.');
    }

    public function destroy($id)
    {
        return redirect()->route('deals.index')->with('success', 'Deal deleted successfully (Static Mock).');
    }
}
