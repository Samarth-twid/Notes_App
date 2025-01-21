<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Note;

class UpdateNoteTest extends TestCase
{
    use RefreshDatabase;

    public function testCannotFindNoteToUpdate()
    {
        $response = $this->putJson('/api/notes/999999', [
            'title' => 'Non-existent Note',
            'content' => 'Trying to update a note that does not exist.',
        ]);

        $response->assertStatus(404);
    }

    public function testCanUpdateNoteById()
    {
        $note = Note::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ];

        $response = $this->putJson("/api/notes/{$note->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('notes', $updatedData);
    }

    public function testRestrictsUpdateNoteWithLongInput()
    {
        $note = Note::factory()->create();
        
        $longTitle = str_repeat('a', 128); 
        $longContent = str_repeat('b', 1024);

        $response = $this->putJson("/api/notes/{$note->id}", [
            'title' => $longTitle,
            'content' => $longContent,
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title', 'content']);
    }

    public function testRestrictUpdateNoteWithEmptyData()
    {
        $note = Note::factory()->create();
        
        $response = $this->putJson("/api/notes/{$note->id}", [
            'title' => '',
            'content' => '',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['title', 'content']);
    }
}