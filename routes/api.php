<?php

use Illuminate\Http\Request;
use App\Models\User;

function rest($path, $controller) {
    Route::get($path, $controller.'@index');
    Route::post($path, $controller.'@store');
    Route::get($path.'/{id}', $controller.'@show');
    Route::put($path.'/{id}', $controller.'@update');
    Route::delete($path.'/{id}', $controller.'@destroy');
}

Route::group(['middleware' => ['jwt.auth']], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    rest('users', 'Auth\UsersController');

});

Route::post('/register', [
    'uses' => 'Auth\UsersController@store',
]);

Route::post('/login', [
    'uses' => 'Auth\AuthenticateController@login',
]);