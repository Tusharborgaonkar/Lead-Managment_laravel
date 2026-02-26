<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $stats = (object)[
            'total' => Customer::count(),
            'active' => Customer::where('status', 'active')->count(),
            'avg_value' => '$' . number_format(Customer::avg('total_spent') ?? 0, 2),
            'retention' => '68%',
            'trend' => '+8.3%'
        ];

        $customers = Customer::latest()->paginate(10);

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
        $customer = Customer::with('deals')->findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    public function store(Request $request)
    {
        return redirect()->route('customers.index')->with('success', 'Customer created successfully (Static Mock).');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully (Static Mock).');
    }

    public function destroy($id)
    {
        $deletedIds = session('deleted_customer_ids', []);
        $deletedIds[] = $id;
        session(['deleted_customer_ids' => array_unique($deletedIds)]);

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }
}
