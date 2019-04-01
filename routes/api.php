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
    Route::post('/orders/updateAll', 'OrderController@updateAll');
    Route::delete('/orders/{order}', 'OrderController@destroy');
    Route::post('/orders/create',    'OrderController@create');
    ////
    //Клиенты
    Route::get('/customers',               'CustomerController@all');
    Route::get('/customers/{customer}',    'CustomerController@show');
    Route::put('/customers/{customer}',    'CustomerController@update');
    Route::post('/customers/updateAll',    'CustomerController@updateAll');
    Route::delete('/customers/{customer}', 'CustomerController@destroy');
    Route::post('/customers/create',       'CustomerController@create');
    ////
    //Таргеты
    Route::get('/sources', 'SourceController@all');
    ////
    //Способы оплаты
    Route::get('/paystype', 'PayTypeController@all');
    ////
    //Меры измерения
    Route::get('/mires', 'MiresController@all');
    ////
    //Склад
    Route::get('/stock',            'StockController@all');
    Route::get('/stock/{stock}',    'StockController@show');
    Route::put('/stock/{stock}',    'StockController@update');
    Route::post('/stock/updateAll', 'StockController@updateAll');
    Route::delete('/stock/{stock}', 'StockController@destroy');
    Route::post('/stock/create',    'StockController@create');
    Route::post('/stock/check',      'StockController@check');
    ////
    //Пользователи
    Route::get('/users',           'UserController@all');
    Route::get('/users/{user}',    'UserController@show');
    Route::put('/users/{user}',    'UserController@update');
    Route::delete('/users/{user}', 'UserController@destroy');
    Route::post('/users/create',   'UserController@create');
    ////
});
