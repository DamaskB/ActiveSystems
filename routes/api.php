<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/items/edit', 'GeneralController@edit');
Route::get('/items/load', 'GeneralController@getItem');
Route::get('/items/delete', 'GeneralController@delete');
Route::get('/items/add', 'GeneralController@addNew');
Route::get('/items', 'GeneralController@getList');
Route::get('/cats', 'GeneralController@getCats');