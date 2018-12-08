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

use App\Record;
use App\Category;

Auth::routes();

Route::get('/', 'RecordController@index');
Route::get('record/search', 'RecordController@search')->name('search');
Route::get('/home', 'RecordController@index')->name('home');


// record route
Route::resource('record', 'RecordController');
Route::resource('user', 'UserController',
    ['only' => ['index', 'show']]);

// user route
//Route::controller('user','UserController');
