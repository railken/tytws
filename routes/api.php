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

Route::group(['prefix' => 'v1'], function() {
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

        
        Route::group(['prefix' => '/user/activities'], function () {
            Route::get('/', ['uses' => '\Api\Http\Controllers\User\ActivitiesController@index']);
            Route::post('/', ['uses' => '\Api\Http\Controllers\User\ActivitiesController@create']);
            Route::get('/{id}', ['uses' => '\Api\Http\Controllers\User\ActivitiesController@show']);
            Route::put('/{id}', ['uses' => '\Api\Http\Controllers\User\ActivitiesController@update']);
            Route::delete('/{ids}', ['uses' => '\Api\Http\Controllers\User\ActivitiesController@delete']);
        });

        Route::get('/user/reports/activities', ['uses' => '\Api\Http\Controllers\User\ReportsController@activities']);
    });
});
