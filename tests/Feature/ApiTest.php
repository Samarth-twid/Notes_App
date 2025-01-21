<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase{
    use RefreshDatabase;

    public function testIsValidRoute()
    {
        $response = $this->getJson('/');

        $response->assertStatus(200);
    }

    public function testIsInvalidRoute()
    {
        $response = $this->getJson('/api/invalid-route');

        $response->assertStatus(404);
    }
}