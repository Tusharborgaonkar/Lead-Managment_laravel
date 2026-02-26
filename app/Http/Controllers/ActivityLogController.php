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
        $activities = ActivityLog::with('user')->latest()->paginate(15);

        // Map colors for UI consistency
        $activities->getCollection()->transform(function ($activity) {
            $activity->color = match (strtolower($activity->action)) {
                    'created' => 'emerald',
                    'updated' => 'indigo',
                    'deleted' => 'rose',
                    default => 'slate',
                };
            $activity->icon = match (strtolower($activity->action)) {
                    'created' => 'plus-circle',
                    'updated' => 'edit-3',
                    'deleted' => 'trash-2',
                    default => 'activity',
                };
            return $activity;
        });

        return view('activity.index', compact('activities'));
    }
}
