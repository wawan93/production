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


Auth::routes();

Route::get('/', 'OrderController@index')->middleware('auth');
Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');

Route::get('/viewMail/{id}', 'OrderController@viewMail')->middleware('auth');
Route::post('/sendMail/{id}', 'OrderController@sendMail')->middleware('auth');

Route::get('/invoice/save', 'InvoiceController@save')->middleware('auth');

Route::resource('order', 'OrderController');
Route::resource('polygraphy-type', 'PolygraphyTypeController');
Route::resource('manufacturer', 'ManufacturerController');