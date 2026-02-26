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
            $activity->user_name = $activity->user->name ?? 'System';
            $activity->time = $activity->created_at->diffForHumans();
            $activity->type = ucfirst($activity->action);
            $activity->target = class_basename($activity->entity_type) . ' #' . $activity->entity_id;

            return $activity;
        });

        return view('activity.index', compact('activities'));
    }

    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete();

        return redirect()->route('activity.index')->with('success', 'Activity log deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $log = ActivityLog::findOrFail($id);

        $log->update([
            'action' => $request->action ?? $log->action,
            'description' => $request->description ?? $log->description,
        ]);

        return redirect()->route('activity.index')->with('success', 'Activity log updated successfully.');
    }
}
