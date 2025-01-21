<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Note;
use Illuminate\Support\Facades\Redis;

class DeleteNoteTest extends TestCase
{
    use RefreshDatabase;

    public function testCannotFindNoteToDelete()
    {
        $response = $this->deleteJson('/api/notes/999999');

        $response->assertStatus(404);
    }

    public function testCanDeleteNoteById()
    {
        $note = Note::factory()->create();

        $response = $this->deleteJson("/api/notes/{$note->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('notes', [
            'id' => $note->id,
        ]);
        $this->assertEquals(0,Redis::exists('note_' . $note->id));
        $this->assertEquals(0,Redis::exists('notes_list'));
    }
}