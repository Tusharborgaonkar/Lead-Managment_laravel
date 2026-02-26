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
        $followups = collect([
            (object)[
                'id' => 1,
                'lead_name' => 'TechCorp Solutions',
                'contact_person' => 'Alice Johnson',
                'followup_at' => now()->addDays(5)->setHour(10)->setMinute(0),
                'status' => 'pending',
                'assigned_to' => 'Admin Demo',
                'description' => 'Did not respond to initial proposal sent last week.'
            ],
            (object)[
                'id' => 2,
                'lead_name' => 'Stellar Marketing',
                'contact_person' => 'Bob Smith',
                'followup_at' => now()->addDays(2)->setHour(14)->setMinute(30),
                'status' => 'pending',
                'assigned_to' => 'Admin Demo',
                'description' => 'Follow up on the pending invoice for the Cloud Migration project.'
            ],
            (object)[
                'id' => 3,
                'lead_name' => 'Global Logistics Co.',
                'contact_person' => 'Charlie Brown',
                'followup_at' => now()->addDays(8)->setHour(11)->setMinute(0),
                'status' => 'pending',
                'assigned_to' => 'Admin Demo',
                'description' => 'Schedule a demo for the new CRM features.'
            ],
            (object)[
                'id' => 4,
                'lead_name' => 'Innovation Hub',
                'contact_person' => 'Diana Prince',
                'followup_at' => now()->addDay()->setHour(9)->setMinute(0),
                'status' => 'pending',
                'assigned_to' => 'Admin Demo',
                'description' => 'Needs a follow-up call regarding the partnership agreement.'
            ],
            (object)[
                'id' => 5,
                'lead_name' => 'Urban Developers',
                'contact_person' => 'Edward Norton',
                'followup_at' => now()->addDays(13)->setHour(15)->setMinute(0),
                'status' => 'pending',
                'assigned_to' => 'Admin Demo',
                'description' => 'Request for additional information on pricing tiers.'
            ],
            (object)[
                'id' => 6,
                'lead_name' => 'Apex Systems',
                'contact_person' => 'Fiona Gallagher',
                'followup_at' => now()->subDays(2),
                'status' => 'overdue',
                'assigned_to' => 'Admin Demo',
                'description' => 'Initial contact made, need to qualify the lead.'
            ],
            (object)[
                'id' => 7,
                'lead_name' => 'Zenith Enterprises',
                'contact_person' => 'George Costanza',
                'followup_at' => now()->subDay(),
                'status' => 'overdue',
                'assigned_to' => 'Admin Demo',
                'description' => 'Waiting for feedback on the custom feature request.'
            ],
        ]);

        return view('followups.index', compact('followups'));
    }

    public function all()
    {
        $followups = collect([
            (object)[
                'id' => 1,
                'lead_name' => 'TechCorp Solutions',
                'contact_person' => 'Alice Johnson',
                'followup_at' => now()->addDays(5)->setHour(10)->setMinute(0),
                'status' => 'pending',
                'assigned_to' => 'Admin Demo',
                'description' => 'Did not respond to initial proposal sent last week.'
            ],
            (object)[
                'id' => 2,
                'lead_name' => 'Stellar Marketing',
                'contact_person' => 'Bob Smith',
                'followup_at' => now()->addDays(2)->setHour(14)->setMinute(30),
                'status' => 'pending',
                'assigned_to' => 'Admin Demo',
                'description' => 'Follow up on the pending invoice for the Cloud Migration project.'
            ],
            (object)[
                'id' => 3,
                'lead_name' => 'Global Logistics Co.',
                'contact_person' => 'Charlie Brown',
                'followup_at' => now()->addDays(8)->setHour(11)->setMinute(0),
                'status' => 'pending',
                'assigned_to' => 'Admin Demo',
                'description' => 'Schedule a demo for the new CRM features.'
            ],
            (object)[
                'id' => 4,
                'lead_name' => 'Innovation Hub',
                'contact_person' => 'Diana Prince',
                'followup_at' => now()->addDay()->setHour(9)->setMinute(0),
                'status' => 'pending',
                'assigned_to' => 'Admin Demo',
                'description' => 'Needs a follow-up call regarding the partnership agreement.'
            ],
            (object)[
                'id' => 5,
                'lead_name' => 'Urban Developers',
                'contact_person' => 'Edward Norton',
                'followup_at' => now()->addDays(13)->setHour(15)->setMinute(0),
                'status' => 'pending',
                'assigned_to' => 'Admin Demo',
                'description' => 'Request for additional information on pricing tiers.'
            ],
            (object)[
                'id' => 6,
                'lead_name' => 'Apex Systems',
                'contact_person' => 'Fiona Gallagher',
                'followup_at' => now()->subDays(2),
                'status' => 'overdue',
                'assigned_to' => 'Admin Demo',
                'description' => 'Initial contact made, need to qualify the lead.'
            ],
            (object)[
                'id' => 7,
                'lead_name' => 'Zenith Enterprises',
                'contact_person' => 'George Costanza',
                'followup_at' => now()->subDay(),
                'status' => 'overdue',
                'assigned_to' => 'Admin Demo',
                'description' => 'Waiting for feedback on the custom feature request.'
            ],
        ]);

        return view('followups.all', compact('followups'));
    }

    public function calendar()
    {
        $events = collect([
            (object)['date' => now()->format('Y-m-d'), 'title' => 'Follow up with TechCorp', 'type' => 'Call', 'color' => 'indigo'],
            (object)['date' => now()->addDays(1)->format('Y-m-d'), 'title' => 'Strategy Meeting - Stellar', 'type' => 'Meeting', 'color' => 'emerald'],
            (object)['date' => now()->addDays(2)->format('Y-m-d'), 'title' => 'Send proposal - Zenith', 'type' => 'Email', 'color' => 'amber'],
            (object)['date' => now()->subDays(1)->format('Y-m-d'), 'title' => 'Initial inquiry - Global', 'type' => 'Lead', 'color' => 'sky'],
            (object)['date' => now()->addDays(4)->format('Y-m-d'), 'title' => 'Contract Review - Apex', 'type' => 'Legal', 'color' => 'rose'],
            (object)['date' => now()->addDays(3)->format('Y-m-d'), 'title' => 'Demo - Innovation Hub', 'type' => 'Demo', 'color' => 'indigo'],
        ]);

        return view('followups.calendar', compact('events'));
    }

    public function store(StoreFollowupRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id() ?? 1;

        Followup::create($validated);

        return redirect()->route('followups.index')
            ->with('success', 'Follow-up created successfully.');
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
        return redirect()->route('followups.index')
            ->with('success', 'Follow-up resolved successfully (Static Mock).');
    }
}
