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
        $activities = ActivityLog::with('user')
            ->latest()
            ->paginate(15)
            ->through(function ($log) {
                $icon = 'activity';
                $color = 'slate';
                
                switch ($log->action) {
                    case 'created':
                        $icon = 'plus-circle';
                        $color = 'emerald';
                        break;
                    case 'updated':
                    case 'status_updated':
                        $icon = 'edit-3';
                        $color = 'indigo';
                        break;
                    case 'deleted':
                        $icon = 'trash-2';
                        $color = 'rose';
                        break;
                    case 'converted':
                        $icon = 'refresh-cw';
                        $color = 'amber';
                        break;
                    case 'completed':
                        $icon = 'check-circle';
                        $color = 'emerald';
                        break;
                }

                return (object)[
                    'id' => $log->id,
                    'user_name' => $log->user->name ?? 'System',
                    'action' => str_replace('_', ' ', $log->action),
                    'target' => $log->description,
                    'description' => $log->description,
                    'time' => $log->created_at->diffForHumans(),
                    'icon' => $icon,
                    'color' => $color,
                    'type' => ucfirst($log->action)
                ];
            });

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
