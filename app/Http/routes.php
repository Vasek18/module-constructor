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

Route::get('/', "HomeController@index");

Route::get('/personal/auth', 'Auth\AuthController@index');
Route::get('/personal/reg', 'Auth\AuthController@index_reg');


Route::post('personal/login', 'Auth\AuthController@postLogin');

Route::get('example/login', 'Auth\AuthController@getLogin');
Route::get('example/email', 'Auth\PasswordController@getEmail');
Route::post('example/email', 'Auth\PasswordController@postEmail');
Route::get('example/reset/{code}', 'Auth\PasswordController@getReset');
Route::post('example/reset', 'Auth\PasswordController@postReset');

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::post('auth/logout', 'Auth\AuthController@getLogout');