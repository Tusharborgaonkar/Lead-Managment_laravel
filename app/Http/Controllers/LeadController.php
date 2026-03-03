<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Customer;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Traits\LogsActivity;

class LeadController extends Controller
{
    use LogsActivity;
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
            'won' => Lead::where('status', 'Confirm')->count(),
            'lost' => Lead::where('status', 'Not Interested')->count(),
            'followup' => Lead::where('status', 'Followup')->count(),
        ];

        $leads = $query->latest()->paginate(10)->withQueryString();

        return view('leads.index', compact('leads', 'stats'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name')->get(['id', 'name', 'phone']);
        return view('leads.create', compact('customers'));
    }

    public function store(StoreLeadRequest $request)
    {
        $data = $request->validated();
        
        if ($data['customer_type'] === 'existing') {
            $customer = Customer::findOrFail($data['customer_id']);
            $data['client_name'] = $customer->name;
            $data['phone'] = $customer->phone;
            $data['email'] = $customer->email;
            $data['customer_id'] = $customer->id;
        } else {
            // New Customer
            $customer = Customer::create([
                'name' => $data['client_name'],
                'phone' => $data['phone'],
                'email' => $data['email']
            ]);
            $data['customer_id'] = $customer->id;
        }

        $lead = Lead::create($data);

        $this->logActivity('created', $lead, "Created a new lead: {$lead->project_name}");

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

        $this->logActivity('updated', $lead, "Updated lead details for: {$lead->project_name}");

        return redirect()->route('leads.show', $lead->id)->with('success', 'Lead (Project) updated successfully.');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:Pending,Confirm,Not Interested,Followup',
        ]);
        
        $lead->update(['status' => $validated['status']]);
        
        $this->logActivity('status_updated', $lead, "Updated lead status to {$validated['status']} for: {$lead->project_name}");
        
        return back()->with('success', 'Lead status updated instantly.');
    }

    public function destroy(Lead $lead)
    {
        $this->logActivity('deleted', $lead, "Deleted lead: {$lead->project_name}");
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }

    public function convert(Lead $lead)
    {
        if ($lead->status !== 'Confirm') {
            return back()->with('error', 'Only confirmed leads can be converted to a customer.');
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

        $this->logActivity('converted', $lead, "Converted lead {$lead->project_name} to customer {$customer->name}");

        return redirect()->route('customers.show', $customer->id)->with('success', 'Lead converted to Customer successfully.');
    }
}
