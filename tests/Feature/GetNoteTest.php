<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Note;


class GetNoteTest extends TestCase
{
    use RefreshDatabase;

    public function testCannotFindNote()
    {
        $response = $this->getJson('/api/notes/999999');
        
        $response->assertStatus(404);
    }
    
    public function testCanGetAllNotes()
    {
        Note::factory()->count(4)->create();
        $response = $this->getJson('/api/notes');

        $response->assertStatus(200)
                 ->assertJsonCount(4);
    }

    public function testCanGetNoteById()
    {
        $note = Note::factory()->create();
        $response = $this->getJson("/api/notes/{$note->id}");

        $response->assertStatus(200);
    }
}