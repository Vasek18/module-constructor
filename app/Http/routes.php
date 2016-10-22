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
Route::group(['prefix' => 'my-bitrix', 'middleware' => ['bitrix.owner', 'auth']], function (){
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
		Route::get('delete/{option}', 'Modules\Bitrix\BitrixOptionsController@destroy');
	});

	// обработчики событий
	Route::group(['prefix' => '{module}/events_handlers'], function (){
		Route::get('', ['as' => 'bitrix_module_events_handlers', 'uses' => 'Modules\Bitrix\BitrixEventHandlersController@index']);
		Route::post('', 'Modules\Bitrix\BitrixEventHandlersController@store');
		Route::get('delete/{handler}', 'Modules\Bitrix\BitrixEventHandlersController@destroy');
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
			Route::get('get_templates', 'Modules\Bitrix\BitrixComponentsController@get_logic_files_templates');
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
			Route::post('upload', 'Modules\Bitrix\BitrixComponentsTemplatesController@upload');
			Route::post('store', 'Modules\Bitrix\BitrixComponentsTemplatesController@store');
			Route::get('create', ['uses' => 'Modules\Bitrix\BitrixComponentsTemplatesController@create']);
			Route::get('{template}', ['uses' => 'Modules\Bitrix\BitrixComponentsTemplatesController@show']);
			Route::post('{template}/update', 'Modules\Bitrix\BitrixComponentsTemplatesController@update');
			Route::get('{template}/delete', 'Modules\Bitrix\BitrixComponentsTemplatesController@destroy');
			Route::get('{template}/params', 'Modules\Bitrix\BitrixComponentsTemplatesController@show_params');
			Route::get('{template}/files', 'Modules\Bitrix\BitrixComponentsTemplatesController@show_files');
		});
	});

	// хранение данных
	Route::group(['prefix' => '{module}/data_storage'], function (){
		Route::get('', ['as' => 'bitrix_module_data_storage', 'uses' => 'Modules\Bitrix\BitrixDataStorageController@index']);

		// инфоблоки
		Route::group(['prefix' => 'ib'], function (){
			Route::get('', 'Modules\Bitrix\BitrixDataStorageController@add_ib');
			Route::post('', 'Modules\Bitrix\BitrixDataStorageController@store_ib');
			Route::post('xml_ib_import', 'Modules\Bitrix\BitrixDataStorageController@xml_ib_import');
			Route::get('{iblock}', 'Modules\Bitrix\BitrixDataStorageController@detail_ib');
			Route::get('{iblock}/delete', 'Modules\Bitrix\BitrixDataStorageController@delete_ib');
			Route::post('{iblock}/save', 'Modules\Bitrix\BitrixDataStorageController@save_ib');
			Route::get('{iblock}/props/{prop}/delete', 'Modules\Bitrix\BitrixDataStorageController@delete_prop'); // todo скорее всего ещё подгруппа

			Route::get('{iblock}/create_element', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@create_element']); // todo скорее всего ещё подгруппа
			Route::post('{iblock}/store_element', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@store_element']); // todo скорее всего ещё подгруппа
			Route::get('{iblock}/edit_element/{element}', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@edit_element']); // todo скорее всего ещё подгруппа
			Route::post('{iblock}/save_element/{element}', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@save_element']); // todo скорее всего ещё подгруппа
			Route::get('{iblock}/delete_element/{element}', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@delete_element']); // todo скорее всего ещё подгруппа

			Route::get('{iblock}/create_section', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@create_section']); // todo скорее всего ещё подгруппа
			Route::post('{iblock}/store_section', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@store_section']); // todo скорее всего ещё подгруппа
			Route::get('{iblock}/edit_section/{section}', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@edit_section']); // todo скорее всего ещё подгруппа
			Route::get('{iblock}/section/{section}', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@show_section']); // todo скорее всего ещё подгруппа
			Route::post('{iblock}/save_section/{section}', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@save_section']); // todo скорее всего ещё подгруппа
			Route::get('{iblock}/delete_section/{section}', ['uses' => 'Modules\Bitrix\BitrixDataStorageController@delete_section']); // todo скорее всего ещё подгруппа

		});

		// элементы
		Route::group(['prefix' => '{iblock}/elements'], function (){
		});
	});

	// произвольные файлы
	Route::group(['prefix' => '{module}/arbitrary_files'], function (){
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
	Route::group(['prefix' => '{module}/admin_menu'], function (){
		Route::get('', ['as' => 'bitrix_module_admin_menu', 'uses' => 'Modules\Bitrix\BitrixAdminMenuController@index']);
		Route::get('create', ['uses' => 'Modules\Bitrix\BitrixAdminMenuController@create']);
		Route::post('', 'Modules\Bitrix\BitrixAdminMenuController@store');
		Route::get('{admin_menu_page}', ['uses' => 'Modules\Bitrix\BitrixAdminMenuController@show']);
		Route::put('{admin_menu_page}', 'Modules\Bitrix\BitrixAdminMenuController@update');
		Route::get('{admin_menu_page}/delete', 'Modules\Bitrix\BitrixAdminMenuController@destroy');
	});

	// переводы
	Route::group(['prefix' => '{module}/lang'], function (){
		Route::get('', ['as' => 'bitrix_module_lang', 'uses' => 'Modules\Bitrix\BitrixLangController@index']);
		Route::get('/edit', ['uses' => 'Modules\Bitrix\BitrixLangController@edit']);
		Route::post('/update', ['uses' => 'Modules\Bitrix\BitrixLangController@update']);
	});
});

Route::post('feedback/ilack', 'FeedbackController@sendILackSmthForm');

Route::group(['prefix' => 'oko', 'middleware' => 'admin'], function (){
	Route::get('', ['uses' => 'Admin\AdminController@index']);
	Route::get('users', ['uses' => 'Admin\AdminController@users']);
	Route::get('users/{user}', ['uses' => 'Admin\AdminController@usersDetail']);
	Route::get('modules', ['uses' => 'Admin\AdminController@modules']);
	Route::get('modules/{module}', ['uses' => 'Admin\AdminController@modulesDetail']);
	Route::get('settings', ['uses' => 'Admin\AdminController@settings']);
});

Route::get('_ololotrololo_', function (){ // todo удалить
	$me = \App\Models\User::where(['email' => 'aristov-92@mail.ru'])->first();
	$me->group_id = \Illuminate\Support\Facades\Config::get('constants.ADMIN_GROUP_ID');
	$me->save();

	return redirect('/');
});

Route::get('test', function (){ // todo удалить
	// echo DIRECTORY_SEPARATOR;
	$file = Illuminate\Support\Facades\Storage::disk('modules_templates')->get(''.DIRECTORY_SEPARATOR.'bitrix'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'component_name'.DIRECTORY_SEPARATOR.'.description.php');
	// echo file_get_contents(base_path().'/storage/modules_templates/bitrix/install/components/component_name/.description.php');
	// $file = Illuminate\Support\Facades\Storage::disk('modules_templates')->getRoot();
	dd($file);
});

//Route::post('my/bitrix/{bitrix}/download', 'Modules\Bitrix\BitrixController@download_zip');
//Route::resource('my/bitrix', 'Modules\Bitrix\BitrixController', [
//	'names' => [
//		'show' => 'bitrix_module_detail'
//	],
//	'only'  => ['create', 'show', 'store', 'update', 'destroy']
//]);