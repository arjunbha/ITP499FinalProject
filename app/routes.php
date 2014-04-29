<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/stocktool', 'StockController@showCalendar');
Route::get('/stocktool/{date}', 'StockController@showGainers');
Route::get('/login', 'StockController@login');
Route::post('/loginProcess', 'StockController@loginProcess');
Route::get('/stocks', 'StockController@showStocks');
Route::get('/stockProcess', 'StockController@stockProcess');
Route::get('/logout', 'StockController@logout');
Route::get('/admin', 'StockController@admin');
Route::post('/adminProcess','StockController@adminProcess');

