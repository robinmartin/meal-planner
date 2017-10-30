<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalendarEntryMealDestroyTest extends TestCase
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

        $this->calendarEntry->meals()->attach($this->meal);

    }

    public function test_a_meal_calendar_entry_can_be_deleted()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('DELETE','/api/calendar/' . $this->calendarEntry->date . '/meals/' . $this->meal->id);

        $response->assertStatus(204);
    }

    public function test_must_have_rule_id_if_future_calendar_entries_are_to_be_deleted()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('DELETE','/api/calendar/' . $this->calendarEntry->date . '/meals/' . $this->meal->id, [
                'delete_future_meals' => true,
            ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'rule_id'
            ]
        ]);
    }

}
