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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Api\PluginController@login');

Route::group(['middleware' => ['auth.api']], function () {

    Route::post('/changeState', 'Api\PluginController@changeState');

    Route::post('/addLog', 'Api\PluginController@addLog')->middleware('auth.game');

    Route::get('/getLog', 'Api\PluginController@getLog');

    Route::get('/getAccountInfo', 'Api\PluginController@getAccountInfo');

    Route::post('/initEquipment', 'Api\PluginController@initEquipment')->middleware('auth.game');
});
