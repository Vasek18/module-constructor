<?php

Route::get('/', "HomeController@index");

// Личный кабинет
Route::group(['prefix' => 'personal'], function (){
	Route::get('', ['as' => 'personal', 'uses' => 'PersonalController@index']);
	// страница авторизации
	Route::get('auth', ['as' => 'auth', 'uses' => 'Auth\AuthController@index']);
	// страница регистрации
	Route::get('reg', ['as' => 'reg', 'uses' => 'Auth\AuthController@index_reg']);

	Route::group(['prefix' => 'login'], function (){
		Route::get('', 'Auth\AuthController@getLogin');
		Route::post('', 'Auth\AuthController@postLogin');
	});
});
Route::group(['prefix' => 'auth'], function (){
	Route::group(['prefix' => 'register'], function (){
		Route::get('', 'Auth\AuthController@getRegister');
		Route::post('', 'Auth\AuthController@postRegister');
	});
	Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
});
Route::group(['prefix' => 'password'], function (){
	Route::group(['prefix' => 'email'], function (){
		Route::get('', 'Auth\PasswordController@getEmail');
		Route::post('', 'Auth\PasswordController@postEmail');
	});
	Route::group(['prefix' => 'reset'], function (){
		Route::get('{token}', 'Auth\PasswordController@getReset');
		Route::post('', 'Auth\PasswordController@postReset');
	});
});

// Битрикс
Route::group(['prefix' => 'my-bitrix'], function (){
	Route::get('create', 'Modules\Bitrix\BitrixController@index');
	Route::post('', 'Modules\Bitrix\BitrixController@store');
	Route::get('{module}', ['as' => 'bitrix_module_detail', 'uses' => 'Modules\Bitrix\BitrixController@show']);
	Route::put('{id}', 'Modules\Bitrix\BitrixController@update');
	Route::delete('{module}', 'Modules\Bitrix\BitrixController@destroy');
	Route::post('{module}/download', 'Modules\Bitrix\BitrixController@download_zip');

	// настройки
	Route::group(['prefix' => '{module}/admin_options'], function (){
		Route::get('', ['as' => 'bitrix_module_admin_options', 'uses' => 'Modules\Bitrix\BitrixOptionsController@index']);
		Route::post('', 'Modules\Bitrix\BitrixOptionsController@store');
		Route::get('delete/{option_id}', 'Modules\Bitrix\BitrixOptionsController@destroy');
	});

	// обработчики событий
	Route::group(['prefix' => '{module}/events_handlers'], function (){
		Route::get('', ['as' => 'bitrix_module_events_handlers', 'uses' => 'Modules\Bitrix\BitrixEventHandlersController@index']);
		Route::post('', 'Modules\Bitrix\BitrixEventHandlersController@store');
		Route::get('delete/{option_id}', 'Modules\Bitrix\BitrixEventHandlersController@destroy');
	});

	// компоненты
	Route::group(['prefix' => '{module}/components'], function (){
		Route::get('', ['as' => 'bitrix_module_components', 'uses' => 'Modules\Bitrix\BitrixComponentsController@index']);
		Route::get('create', ['as' => 'bitrix_new_component', 'uses' => 'Modules\Bitrix\BitrixComponentsController@create']);
		Route::post('', 'Modules\Bitrix\BitrixComponentsController@store');
		Route::get('{component}', ['as' => 'bitrix_component_detail', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show']);
		Route::post('upload_component_zip', ['as' => 'upload_component_zip', 'uses' => 'Modules\Bitrix\BitrixComponentsController@upload_zip']);

		// путь в визуальном редакторе
		Route::group(['prefix' => '{component}/visual_path'], function (){
			Route::get('', ['as' => 'bitrix_component_visual_path', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_visual_path']);
			Route::post('', 'Modules\Bitrix\BitrixComponentsController@store_visual_path');
		});

		// параметры в визуальном редакторе
		Route::group(['prefix' => '{component}/params'], function (){
			Route::get('', ['as' => 'bitrix_component_params', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_params']);;
			Route::post('', 'Modules\Bitrix\BitrixComponentsController@store_params');
			Route::get('{param}/delete', 'Modules\Bitrix\BitrixComponentsController@delete_param');
			Route::post('upload', 'Modules\Bitrix\BitrixComponentsController@upload_params_files');
		});

		// component.php
		Route::group(['prefix' => '{component}/component_php'], function (){
			Route::get('', ['as' => 'bitrix_component_component_php', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_component_php']);
			Route::post('store', 'Modules\Bitrix\BitrixComponentsController@store_component_php');
		});

		// другие файлы
		Route::group(['prefix' => '{component}/other_files'], function (){
			Route::get('', ['as' => 'bitrix_component_other_files', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_other_files']);
			Route::post('store', 'Modules\Bitrix\BitrixComponentsController@store_other_files');
		});

		// шаблоны
		Route::group(['prefix' => '{component}/templates'], function (){
			Route::get('', ['as' => 'bitrix_component_templates', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_templates']);
			Route::post('store', 'Modules\Bitrix\BitrixComponentsController@store_template');
			Route::get('{template}/delete', 'Modules\Bitrix\BitrixComponentsController@delete_template');
		});
	});

	// хранение данных
	Route::group(['prefix' => '{module}/data_storage'], function (){
		Route::get('', ['as' => 'bitrix_module_data_storage', 'uses' => 'Modules\Bitrix\BitrixDataStorageController@index']);

		// инфоблоки
		Route::group(['prefix' => 'ib'], function (){
			Route::get('', 'Modules\Bitrix\BitrixDataStorageController@add_ib');
			Route::post('', 'Modules\Bitrix\BitrixDataStorageController@store_ib');
			Route::get('{iblock}', 'Modules\Bitrix\BitrixDataStorageController@detail_ib');
			Route::get('{iblock}/delete', 'Modules\Bitrix\BitrixDataStorageController@delete_ib');
			Route::post('{iblock}/save', 'Modules\Bitrix\BitrixDataStorageController@save_ib');
		});
	});
});