<?php

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    Route::get('/', 'Web\HomeController@index')->name('home');
});
