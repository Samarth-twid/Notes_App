<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function createNote(Request $request)
    {
        $validatedNote = $request->validate(Note::rules());      
	    $note = Note::create($validatedNote);
        
        return response()->json($note, 201);
    }

    public function getAllNotes(Request $request)
    {
        $notes = Note::get();

        return response()->json($notes, 200);
    }

    public function getNoteById($id)
    {
        $note = Note::findOrFail($id);

        return response()->json($note, 200);
    }

    public function updateNoteById(Request $request, $id)
    {
        $note = Note::findOrFail($id);
        $validatedData = $request->validate(Note::rules());
        $note->update($validatedData);

        return response()->json($note);
    }
}
