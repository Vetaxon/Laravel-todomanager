<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', 'API\UserController@register');
Route::post('/login', 'API\UserController@login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tasks', 'API\TaskController@index')->middleware('auth:api');
Route::get('/tasks/{id}', 'API\TaskController@show')->middleware(['auth:api', 'checkExistsTask'])->where('id', '[0-9]+');
Route::post('/tasks', 'API\TaskController@store')->middleware('auth:api');
Route::delete('/tasks/{id}', 'API\TaskController@destroy')->middleware('auth:api')->where('id', '[0-9]+');
Route::put('/tasks/{id}', 'API\TaskController@update')->middleware('auth:api')->where('id', '[0-9]+');