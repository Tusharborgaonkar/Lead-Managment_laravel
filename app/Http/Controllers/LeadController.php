<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index(Request $request)
    {
        $query = Lead::with(['assignedTo', 'createdBy']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by Category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->filterByCategory($request->category);
        }

        // Filter by Source
        if ($request->filled('source') && $request->source !== 'All Sources') {
            $query->filterBySource($request->source);
        }

        $stats = (object)[
            'total' => Lead::count(),
            'not_interested' => Lead::where('category', 'Not Interested')->count(),
            'followup' => Lead::where('category', 'Followup')->count(),
            'pending' => Lead::pending()->count(),
            'confirm' => Lead::where('category', 'Confirm')->count(),
            'has_notes' => Lead::where('has_notes', true)->count(),
            'notes_added_today' => \App\Models\Note::whereDate('created_at', today())->count(),
            'notes_categories_count' => \App\Models\Note::distinct('category')->count('category')
        ];

        $leads = $query->latest()->paginate(10);

        return view('leads.index', compact('leads', 'stats'));
    }

    public function create()
    {
        $agents = \App\Models\User::where('is_active', true)->get();
        return view('leads.create', compact('agents'));
    }

    public function store(StoreLeadRequest $request)
    {
        $validated = $request->validated();

        // Add auth user context
        $validated['created_by'] = auth()->id() ?? 1;

        Lead::create($validated);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function show($id)
    {
        $lead = Lead::with(['customer', 'deals', 'followups', 'notes.createdBy', 'activityLogs.user'])->findOrFail($id);
        return view('leads.show', compact('lead'));
    }

    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        $agents = \App\Models\User::all();
        return view('leads.edit', compact('lead', 'agents'));
    }

    public function update(UpdateLeadRequest $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $validated = $request->validated();
        $validated['updated_by'] = auth()->id() ?? 1;

        $lead->update($validated);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }
}
