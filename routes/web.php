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

Route::middleware(['auth'])->group(function () {

    Route::get('/', 'OrderController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/warehouse', 'HomeController@index')->name('warehouse');

    Route::get('/viewMail/{id}', 'OrderController@viewMail')->name('view_mail');
    Route::post('/sendMail/{id}', 'OrderController@sendMail');

    Route::get('/preview-mail/{type}/{id}', 'MailController@preview')->name('preview_mail');
    Route::post('/send-mail/{type}/{id}', 'MailController@send')->name('send_mail');

    Route::get('/sets', 'OrderController@sets');
    Route::get('/delivered', 'OrderController@delivered')->name('delivered');


    Route::get('/ajax/save_invoice', 'InvoiceController@save')->name('save_invoice');
    Route::delete('/ajax/delete/{type}', 'InvoiceController@delete')->name('save_invoice');
    Route::post('/ajax/save_order', 'OrderController@ajaxUpdate')->name('save_order');
    Route::post('/ajax/approve_maket', 'OrderController@approveMaket')->name('approve_maket');
    Route::post('/ajax/approve_maket_corrections', 'OrderController@approveMaketCorrections')
        ->name('approve_corrections');
    Route::post('/ajax/achtung', 'OrderController@achtung');

    Route::resource('order', 'OrderController');
    Route::resource('polygraphy-type', 'PolygraphyTypeController');
    Route::resource('manufacturer', 'ManufacturerController');

    Route::get('/warehouse', 'WarehouseController@index')->name('warehouse');
});