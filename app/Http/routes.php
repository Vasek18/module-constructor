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

// Страница авторизации регистрации
Route::get('/personal/auth', 'Auth\AuthController@index');
Route::get('/personal/reg', 'Auth\AuthController@index_reg');

// Логин
Route::get('personal/login', 'Auth\AuthController@getLogin');
Route::post('personal/login', 'Auth\AuthController@postLogin');

// Регистрация
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// выход
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Роуты запроса ссылки для сброса пароля
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Роуты сброса пароля
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');