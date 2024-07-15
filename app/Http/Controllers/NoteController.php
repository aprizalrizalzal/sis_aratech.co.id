<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'note' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Note::create([
            'note' => $request->note,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:notes,id',
            'note' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $note = Note::findOrFail($request->id);

        $note->update([
            'note' => $request->note,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:notes,id',
        ]);

        $note = Note::findOrFail($request->id);
        $note->delete();

        return Redirect::back();
    }
}
