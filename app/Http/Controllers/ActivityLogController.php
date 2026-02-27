<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
class ActivityLogController extends Controller
{
    /**
     * Display a listing of system activities.
     */
    public function index()
    {
        // STATIC DEMO DATA - NO DATABASE CONNECTION
        $activities = collect([
            (object)['id' => 1, 'user_name' => 'Admin User', 'action' => 'created', 'target' => 'Lead #1', 'description' => 'created a new lead', 'time' => '2 hours ago', 'color' => 'emerald', 'icon' => 'plus-circle', 'type' => 'Created'],
            (object)['id' => 2, 'user_name' => 'System', 'action' => 'updated', 'target' => 'Deal #45', 'description' => 'updated deal status to Negotiation', 'time' => '4 hours ago', 'color' => 'indigo', 'icon' => 'edit-3', 'type' => 'Updated'],
        ]);

        $activities = new \Illuminate\Pagination\LengthAwarePaginator($activities, 2, 15);

        return view('activity.index', compact('activities'));
    }

    public function destroy($id)
    {
        return redirect()->route('activity.index')->with('success', 'Static Demo: Log entry deletion simulated.');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('activity.index')->with('success', 'Static Demo: Log entry update simulated.');
    }
}
