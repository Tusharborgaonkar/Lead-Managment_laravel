<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index()
    {
        $stats = (object)[
            'total' => Lead::count(),
            'not_interested' => Lead::where('category', 'Not Interested')->count(),
            'followup' => Lead::where('category', 'Followup')->count(),
            'pending' => Lead::where('category', 'Pending')->count(),
            'confirm' => Lead::where('category', 'Confirm')->count(),
            'has_notes' => Lead::where('has_notes', true)->count(),
            'notes_added_today' => 0,
            'notes_categories_count' => 0
        ];

        $leads = Lead::latest()->paginate(10);

        return view('leads.index', compact('leads', 'stats'));
    }

    public function create()
    {
        $agents = collect([(object)['id' => 1, 'name' => 'Agent Smith'], (object)['id' => 2, 'name' => 'Agent J']]);
        return view('leads.create', compact('agents'));
    }

    public function store(Request $request)
    {
        return redirect()->route('leads.index')->with('success', 'Lead created successfully (Static Mock).');
    }

    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        return view('leads.show', compact('lead'));
    }

    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        $agents = \App\Models\User::all();
        return view('leads.edit', compact('lead', 'agents'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('leads.index')->with('success', 'Lead updated successfully (Static Mock).');
    }

    public function destroy($id)
    {
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully (Static Mock).');
    }
}
