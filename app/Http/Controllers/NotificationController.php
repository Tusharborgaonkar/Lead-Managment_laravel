<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index()
    {
        $notifications = collect([
            (object)['id' => 1, 'text' => 'New lead assigned: John Doe', 'is_read' => false, 'created_at' => now()->subMinutes(15)],
            (object)['id' => 2, 'text' => 'Deal won: Alpha Corp', 'is_read' => true, 'created_at' => now()->subHours(1)],
        ]);

        return view('notifications.index', compact('notifications'));
    }

    public function markRead($id)
    {
        return back()->with('success', 'Notification marked as read (Static Mock).');
    }

    public function markAllRead()
    {
        return back()->with('success', 'All notifications marked as read (Static Mock).');
    }

    public function destroy($id)
    {
        return back()->with('success', 'Notification deleted (Static Mock).');
    }
}

