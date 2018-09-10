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
    return view('auth.login');
})->middleware('guest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('home/initial', 'HomeController@initialBalance')->name('initial')->middleware('auth');
Route::resource('history', 'HistoryController')->middleware('auth');

Route::get('atm', 'AtmController@index')->middleware('auth')->name('atm');
Route::post('atm.store', 'AtmController@store')->middleware('auth')->name('atm.store');
Route::post('atm', 'AtmController@initialAtm')->middleware('auth')->name('atm.initial');
Route::delete('atm/{id}', 'AtmController@destroy')->middleware('auth')->name('atm.destroy');