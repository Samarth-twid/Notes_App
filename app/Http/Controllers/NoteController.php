<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function createNote(Request $request)
    {
        $note = Note::create();
        return response()->json($note, 201);
    }
}