<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_meal_can_be_added()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('POST','/api/meals/', [
                'name' => 'New meal'
            ]);

        $response->assertStatus(201);
    }

    public function test_must_have_a_name()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('POST','/api/meals/', []);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'name'
            ]
        ]);
    }
}
