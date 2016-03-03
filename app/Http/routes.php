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
Route::get('construct/bitrix', 'Modules\Bitrix\BitrixController@index'); // показ страницы создания
Route::post('construct/bitrix/create', 'Modules\Bitrix\BitrixController@store'); // сабмит формы создания // создание модуля
Route::get('my-modules/bitrix/{module}',  ['as' => 'bitrix_module_detail', 'uses' => 'Modules\Bitrix\BitrixController@detail']); // детальная страница модуля
Route::post('my-modules/bitrix/{id}/edit_param', 'Modules\Bitrix\BitrixController@edit_param'); // детальная страница модуля
Route::get('my-modules/bitrix/{module}/delete', 'Modules\Bitrix\BitrixController@destroy'); // удалить модуль
Route::get('my-modules/bitrix/{id}/download', 'Modules\Bitrix\BitrixController@download_zip'); // скачать архив
// настройки
Route::get('my-modules/bitrix/{module}/admin_options', ['as' => 'bitrix_module_admin_options', 'uses' => 'Modules\Bitrix\BitrixOptionsController@show']);
Route::post('my-modules/bitrix/{id}/admin_options_save', 'Modules\Bitrix\BitrixOptionsController@store');
Route::get('my-modules/bitrix/{module_id}/admin_option_delete/{option_id}', 'Modules\Bitrix\BitrixOptionsController@destroy');
// .настройки
// обработчики событий
Route::get('my-modules/bitrix/{id}/events_handlers', ['as' => 'bitrix_module_events_handlers', 'uses' => 'Modules\Bitrix\BitrixEventHandlersController@show']);
Route::post('my-modules/bitrix/{id}/events_handlers_save', 'Modules\Bitrix\BitrixEventHandlersController@store');
Route::get('my-modules/bitrix/{module_id}/events_handler_delete/{option_id}', 'Modules\Bitrix\BitrixEventHandlersController@destroy');
// .обработчики событий
// компоненты
Route::get('my-modules/bitrix/{id}/components', ['as' => 'bitrix_module_components', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show']);
Route::get('my-modules/bitrix/{id}/new_components', ['as' => 'bitrix_new_component', 'uses' => 'Modules\Bitrix\BitrixComponentsController@create']);
Route::post('my-modules/bitrix/{id}/component_create','Modules\Bitrix\BitrixComponentsController@store');
Route::post('my-modules/bitrix/{module}/upload_component_zip', ['as' => 'upload_component_zip', 'uses' => 'Modules\Bitrix\BitrixComponentsController@upload_zip']);
// .компоненты
// .Битрикс