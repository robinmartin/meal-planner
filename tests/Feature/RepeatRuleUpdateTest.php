<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepeatRuleUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->repeatRule = factory('App\RepeatRule')->create();
    }

    public function test_end_date_can_be_updated()
    {

        $response = $this->actingAs($this->user, 'api')
            ->json('PATCH','/api/rules/' . $this->repeatRule->id, [
                'end_date' => Carbon::today()->format('Y-m-d')
            ]);

        $response->assertStatus(204);
    }

    public function test_must_have_a_valid_end_date()
    {
        $response = $this->actingAs($this->user, 'api')
            ->json('PATCH','/api/rules/' . $this->repeatRule->id, [
                'end_date' => 'invalid'
            ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'errors' => [
                'end_date'
            ]
        ]);
    }

}
