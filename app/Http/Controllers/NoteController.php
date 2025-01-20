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
}
