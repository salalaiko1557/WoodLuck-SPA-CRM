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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//Выключаем регистрацию
Route::match(['post', 'get'], 'register', function(){
    return redirect('/login');
})->name('register');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{any}', 'PagesController@index')->where('any', '.*');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
