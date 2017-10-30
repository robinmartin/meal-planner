<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['auth:api']], function(){

    //**Retrieve all calendar entries for a date range
    Route::get('/calendar', 'CalendarEntryApiController@index');

    //**Retrieve the calendar entry for a specific date ('YYYY-MM-DD')
    Route::get('/calendar/{calendarEntry}', 'CalendarEntryApiController@show');

    //**Retrieve all meals
    Route::get('/meals', 'MealApiController@index');


    //**Add meals to a specific date
    Route::post('/calendar/{calendarEntry}/meals', 'CalendarEntryMealApiController@store');

    //**Create a new meal
    Route::post('/meals', 'MealApiController@store');

    //**Create a rule for a meal
    Route::post('/meals/{meal}/rules', 'MealRepeatRuleApiController@store');


    //**Update a specific rule
    Route::patch('/rules/{repeatRule}', 'RepeatRuleApiController@update');


    //**Remove a meal from a specific date
    Route::delete('/calendar/{calendarEntry}/meals/{meal}', 'CalendarEntryMealApiController@destroy');



});

