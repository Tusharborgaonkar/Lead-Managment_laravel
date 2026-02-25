<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of system activities.
     */
    public function index()
    {
        $activities = collect([
            (object)['user' => 'Sarah Johnson', 'action' => 'converted a lead', 'target' => 'Urban Developers', 'time' => '12 min ago', 'icon' => 'user-check', 'color' => 'emerald', 'type' => 'Success'],
            (object)['user' => 'Michael Chen', 'action' => 'created a new deal', 'target' => 'Apex Systems', 'time' => '1 hour ago', 'icon' => 'plus-circle', 'color' => 'indigo', 'type' => 'Info'],
            (object)['user' => 'Emma Wilson', 'action' => 'closed a deal', 'target' => 'Global Tech', 'time' => '3 hours ago', 'icon' => 'award', 'color' => 'amber', 'type' => 'Success'],
            (object)['user' => 'Admin Demo', 'action' => 'updated settings', 'target' => 'System Preferences', 'time' => '5 hours ago', 'icon' => 'settings', 'color' => 'slate', 'type' => 'System'],
            (object)['user' => 'John Doe', 'action' => 'deleted a lead', 'target' => 'Old Prospect Corp', 'time' => 'Yesterday', 'icon' => 'trash-2', 'color' => 'rose', 'type' => 'Warning'],
            (object)['user' => 'Sarah Johnson', 'action' => 'scheduled a call', 'target' => 'TechCorp Solutions', 'time' => 'Yesterday', 'icon' => 'phone', 'color' => 'indigo', 'type' => 'Activity'],
            (object)['user' => 'Admin Demo', 'action' => 'exported report', 'target' => 'Monthly Sales PDF', 'time' => '2 days ago', 'icon' => 'download', 'color' => 'emerald', 'type' => 'System'],
            (object)['user' => 'Emma Wilson', 'action' => 'added a note', 'target' => 'Alpha Solutions', 'time' => '2 days ago', 'icon' => 'file-text', 'color' => 'indigo', 'type' => 'Activity'],
            (object)['user' => 'Michael Chen', 'action' => 'changed deal stage', 'target' => 'Stellar Systems', 'time' => '3 days ago', 'icon' => 'refresh-cw', 'color' => 'amber', 'type' => 'Update'],
            (object)['user' => 'Sarah Johnson', 'action' => 'assigned a task', 'target' => 'Jane Smith', 'time' => '3 days ago', 'icon' => 'user-plus', 'color' => 'indigo', 'type' => 'System'],
        ]);

        return view('activity.index', compact('activities'));
    }
}
