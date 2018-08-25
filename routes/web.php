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

use Illuminate\Support\Facades\Route;

//Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('horizon.index');
//Route::get('/mail', 'API\MailingController@daily');
//Auth::routes();


 Route::get('/{any}', function (){
     return view('welcome');
 })->where('any', '.*');


