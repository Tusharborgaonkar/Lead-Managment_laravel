<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Customer;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;

class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index(Request $request)
    {
        $query = Lead::with('customer');

        // Apply Status Filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Apply Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('project_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('company_name', 'like', "%{$search}%");
                  });
            });
        }

        $stats = (object)[
            'total' => Lead::count(),
            'pending' => Lead::where('status', 'Pending')->count(),
            'won' => Lead::where('status', 'Won')->count(),
            'lost' => Lead::where('status', 'Lost')->count(),
        ];

        $leads = $query->latest()->paginate(10)->withQueryString();

        return view('leads.index', compact('leads', 'stats'));
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(StoreLeadRequest $request)
    {
        Lead::create($request->validated());

        return redirect()->route('leads.index')->with('success', 'Lead (Project) created successfully.');
    }

    public function show(Lead $lead)
    {
        $lead->load(['customer', 'notes', 'followups']);
        return view('leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        return view('leads.edit', compact('lead'));
    }

    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $lead->update($request->validated());

        return redirect()->route('leads.show', $lead->id)->with('success', 'Lead (Project) updated successfully.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    public function convert(Lead $lead)
    {
        if ($lead->status !== 'Won') {
            return back()->with('error', 'Only Won leads can be converted to Customers.');
        }

        if ($lead->customer_id) {
            return back()->with('error', 'Lead is already converted.');
        }

        // Check if customer already exists by phone or email
        $customer = null;
        if ($lead->phone || $lead->email) {
            $query = Customer::query();
            if ($lead->phone) $query->orWhere('phone', $lead->phone);
            if ($lead->email) $query->orWhere('email', $lead->email);
            $customer = $query->first();
        }

        if (!$customer) {
            $customer = Customer::create([
                'name' => $lead->client_name,
                'phone' => $lead->phone,
                'email' => $lead->email,
            ]);
        }

        $lead->update(['customer_id' => $customer->id]);

        return redirect()->route('customers.show', $customer->id)->with('success', 'Lead converted to Customer successfully.');
    }
}
