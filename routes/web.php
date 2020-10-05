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

Route::get('/', 'UserController@index');
Route::get('/done', 'UserController@index');
Route::get('/export', 'HomeController@export_excel')->name('export');
Route::post('/add', 'UserController@save')->name('save');
Route::post('/kode', 'UserController@kode')->name('kode');
Route::post('/checkout', 'UserController@checkout')->name('checkout');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/add-user', 'AddUserController@index')->name('add-user');
Route::post('/submit-user', 'AddUserController@create')->name('submit-user');
Route::post('/search', 'HomeController@search')->name('search');
