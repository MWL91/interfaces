<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoordinatesTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testItShouldFindCoordinates(): void
    {
        $response = $this->get('/api/coordinates?address=Berlin');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'lat',
            'lng',
        ]);
    }
}
