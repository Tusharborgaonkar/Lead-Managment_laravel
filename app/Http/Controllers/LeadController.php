<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index()
    {
        // Stats for header
        $stats = (object)[
            'total'         => 21,
            'not_interested' => 4,
            'followup'      => 5,
            'pending'       => 5,
            'confirm'       => 7,
            'has_notes'     => 5,
            'notes_added_today' => 3,
            'notes_categories_count' => 6
        ];

        $leads = collect([
            (object)[
                'id' => 1, 
                'name' => 'Sarah Johnson', 
                'initials' => 'SJ',
                'color' => 'indigo',
                'company' => 'Acme Corp', 
                'email' => 'sarah@acmecorp.com', 
                'source' => 'Website', 
                'category' => 'Not Interested', 
                'value' => '$12,500', 
                'has_notes' => true,
                'created_at' => 'Feb 19, 2026',
                'followup_date' => null
            ],
            (object)[
                'id' => 2, 
                'name' => 'Ana Petrova', 
                'initials' => 'AP',
                'color' => 'purple',
                'company' => 'GreenLeaf Bio', 
                'email' => 'ana@greenleaf.com', 
                'source' => 'Website', 
                'category' => 'Not Interested', 
                'value' => '$9,200', 
                'has_notes' => false,
                'created_at' => 'Feb 15, 2026',
                'followup_date' => null
            ],
            (object)[
                'id' => 3, 
                'name' => 'Michael Chen', 
                'initials' => 'MC',
                'color' => 'emerald',
                'company' => 'TechCorp Global', 
                'email' => 'm.chen@techcorp.com', 
                'source' => 'Referral', 
                'category' => 'Followup', 
                'value' => '$15,000', 
                'has_notes' => true,
                'created_at' => 'Feb 18, 2026',
                'followup_date' => now()->addDays(2)->setHour(14)->setMinute(30)
            ],
            (object)[
                'id' => 4, 
                'name' => 'Emma Wilson', 
                'initials' => 'EW',
                'color' => 'amber',
                'company' => 'Stellar Marketing', 
                'email' => 'emma.w@stellar.com', 
                'source' => 'WhatsApp', 
                'category' => 'Pending', 
                'value' => '$8,800', 
                'has_notes' => true,
                'created_at' => 'Feb 20, 2026',
                'followup_date' => now()->addDay()->setHour(9)->setMinute(0)
            ],
            (object)[
                'id' => 5, 
                'name' => 'Zoe Miller', 
                'initials' => 'ZM',
                'color' => 'rose',
                'company' => 'Z-Space Labs', 
                'email' => 'zoe@zspace.io', 
                'source' => 'Social Media', 
                'category' => 'Confirm', 
                'value' => '$22,400', 
                'has_notes' => true,
                'created_at' => 'Feb 22, 2026',
                'followup_date' => now()->addDays(5)->setHour(10)->setMinute(0)
            ],
            // ... adding more to match the count 21
        ]);

        // Mock 16 more records
        for ($i = 6; $i <= 21; $i++) {
            $category = $i % 5 == 0 ? 'Not Interested' : ($i % 4 == 0 ? 'Followup' : ($i % 3 == 0 ? 'Pending' : 'Confirm'));
            $leads->push((object)[
                'id' => $i,
                'name' => "Lead User $i",
                'initials' => "LU",
                'color' => 'slate',
                'company' => "Company $i Ltd",
                'email' => "user$i@example.com",
                'source' => 'Cold Call',
                'category' => $category,
                'value' => '$' . number_format(rand(5000, 25000)),
                'has_notes' => $i == 10, // Just one more with notes to make it 5 total
                'created_at' => 'Feb ' . (rand(1, 24)) . ', 2026',
                'followup_date' => in_array($category, ['Followup', 'Pending']) ? now()->addDays(rand(1, 15))->setHour(rand(9, 17))->setMinute(0) : null
            ]);
        }

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
        // Sarah Johnson mock data from image
        $lead = (object)[
            'id' => $id,
            'name' => 'Sarah Johnson',
            'initials' => 'SJ',
            'color' => 'indigo',
            'company' => 'Acme Corp',
            'email' => 'sarah@acmecorp.com',
            'phone' => '+1-305-555-0142',
            'source' => 'Website',
            'category' => 'Not Interested',
            'value' => '$12,500',
            'notes' => 'Looking for enterprise CRM solution.',
            'assigned_to' => 1,
            'assignedUser' => (object)['name' => 'Agent Smith'],
            'created_at' => 'Feb 19, 2026'
        ];
        return view('leads.show', compact('lead'));
    }

    public function edit($id)
    {
        $lead = (object)[
            'id' => $id,
            'name' => 'Sarah Johnson',
            'company' => 'Acme Corp',
            'email' => 'sarah@acmecorp.com',
            'phone' => '+1-305-555-0142',
            'source' => 'Website',
            'status' => 'Not Interested',
            'notes' => 'Looking for enterprise CRM solution.',
            'assigned_to' => 1,
            'assignedUser' => (object)['name' => 'Agent Smith'],
            'created_at' => 'Feb 19, 2026'
        ];
        $agents = collect([(object)['id' => 1, 'name' => 'Agent Smith'], (object)['id' => 2, 'name' => 'Agent J']]);
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

