<?php

namespace App\Http\Controllers;

use App\Http\Requests\MealStoreRequest;
use App\Http\Resources\MealResource;
use App\Meal;

class MealApiController extends Controller
{
    public function index()
    {
        $meals = Meal::search(request()->input('search',''), function ($algolia, $query, $options) {
            if(request()->has('excluded_meals')){
                $exclusionString = collect(request()->input('excluded_meals'))->map(function($exclusion){
                    return "NOT id = " . $exclusion;
                })->implode(" AND ");
                $filterString = "(" . $exclusionString . " ) AND user_id = " . auth()->user()->id;
            }else{
                $filterString = "user_id = " . auth()->user()->id;
            }
            $options['filters'] = $filterString;
            return $algolia->search($query, $options);
        })
            ->get();

        return $meals;
    }


    public function store(MealStoreRequest $request)
    {
        $meal = Meal::create([
            'name' => $request->input('name'),
            'user_id' => auth()->user()->id
        ]);

        return new MealResource($meal);

    }
}
