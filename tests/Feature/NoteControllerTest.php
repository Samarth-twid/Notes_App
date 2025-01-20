<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Note;

class NoteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNote()
    {
        $note = Note::create([
            'title' => 'Test Note',
            'content' => 'This is a test note.',
        ]);

        $this->assertDatabaseHas('notes', ['title' => 'Test Note']);
        $this->assertDatabaseHas('notes', ['content' => 'This is a test note.']);
    }
}
