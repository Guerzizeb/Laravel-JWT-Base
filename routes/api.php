<?php

use Illuminate\Http\Request;

// Authentication route
Route::post('/login', [
    'uses' => 'Auth\AuthenticateController@login',
]);

// Guest routes
Route::post('/register', [
    'uses' => 'UsersController@store',
]);

// Protected routes
Route::group(['middleware' => ['jwt.auth']], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('users', 'UsersController');
});

