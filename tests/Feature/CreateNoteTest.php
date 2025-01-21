<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;

class CreateNoteTest extends TestCase
{
    use RefreshDatabase;

    public function testCanCreateNote()
    {
        $noteData = [
            'title' => 'Test Note',
            'content' => 'This is a test note.',
        ];
        $response = $this->postJson('/api/notes', $noteData);
        $response->assertStatus(201)
            ->assertJsonFragment($noteData);

        $this->assertDatabaseHas('notes', $noteData);
        $this->assertEquals(0,Redis::exists('notes_list'));
    }

    public function testRestrictsCreateNoteWithoutData()
    {
        $invalidData = [
            'title' => '',
            'content' => '',
        ];

        $response = $this->postJson('/api/notes', $invalidData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'content']);
    }

    public function testRestrictsCreateNoteWithLongInput()
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
}