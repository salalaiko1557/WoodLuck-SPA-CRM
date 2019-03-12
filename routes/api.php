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
Route::namespace('Api')->group(function () {
    //слой связки api
    //Заказы
    Route::get('/orders',            'OrderController@all');
    Route::get('/orders/{order}',    'OrderController@show');
    Route::put('/orders/{order}',    'OrderController@update');
    Route::post('/orders/updateAll',  'OrderController@updateAll');
    Route::delete('/orders/{order}', 'OrderController@destroy');
    Route::post('/orders/create',    'OrderController@create');
    ////
});
