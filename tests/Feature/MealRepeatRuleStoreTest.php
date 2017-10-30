<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MealRepeatRuleStoreTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->meal = factory('App\Meal')->create([
            'user_id' => $this->user->id
        ]);
    }

    public function test_a_repeat_rule_can_be_added_to_a_meal()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('POST','/api/meals/' . $this->meal->id . '/rules', [
                'repeat_frequency' => 7,
                'start_date' => Carbon::today()->format('Y-m-d')
            ]);

        $response->assertStatus(201);
    }

    public function test_must_have_a_start_date()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('POST','/api/meals/' . $this->meal->id . '/rules', [
                'repeat_frequency' => 7,
            ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'start_date'
            ]
        ]);
    }

    public function test_must_have_a_valid_start_date()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('POST','/api/meals/' . $this->meal->id . '/rules', [
                'repeat_frequency' => 7,
                'start_date' => 'invalid'
            ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'start_date'
            ]
        ]);
    }

    public function test_must_have_a_repeat_frequency()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('POST','/api/meals/' . $this->meal->id . '/rules', [
                'start_date' => Carbon::today()->format('Y-m-d')
            ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'repeat_frequency'
            ]
        ]);
    }
}
