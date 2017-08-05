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

Route::get('/', 'OrderController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/sendMail/{id}', 'OrderController@sendMail');

Route::resource('order', 'OrderController');
Route::resource('polygraphy-type', 'PolygraphyTypeController');
Route::resource('manufacturer', 'ManufacturerController');