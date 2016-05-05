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
Route::get('my-modules/bitrix/{module}', ['as' => 'bitrix_module_detail', 'uses' => 'Modules\Bitrix\BitrixController@detail']); // детальная страница модуля
Route::post('my-modules/bitrix/{id}/edit_param', 'Modules\Bitrix\BitrixController@edit_param'); // детальная страница модуля
Route::get('my-modules/bitrix/{module}/delete', 'Modules\Bitrix\BitrixController@destroy'); // удалить модуль
Route::post('my-modules/bitrix/{module}/download', 'Modules\Bitrix\BitrixController@download_zip'); // скачать архив
// настройки
Route::get('my-modules/bitrix/{module}/admin_options', ['as' => 'bitrix_module_admin_options', 'uses' => 'Modules\Bitrix\BitrixOptionsController@show']);
Route::post('my-modules/bitrix/{id}/admin_options_save', 'Modules\Bitrix\BitrixOptionsController@store');
Route::get('my-modules/bitrix/{module_id}/admin_option_delete/{option_id}', 'Modules\Bitrix\BitrixOptionsController@destroy');
// .настройки
// обработчики событий
Route::get('my-modules/bitrix/{id}/events_handlers', ['as' => 'bitrix_module_events_handlers', 'uses' => 'Modules\Bitrix\BitrixEventHandlersController@show']);
Route::post('my-modules/bitrix/{module}/events_handlers_save', 'Modules\Bitrix\BitrixEventHandlersController@store');
Route::get('my-modules/bitrix/{module_id}/events_handler_delete/{option_id}', 'Modules\Bitrix\BitrixEventHandlersController@destroy');
// .обработчики событий
// компоненты
Route::get('my-modules/bitrix/{id}/components', ['as' => 'bitrix_module_components', 'uses' => 'Modules\Bitrix\BitrixComponentsController@index']);
Route::get('my-modules/bitrix/{id}/new_components', ['as' => 'bitrix_new_component', 'uses' => 'Modules\Bitrix\BitrixComponentsController@create']);
Route::post('my-modules/bitrix/{module}/component_create', 'Modules\Bitrix\BitrixComponentsController@store');
Route::get('my-modules/bitrix/{module}/components/{component}', ['as' => 'bitrix_component_detail', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show']);
Route::get('my-modules/bitrix/{module}/components/{component}/visual_path', ['as' => 'bitrix_component_visual_path', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_visual_path']);
Route::post('my-modules/bitrix/{module}/components/{component}/store_visual_path', 'Modules\Bitrix\BitrixComponentsController@store_visual_path');
Route::get('my-modules/bitrix/{module}/components/{component}/params', ['as' => 'bitrix_component_params', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_params']);;
Route::post('my-modules/bitrix/{module}/components/{component}/store_params', 'Modules\Bitrix\BitrixComponentsController@store_params');
Route::get('my-modules/bitrix/{module}/components/{component}/delete_param/{param}', 'Modules\Bitrix\BitrixComponentsController@delete_param');
Route::post('my-modules/bitrix/{module}/components/{component}/upload_params_files', 'Modules\Bitrix\BitrixComponentsController@upload_params_files');
Route::get('my-modules/bitrix/{module}/components/{component}/component_php', ['as' => 'bitrix_component_component_php', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_component_php']);
Route::post('my-modules/bitrix/{module}/components/{component}/store_component_php', 'Modules\Bitrix\BitrixComponentsController@store_component_php');
Route::get('my-modules/bitrix/{module}/components/{component}/other_files', ['as' => 'bitrix_component_other_files', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_other_files']);
Route::post('my-modules/bitrix/{module}/components/{component}/store_other_files', 'Modules\Bitrix\BitrixComponentsController@store_other_files');
Route::get('my-modules/bitrix/{module}/components/{component}/templates', ['as' => 'bitrix_component_templates', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_templates']);
Route::post('my-modules/bitrix/{module}/components/{component}/store_template', 'Modules\Bitrix\BitrixComponentsController@store_template');
Route::get('my-modules/bitrix/{module}/components/{component}/delete_template/{template}', 'Modules\Bitrix\BitrixComponentsController@delete_template');
Route::post('my-modules/bitrix/{module}/upload_component_zip', ['as' => 'upload_component_zip', 'uses' => 'Modules\Bitrix\BitrixComponentsController@upload_zip']);
// .компоненты

// хранение данных
// инфоблоки
Route::get('my-modules/bitrix/{module}/data_storage', ['as' => 'bitrix_module_data_storage', 'uses' => 'Modules\Bitrix\BitrixDataStorageController@show']);
Route::get('my-modules/bitrix/{module}/data_storage/add_ib', 'Modules\Bitrix\BitrixDataStorageController@add_ib');
Route::post('my-modules/bitrix/{module}/data_storage/store_ib', 'Modules\Bitrix\BitrixDataStorageController@store_ib');
Route::get('my-modules/bitrix/{module}/data_storage/detail_ib/{iblock}', 'Modules\Bitrix\BitrixDataStorageController@detail_ib');
Route::get('my-modules/bitrix/{module}/data_storage/delete_ib/{iblock}', 'Modules\Bitrix\BitrixDataStorageController@delete_ib');
Route::post('my-modules/bitrix/{module}/data_storage/save_ib/{iblock}', 'Modules\Bitrix\BitrixDataStorageController@save_ib');
// .инфоблоки
// .хранение данных
// .Битрикс