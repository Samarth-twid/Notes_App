<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;
    
    public function testCanConnectToDatabase() 
    {
        $this->assertTrue(DB::connection()->getDatabaseName() !== null, 'Database connection failed.');
    }

    public function testIsNoteModelWorking()
    {
        $note = Note::create([
            'title' => 'Test Note',
            'content' => 'This is test content.',
        ]);

        $this->assertEquals('Test Note', $note->title);
        $this->assertEquals('This is test content.', $note->content);
    }

    public function testRetrievesNoteFromDatabase()
    {
        $note = Note::create([
            'title' => 'Note in DB',
            'content' => 'Get content from DB',
        ]);

        $retrievedNote = Note::find($note->id);
        $this->assertNotNull($retrievedNote);
        $this->assertEquals($note->title, $retrievedNote->title);
        $this->assertEquals($note->content, $retrievedNote->content);
    }
}
