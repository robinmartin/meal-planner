<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalendarEntryIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_calendar_entries_can_be_retrieved()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('GET','/api/calendar');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'meals', 'date']
            ]
        ]);
    }
}
