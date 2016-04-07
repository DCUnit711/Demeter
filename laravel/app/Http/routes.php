<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->middleware(['Authenticate']);

Route::resource('users', 'demeterUserController');
Route::resource('vms', 'vmController');
Route::resource('instances', 'instanceController');
Route::resource('instanceUsers', 'instanceUserController');
Route::get('checkLogin', 'checkLogin@index');
Route::post('backup', 'instanceController@backup');
Route::post('addUser', 'instanceController@addUser');
