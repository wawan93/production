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

Route::get('/ajax/save_invoice', 'InvoiceController@save')->middleware('auth');
Route::delete('/ajax/delete/{type}', 'InvoiceController@delete')->middleware('auth');
Route::post('/ajax/save_order', 'OrderController@ajaxUpdate')->middleware('auth');
Route::post('/ajax/approve_maket', 'OrderController@approveMaket')->middleware('auth');

Route::resource('order', 'OrderController');
Route::resource('polygraphy-type', 'PolygraphyTypeController');
Route::resource('manufacturer', 'ManufacturerController');