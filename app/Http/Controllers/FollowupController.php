<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Followup;
use App\Models\Lead;
use App\Http\Requests\StoreFollowupRequest;
use App\Http\Requests\UpdateFollowupRequest;

class FollowupController extends Controller
{
    /**
     * Display a listing of follow-ups.
     */
    public function index(Request $request)
    {
        $query = Followup::with('lead.customer')->has('lead');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $followups = $query->orderBy('followup_date', 'asc')->paginate(10)->withQueryString();

        return view('followups.index', compact('followups'));
    }
    
    // API endpoint for dashboard
    public function upcoming()
    {
        $followups = Followup::with('lead.customer')
            ->has('lead')
            ->where('status', 'Pending')
            ->whereDate('followup_date', '>=', now()->toDateString())
            ->orderBy('followup_date', 'asc')
            ->take(10)
            ->get();
            
        return response()->json($followups);
    }

    public function create()
    {
        $leads = Lead::with('customer')->get();
        return view('followups.create', compact('leads'));
    }

    public function store(StoreFollowupRequest $request)
    {
        Followup::create($request->validated());
        return back()->with('success', 'Follow-up scheduled successfully.');
    }

    public function edit(Followup $followup)
    {
        $leads = Lead::with('customer')->get();
        return view('followups.edit', compact('followup', 'leads'));
    }

    public function update(UpdateFollowupRequest $request, Followup $followup)
    {
        $followup->update($request->validated());
        return back()->with('success', 'Follow-up updated successfully.');
    }

    public function destroy(Followup $followup)
    {
        $followup->delete();
        return back()->with('success', 'Follow-up deleted successfully.');
    }

    // Quick action to mark as completed
    public function complete(Followup $followup)
    {
        $followup->update(['status' => 'Completed']);
        return back()->with('success', 'Follow-up marked as completed.');
    }
}
