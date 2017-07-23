<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => 'api/v1'], function() {
	Route::any('/oauth/{name}/access_token', ['uses' => '\Api\Http\Controllers\Auth\SignInController@accessToken']);
	Route::any('/oauth/{name}/exchange_token', ['uses' => '\Api\Http\Controllers\Auth\SignInController@exchangeToken']);

	Route::group(['middleware' => 'auth:api'], function() {
		Route::any('/user', ['uses' => '\Api\Http\Controllers\User\UserController@index']);

		Route::group(['prefix' => '/user/teams'], function () {
            Route::get('/', ['uses' => '\Api\Http\Controllers\User\TeamsController@index']);
            Route::post('/', ['uses' => '\Api\Http\Controllers\User\TeamsController@create']);
            Route::get('/{id}', ['uses' => '\Api\Http\Controllers\User\TeamsController@show']);
            Route::put('/{id}', ['uses' => '\Api\Http\Controllers\User\TeamsController@update']);
            Route::delete('/{ids}', ['uses' => '\Api\Http\Controllers\User\TeamsController@delete']);
        });

	});
});

Route::any('/{all}', function () {
    return view('app');
})->where(['all' => '.*']);