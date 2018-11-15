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

Route::get('/', function() {
    return view('nested-sets');
});

Route::post('/node/random/leaf', 'WelcomeController@randomLeaf');
Route::post('/node/random/node', 'WelcomeController@randomNode');
Route::post('/node/copy', 'WelcomeController@copyNode');
Route::post('/node/delete', 'WelcomeController@deleteNode');
Route::post('/node/append', 'WelcomeController@appendNode');
Route::get('/tree/fetch', 'WelcomeController@fetchTree');
Route::post('/tree/check', 'WelcomeController@checkTree');