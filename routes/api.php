<?php

use Illuminate\Http\Request;

// Protected routes
Route::group(['middleware' => ['jwt.auth']], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('users', 'Auth\UsersController');
});

// Guest routes
Route::post('/register', [
    'uses' => 'Auth\UsersController@store',
]);

Route::post('/login', [
    'uses' => 'Auth\AuthenticateController@login',
]);