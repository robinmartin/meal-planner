<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\CalendarEntry::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'date' => Carbon::parse('2 weeks ago')->format('Y-m-d'),
    ];
});
