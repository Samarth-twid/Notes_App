<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function createNote(Request $request)
    {
        $validatedNote = $request->validate(Note::rules());
        $note = Note::create($validatedNote);

        Redis::del('notes_list');
    
        return response()->json($note, 201);
    }

    public function getAllNotes()
    {
        $cacheKey = 'notes_list';

        if (Redis::exists($cacheKey)) {
            $notes = json_decode(Redis::get($cacheKey), true);
        } else {
            $notes = Note::all();
            Redis::set($cacheKey, json_encode($notes), 'EX', 3600);
        }
        
        return response()->json($notes);
    }

    public function getNoteById($id)
    {
        $cacheKey = 'note_' . $id;
        
        if (Redis::exists($cacheKey)) {
            $note = json_decode(Redis::get($cacheKey), true);
        } else {
            $note = Note::findOrFail($id);
            Redis::set($cacheKey, json_encode($note), 'EX', 3600);
        }
        
        return response()->json($note);
    }

    public function updateNoteById(Request $request, $id)
    {
        $cacheKey = 'note_' . $id;

        $note = Note::findOrFail($id);
        $validatedData = $request->validate(Note::rules());
        $note->update($validatedData);

        Redis::del('notes_list');
        Redis::set($cacheKey, json_encode($note), 'EX', 3600);

        return response()->json($note);
    }

    public function deleteNoteById($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        Redis::del('notes_list');
        Redis::del('note_'. $note->id);

        return response()->json(null, 204);
    }
}