<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['jwt.auth']], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/test', function (Request $request) {
        return 'Get ok';
    });

    Route::post('/test', function (Request $request) {
        return 'Post ok';
    });

    Route::get('/users', function () {
        return response(['users' => App\User::all(), 'message' => 'success']);
    });

});

Route::post('/register', [
    'uses' => 'Auth\AuthenticateController@register',
]);

Route::post('/login', [
    'uses' => 'Auth\AuthenticateController@login',
]);