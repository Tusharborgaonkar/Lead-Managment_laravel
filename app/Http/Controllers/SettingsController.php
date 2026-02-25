<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = config('data');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully (Static Mock).');
    }
}

