<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;
 
    public function testDatabaseConnection() 
    {
        $this->assertTrue(DB::connection()->getDatabaseName() !== null, 'Database connection failed.');
    }

    public function testNoteModel()
    {
        $note = Note::create([
            'title' => 'Test Note',
            'content' => 'This is test content.',
        ]);

        $this->assertEquals('Test Note', $note->title);
        $this->assertEquals('This is test content.', $note->content);
    }

    public function testNoteRetreivedFromDatabase()
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

    public function testFactoryCreation()
    {
        $note = Note::factory()->make();

        $this->assertInstanceOf(Note::class, $note);
    }

    public function testMockDataInDatabase()
    {
        $note = Note::factory()->create();

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => $note->title,
            'content' => $note->content,
        ]);
    }
}
