<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Note;

class NoteController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'note' => 'required|string',
        ]);

        $lead->notes()->create($validated);

        return back()->with('success', 'Note added successfully.');
    }

    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'note' => 'required|string',
        ]);

        $note->update($validated);

        return back()->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return back()->with('success', 'Note deleted successfully.');
    }
}
