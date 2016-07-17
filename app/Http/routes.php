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
//Route::group(['prefix' => 'my/bitrix'], function (){
Route::group(['prefix' => 'my-bitrix', 'middleware' => 'bitrix.owner'], function (){
	Route::get('create', 'Modules\Bitrix\BitrixController@create');
	Route::post('', 'Modules\Bitrix\BitrixController@store');
	Route::get('{module}', ['as' => 'bitrix_module_detail', 'uses' => 'Modules\Bitrix\BitrixController@show']);
	Route::put('{module}', 'Modules\Bitrix\BitrixController@update');
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
		Route::put('{component}', 'Modules\Bitrix\BitrixComponentsController@update');
		Route::get('{component}/delete', 'Modules\Bitrix\BitrixComponentsController@destroy');
		Route::get('{component}', ['as' => 'bitrix_component_detail', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show']);
		Route::post('upload_component_zip', ['as' => 'upload_component_zip', 'uses' => 'Modules\Bitrix\BitrixComponentsController@upload_zip']);
		Route::get('{component}/download', 'Modules\Bitrix\BitrixComponentsController@download');

		// путь в визуальном редакторе
		Route::group(['prefix' => '{component}/visual_path'], function (){
			Route::get('', ['as' => 'bitrix_component_visual_path', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_visual_path']);
			Route::post('', 'Modules\Bitrix\BitrixComponentsController@store_visual_path');
		});

		// параметры в визуальном редакторе
		Route::group(['prefix' => '{component}/params'], function (){
			Route::get('', ['as' => 'bitrix_component_params', 'uses' => 'Modules\Bitrix\BitrixComponentsParamsController@index']);
			Route::post('', 'Modules\Bitrix\BitrixComponentsParamsController@store');
			Route::get('{param}/delete', 'Modules\Bitrix\BitrixComponentsParamsController@destroy');
			Route::post('upload', 'Modules\Bitrix\BitrixComponentsParamsController@upload_params_files');
		});

		// component.php
		Route::group(['prefix' => '{component}/component_php'], function (){
			Route::get('', ['as' => 'bitrix_component_component_php', 'uses' => 'Modules\Bitrix\BitrixComponentsController@show_component_php']);
			Route::post('store', 'Modules\Bitrix\BitrixComponentsController@store_component_php');
		});

		// другие файлы
		Route::group(['prefix' => '{component}/other_files'], function (){
			Route::get('', ['as' => 'bitrix_component_other_files', 'uses' => 'Modules\Bitrix\BitrixComponentsArbitraryFilesController@index']);
			Route::post('', 'Modules\Bitrix\BitrixComponentsArbitraryFilesController@store');
			Route::get('{file}/delete', 'Modules\Bitrix\BitrixComponentsArbitraryFilesController@destroy');
		});

		// шаблоны
		Route::group(['prefix' => '{component}/templates'], function (){
			Route::get('', ['as' => 'bitrix_component_templates', 'uses' => 'Modules\Bitrix\BitrixComponentsTemplatesController@index']);
			Route::post('store', 'Modules\Bitrix\BitrixComponentsTemplatesController@store');
			Route::get('{template}', ['uses' => 'Modules\Bitrix\BitrixComponentsTemplatesController@show']);
			Route::get('{template}/delete', 'Modules\Bitrix\BitrixComponentsTemplatesController@destroy');
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
			Route::get('{prop}/delete_prop', 'Modules\Bitrix\BitrixDataStorageController@delete_prop'); // todo скорее всего ещё подгруппа
			Route::get('{iblock}/create_element', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@create_element']); // todo скорее всего ещё подгруппа
			Route::post('{iblock}/store_element', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@store_element']); // todo скорее всего ещё подгруппа
			Route::get('{iblock}/show_element/{element}', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@show_element']); // todo скорее всего ещё подгруппа
			Route::post('{iblock}/save_element/{element}', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@save_element']); // todo скорее всего ещё подгруппа
			Route::get('{iblock}/delete_element/{element}', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@delete_element']); // todo скорее всего ещё подгруппа
		});

		// элементы
		Route::group(['prefix' => '{iblock}/elements'], function (){
		});
	});

	// произвольные файлы
	Route::group(['prefix' => '{module}/arbitrary_files', 'middleware' => 'auth'], function (){
		Route::get('', ['as' => 'bitrix_module_arbitrary_files', 'uses' => 'Modules\Bitrix\BitrixArbitraryFilesController@index']);
		Route::post('', 'Modules\Bitrix\BitrixArbitraryFilesController@store');
		Route::get('{file}/delete', 'Modules\Bitrix\BitrixArbitraryFilesController@destroy');
		Route::post('{file}/update', 'Modules\Bitrix\BitrixArbitraryFilesController@update');

	});

	// почтовые события
	Route::group(['prefix' => '{module}/mail_events'], function (){
		Route::get('', ['as' => 'bitrix_module_mail_events', 'uses' => 'Modules\Bitrix\BitrixMailEventsController@index']);
		Route::get('create', ['uses' => 'Modules\Bitrix\BitrixMailEventsController@create']);
		Route::post('', 'Modules\Bitrix\BitrixMailEventsController@store');
		Route::get('{mail_event}', ['uses' => 'Modules\Bitrix\BitrixMailEventsController@show']);
		Route::put('{mail_event}', 'Modules\Bitrix\BitrixMailEventsController@update');
		Route::get('{mail_event}/delete', 'Modules\Bitrix\BitrixMailEventsController@destroy');
		Route::get('{mail_event}/templates/create', ['uses' => 'Modules\Bitrix\BitrixMailEventsController@create_template']);
		Route::post('{mail_event}/templates', ['uses' => 'Modules\Bitrix\BitrixMailEventsController@store_template']);
		Route::get('{mail_event}/templates/{template}', ['uses' => 'Modules\Bitrix\BitrixMailEventsController@show_template']);
		Route::post('{mail_event}/templates/{template}/update', ['uses' => 'Modules\Bitrix\BitrixMailEventsController@update_template']);
		Route::get('{mail_event}/templates/{template}/delete', ['uses' => 'Modules\Bitrix\BitrixMailEventsController@destroy_template']);
		Route::get('{mail_event}/vars/{var}/delete', ['uses' => 'Modules\Bitrix\BitrixMailEventsController@destroy_var']);
		Route::post('{mail_event}/vars/create', ['uses' => 'Modules\Bitrix\BitrixMailEventsController@add_var']);
	});

	// страницы административного меню
	Route::group(['prefix' => '{module}/admin_menu', 'middleware' => 'auth'], function (){
		Route::get('', ['as' => 'bitrix_module_admin_menu', 'uses' => 'Modules\Bitrix\BitrixAdminMenuController@index']);
		Route::get('create', ['uses' => 'Modules\Bitrix\BitrixAdminMenuController@create']);
		Route::post('', 'Modules\Bitrix\BitrixAdminMenuController@store');
		Route::get('{admin_menu_page}', ['uses' => 'Modules\Bitrix\BitrixAdminMenuController@show']);
		Route::put('{admin_menu_page}', 'Modules\Bitrix\BitrixAdminMenuController@update');
		Route::get('{admin_menu_page}/delete', 'Modules\Bitrix\BitrixAdminMenuController@destroy');
	});
});
//Route::post('my/bitrix/{bitrix}/download', 'Modules\Bitrix\BitrixController@download_zip');
//Route::resource('my/bitrix', 'Modules\Bitrix\BitrixController', [
//	'names' => [
//		'show' => 'bitrix_module_detail'
//	],
//	'only'  => ['create', 'show', 'store', 'update', 'destroy']
//]);

Route::get('test', function (){ // todo del (тестовый)
	Illuminate\Support\Facades\Session::put('lang', Config::get('app.locale') == 'ru' ? 'en' : 'ru');

	return redirect('/');
});