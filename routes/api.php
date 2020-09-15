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
Route::group(['prefix'=>'v1'],function () {
    Route::post('translate', 'MainController@translate');
    Route::get('get-list', 'MainController@getList');
    Route::middleware('throttle:100,1')->group(function () {
        Route::post('create/translate', 'MainController@createTranslate');
    });
});