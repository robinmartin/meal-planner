<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalendarEntryShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_calendar_entry_can_be_retrieved()
    {
        $calendarEntry = factory('App\CalendarEntry')->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user, 'api')
            ->json('GET','/api/calendar/' . $calendarEntry->date);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'date',
                'meals',
            ]
        ]);

        $response->assertJsonFragment([
            'id' => $calendarEntry->id,
            'date' => $calendarEntry->date->format('Y-m-d'),
        ]);

    }

    public function test_a_new_calendar_entry_will_be_created_and_returned_if_it_doesnt_exist_already()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('GET','/api/calendar/2017-01-01');

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'date',
                'meals',
            ]
        ]);
    }
}
