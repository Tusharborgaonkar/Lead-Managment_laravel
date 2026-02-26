<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Followup;
use App\Http\Requests\StoreFollowupRequest;
use App\Http\Requests\UpdateFollowupRequest;

class FollowupController extends Controller
{
    /**
     * Display a listing of follow-ups.
     */
    public function index()
    {
        $followups = Followup::with(['lead', 'customer'])
            ->pending()
            ->whereDate('scheduled_at', '<', now()->toDateString())
            ->latest('scheduled_at')
            ->paginate(10);

        return view('followups.index', compact('followups'));
    }

    public function all()
    {
        $followups = Followup::with(['lead', 'customer'])
            ->latest('scheduled_at')
            ->paginate(10);

        return view('followups.all', compact('followups'));
    }

    public function calendar()
    {
        $events = Followup::whereMonth('scheduled_at', now()->month)
            ->get()
            ->map(function ($f) {
            return (object)[
            'date' => $f->scheduled_at->format('Y-m-d'),
            'title' => $f->title,
            'type' => $f->type ?? 'Followup',
            'color' => 'indigo'
            ];
        });

        return view('followups.calendar', compact('events'));
    }

    public function create()
    {
        $leads = \App\Models\Lead::select('id', 'name', 'company')->get();
        $customers = \App\Models\Customer::select('id', 'name', 'company')->get();
        return view('followups.create', compact('leads', 'customers'));
    }

    public function store(StoreFollowupRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id() ?? 1;

        Followup::create($validated);

        return redirect()->route('followups.index')
            ->with('success', 'Follow-up created successfully.');
    }

    public function edit($id)
    {
        $followup = Followup::findOrFail($id);
        $leads = \App\Models\Lead::select('id', 'name', 'company')->get();
        $customers = \App\Models\Customer::select('id', 'name', 'company')->get();
        return view('followups.edit', compact('followup', 'leads', 'customers'));
    }

    public function update(UpdateFollowupRequest $request, $id)
    {
        $followup = Followup::findOrFail($id);

        $validated = $request->validated();
        $followup->update($validated);

        return redirect()->route('followups.index')
            ->with('success', 'Follow-up updated successfully.');
    }

    public function destroy($id)
    {
        $followup = Followup::findOrFail($id);
        $followup->delete();

        return redirect()->route('followups.index')
            ->with('success', 'Follow-up deleted successfully.');
    }
}
