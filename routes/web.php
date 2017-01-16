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

Route::get('/home', 'HomeController@index');
Route::get('/upload-race', 'HomeController@uploadRace');
Route::post('/upload-race/complete', 'HomeController@storeRace')->name('upload-race-complete');
Route::get('/upload-athlete', 'HomeController@uploadAthlete');
Route::post('/upload-athlete/complete', 'HomeController@storeAthlete')->name('upload-athlete-complete');
