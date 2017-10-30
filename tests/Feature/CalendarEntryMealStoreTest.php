<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalendarEntryMealStoreTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->calendarEntry = factory('App\CalendarEntry')->create([
            'user_id' => $this->user->id
        ]);

        $this->meal = factory('App\Meal')->create([
            'user_id' => $this->user->id
        ]);

    }

    public function test_a_meal_can_be_added_to_a_date_on_the_calendar()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('POST','/api/calendar/' . $this->calendarEntry->date . '/meals/', [
                'meal_id' => $this->meal->id
            ]);

        $response->assertStatus(201);
    }

    public function test_must_have_a_meal_id()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('POST','/api/calendar/' . $this->calendarEntry->date . '/meals/', []);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'meal_id'
            ]
        ]);
    }

    public function test_must_have_a_meal_id_that_exists()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('POST','/api/calendar/' . $this->calendarEntry->date . '/meals/', [
                'meal_id' => '99999999999999999999999999999'
            ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'meal_id'
            ]
        ]);
    }

}
