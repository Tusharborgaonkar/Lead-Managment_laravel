<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by Group
        if ($request->filled('group') && $request->group !== 'all') {
            $query->where('group', $request->group);
        }

        $thisMonthCustomers = Customer::whereMonth('created_at', now()->month)->count();
        $lastMonthCustomers = Customer::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count() ?: 1;
        $trendValue = (($thisMonthCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100;

        $stats = (object)[
            'total' => Customer::count(),
            'active' => Customer::where('status', 'active')->count(),
            'avg_value' => '$' . number_format(Customer::avg('total_spent') ?? 0, 2),
            'retention' => Customer::has('deals', '>', 1)->count() > 0 
                ? round((Customer::has('deals', '>', 1)->count() / (Customer::count() ?: 1)) * 100) . '%' 
                : '0%',
            'pending' => Customer::where('status', 'pending')->count(),
            'trend' => ($trendValue >= 0 ? '+' : '') . round($trendValue, 1) . '%'
        ];

        $customers = $query->latest()->paginate(10);

        return view('customers.index', compact('customers', 'stats'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function show($id)
    {
        $customer = Customer::with(['deals', 'leads', 'notes.createdBy', 'activityLogs.user'])->findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    public function store(StoreCustomerRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id() ?? 1;

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validated();
        $validated['updated_by'] = auth()->id() ?? 1;

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
