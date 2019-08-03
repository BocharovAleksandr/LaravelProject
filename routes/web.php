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

Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);
Route::get('/get_data', ['as' => 'home.get_data', 'uses' => 'HomeController@getData']);

//Route::post('/save_message', ['as' => 'home.save_message', 'uses' => 'HomeController@saveMessage']);
//Route::post('/delete_message', ['as' => 'home.delete_message', 'uses' => 'HomeController@deleteMessage']);

Route::get('/save_message', ['as' => 'home.save_message', 'uses' => 'HomeController@saveMessage']);
Route::get('/delete_message', ['as' => 'home.delete_message', 'uses' => 'HomeController@deleteMessage']);
