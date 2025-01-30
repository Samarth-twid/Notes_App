<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:127',
            'content' => 'required|string|max:1023',
        ];
    }

    public function createNote(Request $request)
    {
        $validatedNote = $request->validate($this->rules());

        DB::table('notes')->insert([
            'title' => $validatedNote['title'],
            'content' => $validatedNote['content'],
        ]);

        Redis::del('notes_list');
    
        return response()->json($validatedNote, 201);
    }

    public function getAllNotes()
    {
        $cacheKey = 'notes_list';

        if (Redis::exists($cacheKey)) {
            $notes = json_decode(Redis::get($cacheKey), true);
        } else {
            $notes = DB::table('notes')
            ->select('id','title', 'content')
            ->get();
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
            $note = DB::table('notes')
            ->select('id','title', 'content')
            ->where('id', $id)
            ->get('id');
            Redis::set($cacheKey, json_encode($note), 'EX', 3600);
        }
        
        return response()->json($note);
    }

    public function updateNoteById(Request $request, $id)
    {
        $cacheKey = 'note_' . $id;

        $validatedData = $request->validate($this->rules());
        DB::table('notes')
              ->where('id', $id)
              ->update(array_merge($validatedData, [
                'title' => $validatedData['title'],
                'content' => $validatedData['content']
        ]));
        $note = DB::table('notes')->get()->where('id', $id);
        Redis::del('notes_list');
        Redis::set($cacheKey, json_encode($note), 'EX', 3600);

        return response()->json($note,201);
    }

    public function deleteNoteById($id)
    {
        DB::table('notes')->where('id', $id)->delete();

        Redis::del('notes_list');
        Redis::del('note_'. $id);

        return response()->json(null, 204);
    }
}