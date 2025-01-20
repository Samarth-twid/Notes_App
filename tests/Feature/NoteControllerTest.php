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
        $noteData = [
            'title' => 'Test Note',
            'content' => 'This is a test note.',
        ];
        $response = $this->postJson('/api/notes', $noteData);
        $response->assertStatus(201)
            ->assertJsonFragment($noteData);

        $this->assertDatabaseHas('notes', $noteData);
    }

    public function testCreateNoteWithoutData()
    {
        $invalidData = [
            'title' => '',
            'content' => '',
        ];

        $response = $this->postJson('/api/notes', $invalidData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'content']);
    }

    public function testCreateNoteWithLongInput()
    {
        $longTitle = str_repeat('a', 128);
        $longContent = str_repeat('b', 1024);

        $response = $this->postJson('/api/notes', [
            'title' => $longTitle,
            'content' => $longContent,
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title', 'content']);
    }

    public function testGetAllNotes()
    {
        Note::factory()->count(4)->create();
        $response = $this->getJson('/api/notes');

        $response->assertStatus(200)
                 ->assertJsonCount(4);
    }
    public function testGetNoteNotFound()
    {
        $response = $this->getJson('/api/notes/999999');
        
        $response->assertStatus(404);
    }

    public function testGetNoteById()
    {
        $note = Note::factory()->create();
        $response = $this->getJson("/api/notes/{$note->id}");

        $response->assertStatus(200);
    }
}
