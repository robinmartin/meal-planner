<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_meals_can_be_retrieved()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('GET','/api/meals');

        $response->assertStatus(200);

        $response->assertJsonStructure([
//            'data' => [
                '*' => ['id', 'name', 'meals', 'date']
//            ]
        ]);
    }
}
