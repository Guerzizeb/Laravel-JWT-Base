<?php

use Illuminate\Http\Request;

// Authentication route
Route::post('/v1/login', [
    'uses' => 'Auth\AuthenticationController@login',
]);

// Guest routes
Route::post('/v1/register', [
    'uses' => 'UsersController@store',
]);

// Protected routes
Route::group(['prefix' => 'v1', 'middleware' => 'jwt.auth'], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/logout', 'Auth\AuthenticationController@logout');

    Route::resource('users', 'UsersController', ['except' => 'store']);
    Route::get('dashboard', 'DashboardController@index');

    Route::group(['middleware' => ['role:admin']], function() {
        Route::put('/users/{id}', 'UsersController@store');
    });

});

Route::group(['prefix' => 'v1', 'middleware' => ['jwt.auth', 'jwt.refresh']], function () {
    Route::get('refresh-token', function (Request $request) {
        return $token = JWTAuth::getToken();
    });
});

