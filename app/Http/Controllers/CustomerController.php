<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $stats = (object)[
            'total' => 8,
            'active' => 7,
            'avg_value' => '$387',
            'retention' => '68%',
            'trend' => '+8.3%'
        ];

        $deletedIds = session('deleted_customer_ids', []);

        $customers = collect([
            (object)[
                'id' => 1, 
                'name' => 'Amanda Jenkins', 
                'email' => 'amanda@bluepeak.com', 
                'company' => 'Blue Peak Inc',
                'group' => 'Millennials',
                'status' => 'active', 
                'spent' => '$24.5K',
                'spent_raw' => 24500,
                'orders' => 12,
                'rating' => 4.8,
                'avatar_color' => 'indigo'
            ],
            (object)[
                'id' => 2, 
                'name' => 'Marcus Cole', 
                'email' => 'marcus@solarsys.io', 
                'company' => 'SolarSys.io',
                'group' => 'Millennials',
                'status' => 'active', 
                'spent' => '$18.2K',
                'spent_raw' => 18200,
                'orders' => 8,
                'rating' => 4.6,
                'avatar_color' => 'emerald'
            ],
            (object)[
                'id' => 3, 
                'name' => 'Rachel Patel', 
                'email' => 'rachel@greentech.com', 
                'company' => 'GreenTech Solutions',
                'group' => 'Generation Z',
                'status' => 'active', 
                'spent' => '$31.7K',
                'spent_raw' => 31700,
                'orders' => 16,
                'rating' => 5.0,
                'avatar_color' => 'orange'
            ],
            (object)[
                'id' => 4, 
                'name' => 'Sarah Connor', 
                'email' => 'sarah@cyberdyne.com', 
                'company' => 'Cyberdyne Systems',
                'group' => 'Generation X',
                'status' => 'active', 
                'spent' => '$12.1K',
                'spent_raw' => 12100,
                'orders' => 5,
                'rating' => 4.2,
                'avatar_color' => 'rose'
            ],
            (object)[
                'id' => 5, 
                'name' => 'John Doe', 
                'email' => 'john@example.com', 
                'company' => 'Freelance',
                'group' => 'Millennials',
                'status' => 'inactive', 
                'spent' => '$2.5K',
                'spent_raw' => 2500,
                'orders' => 2,
                'rating' => 3.5,
                'avatar_color' => 'slate'
            ],
        ])->reject(fn($c) => in_array($c->id, $deletedIds));

        return view('customers.index', compact('customers', 'stats'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function edit($id)
    {
        $customer = (object)[
            'id' => $id,
            'name' => 'Amanda Jenkins',
            'company' => 'Blue Peak Inc',
            'email' => 'amanda@bluepeak.com',
            'phone' => '+1 (555) 123-4567',
            'address' => '123 Tech Lane, Silicon Valley, CA',
            'status' => 'active',
            'group' => 'Millennials',
            'notes' => 'Key decision maker for the Q4 expansion project. Prefers email communication.',
            'spent' => '$24.5K',
            'orders' => 12,
            'rating' => 4.8,
            'avatar_color' => 'indigo'
        ];
        return view('customers.edit', compact('customer'));
    }

    public function show($id)
    {
        $customer = (object)[
            'id' => $id,
            'name' => 'Global Tech Solutions',
            'contact_person' => 'Robert Fox',
            'email' => 'robert@globaltech.com',
            'phone' => '123-444-5555',
            'address' => '123 Tech Lane, Silicon Valley, CA',
            'status' => 'active',
            'deals' => collect([]),
            'created_at' => now()->subDays(2)
        ];
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

