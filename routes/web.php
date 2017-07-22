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

});

Route::any('/{all}', function () {
    return view('app');
})->where(['all' => '.*']);