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
Route::post('createbotclasses', 'SubjectsController@createbotclass');

Route::get('/lesson_dump', 'ApplicationController@lesson_dump');

//Route::get('/learning_path', 'ApplicationController')->where('any', '.*');

Route::get('/{any}', 'ApplicationController')->where('any', '.*');

