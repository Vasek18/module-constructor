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
Route::get('/personal/auth', ['as' => 'auth', 'uses' => 'Auth\AuthController@index']);
Route::get('/personal/reg', ['as' => 'reg', 'uses' => 'Auth\AuthController@index_reg']);

// Логин
Route::get('personal/login', 'Auth\AuthController@getLogin');
Route::post('personal/login', 'Auth\AuthController@postLogin');

// Регистрация
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// выход
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

// Роуты запроса ссылки для сброса пароля
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Роуты сброса пароля
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Личный кабинет
Route::get('/personal', ['as' => 'personal', 'uses' => 'PersonalController@index']);


// Битрикс
Route::get('construct/bitrix', 'Modules\BitrixController@index'); // показ страницы создания
Route::post('construct/bitrix/create', 'Modules\BitrixController@create'); // сабмит формы создания // создание модуля
Route::get('my-modules/bitrix/{id}', 'Modules\BitrixController@detail'); // детальная страница модуля
Route::get('my-modules/bitrix/{id}/delete', 'Modules\BitrixController@delete'); // детальная страница модуля
Route::get('my-modules/bitrix/{id}/download', 'Modules\BitrixController@download_zip'); // скачать архив
Route::get('my-modules/bitrix/{id}/admin_options', 'Modules\BitrixController@admin_options'); // поля для страницы настроек
Route::post('my-modules/bitrix/{id}/admin_options_save', 'Modules\BitrixController@admin_options_save'); // сохранение полей для страницы настроек
Route::get('my-modules/bitrix/{module_id}/admin_option_delete/{option_id}', 'Modules\BitrixController@admin_option_delete'); // удаление поля для страницы настроек
Route::get('my-modules/bitrix/{id}/events_handlers', 'Modules\BitrixController@events_handlers'); // привязка к событиясм
