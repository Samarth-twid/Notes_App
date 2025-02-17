<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FactoryTest extends TestCase
{
    use RefreshDatabase;
    
    
    public function testCanFactoryCreateNote()
    {
        $note = Note::factory()->make();

        $this->assertInstanceOf(Note::class, $note);
    }

    public function testCanStoreMockDataInDatabase()
    {
        $note = Note::factory()->create();

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'title' => $note->title,
            'content' => $note->content,
        ]);
    }
}