<?php

Route::get('/', "HomeController@index");

// Login Routes...
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

// Registration Routes...
Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);

// Password Reset Routes...
Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);

// Личный кабинет
Route::group(['prefix' => 'personal'], function (){
	Route::get('', ['as' => 'personal', 'uses' => 'PersonalController@index']);

	Route::group(['prefix' => 'oplata'], function (){
		Route::get('', 'PersonalController@oplata');
	});

	Route::group(['prefix' => 'help_project'], function (){
		Route::get('', 'PersonalController@help_project');
	});

	Route::group(['prefix' => 'donate'], function (){
		Route::get('', 'PersonalController@donate');
	});

	Route::group(['prefix' => 'info'], function (){
		Route::get('', 'PersonalController@info');
		Route::post('', 'PersonalController@infoEdit');
	});

	Route::group(['prefix' => 'get-token'], function (){
		Route::get('', 'PersonalController@getToken');
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

		// пользовательские свойства
		Route::group(['prefix' => 'user_fields'], function (){
			Route::get('create', 'Modules\Bitrix\BitrixUserFieldsController@create');
			Route::post('store', 'Modules\Bitrix\BitrixUserFieldsController@store');
			Route::get('{user_field}/edit', 'Modules\Bitrix\BitrixUserFieldsController@edit');
			Route::post('{user_field}/update', 'Modules\Bitrix\BitrixUserFieldsController@update');
			Route::get('{user_field}/destroy', 'Modules\Bitrix\BitrixUserFieldsController@destroy');
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

	// маркетинг
	Route::get('{module}/marketing', ['uses' => 'Modules\Bitrix\BitrixController@marketing']);
});

// менеджмент
Route::group([
    'prefix' => 'module-management/{module}',
    'middleware' => [
        'module.owner',
        'auth'
    ]
], function(){
    Route::get('', ['uses' => 'Modules\Management\ModulesManagementController@index']);

    // жалобы клиентов
    Route::group(['prefix' => 'clients-issues'], function(){
        Route::get('', ['uses' => 'Modules\Management\ModulesClientsIssueController@index']);
        Route::post('', ['uses' => 'Modules\Management\ModulesClientsIssueController@store']);
        Route::post('{issue}/change-counter', ['uses' => 'Modules\Management\ModulesClientsIssueController@changeCounter']);
        Route::post('{issue}/update', ['uses' => 'Modules\Management\ModulesClientsIssueController@update']);
        Route::post('{issue}/solved', ['uses' => 'Modules\Management\ModulesClientsIssueController@solved']);
        Route::post('{issue}/not-solved', ['uses' => 'Modules\Management\ModulesClientsIssueController@notSolved']);
        Route::post('{issue}/destroy', ['uses' => 'Modules\Management\ModulesClientsIssueController@destroy']);
    });

    // конкуренты
    Route::group(['prefix' => 'competitors'], function(){
        Route::get('', ['uses' => 'Modules\Management\ModulesCompetitorsController@index']);
        Route::get('create', ['uses' => 'Modules\Management\ModulesCompetitorsController@create']);
        Route::post('store', ['uses' => 'Modules\Management\ModulesCompetitorsController@store']);
        Route::get('{competitor}/edit', ['uses' => 'Modules\Management\ModulesCompetitorsController@edit']);
        Route::get('{competitor}/delete', ['uses' => 'Modules\Management\ModulesCompetitorsController@delete']);
        Route::post('{competitor}/update', ['uses' => 'Modules\Management\ModulesCompetitorsController@update']);
    });
});

Route::post('feedback/ilack', 'FeedbackController@sendILackSmthForm');
Route::post('feedback/bug_report', 'FeedbackController@sendBugReportForm');

Route::group(['prefix' => 'oko', 'middleware' => 'admin'], function (){
	Route::get('', ['uses' => 'Admin\AdminController@index']);

	Route::group(['prefix' => 'users'], function (){
		Route::get('', ['uses' => 'Admin\AdminUsersController@index']);
		Route::get('{user}', ['uses' => 'Admin\AdminUsersController@show']);
		Route::post('{user}', ['uses' => 'Admin\AdminUsersController@update']);
		Route::get('{user}/delete', ['uses' => 'Admin\AdminUsersController@destroy']);
	});

	Route::get('modules', ['uses' => 'Admin\AdminController@modules']);
	Route::get('modules/{module}', ['uses' => 'Admin\AdminController@modulesDetail']);

	Route::group(['prefix' => 'settings'], function (){
		Route::get('', ['uses' => 'Admin\AdminSettingsController@index']);
		Route::post('', ['uses' => 'Admin\AdminSettingsController@store']);
	});

	Route::group(['prefix' => 'logs'], function (){
		Route::get('', ['uses' => 'Admin\AdminLogsController@index']);
		Route::get('{file_name}', ['uses' => 'Admin\AdminLogsController@show']);
		Route::get('{file_name}/delete', ['uses' => 'Admin\AdminLogsController@delete']);
	});

	// категории статей
	Route::group(['prefix' => 'article_sections'], function (){
		Route::get('create', ['uses' => 'Admin\AdminArticleSectionsController@create']);
		Route::post('', ['uses' => 'Admin\AdminArticleSectionsController@store']);
		Route::get('{section}', ['uses' => 'Admin\AdminArticleSectionsController@show']);
		Route::get('{section}/edit', ['uses' => 'Admin\AdminArticleSectionsController@edit']);
		Route::put('{section}', ['uses' => 'Admin\AdminArticleSectionsController@update']);
		Route::get('{section}/delete', ['uses' => 'Admin\AdminArticleSectionsController@destroy']);
	});

	// статьи
	Route::group(['prefix' => 'articles'], function (){
		Route::get('', ['uses' => 'Admin\AdminController@articles']);
		Route::get('create', ['uses' => 'Admin\AdminArticlesController@create']);
		Route::post('', ['uses' => 'Admin\AdminArticlesController@store']);
		Route::get('{article}', ['uses' => 'Admin\AdminArticlesController@show']);
		Route::get('{article}/edit', ['uses' => 'Admin\AdminArticlesController@edit']);
		Route::put('{article}', ['uses' => 'Admin\AdminArticlesController@update']);
		Route::get('{article}/delete', ['uses' => 'Admin\AdminArticlesController@destroy']);

		Route::group(['prefix' => '{article}/files'], function (){
			Route::post('upload', ['uses' => 'Admin\AdminArticlesFilesController@upload']);
			Route::get('{file}/delete', ['uses' => 'Admin\AdminArticlesFilesController@destroy']);
		});
	});

	// настройки
	Route::group(['prefix' => 'settings'], function (){
		Route::post('{setting}/set', ['uses' => 'Admin\AdminSettingsController@set']);
	});

	// подтверждение предложений пользователей
	Route::group(['prefix' => 'confirms'], function (){
		Route::get('', ['uses' => 'Admin\AdminConfirmsController@index']);
		Route::get('{module}/approve_module', ['uses' => 'Admin\AdminConfirmsController@approveModule']);
		Route::get('{module}/delete_module', ['uses' => 'Admin\AdminConfirmsController@deleteModule']);
		Route::get('{event}/approve_event', ['uses' => 'Admin\AdminConfirmsController@approveEvent']);
		Route::get('{event}/delete_event', ['uses' => 'Admin\AdminConfirmsController@deleteEvent']);
		Route::get('clear_modules_form_duplicates', ['uses' => 'Admin\AdminConfirmsController@clearModulesFormDuplicates']);
		Route::get('clear_events_form_duplicates', ['uses' => 'Admin\AdminConfirmsController@clearEventsFormDuplicates']);
	});

	// шаблоны class.php компонентов Битрикса
	Route::group(['prefix' => 'bitrix_class_php_templates'], function (){
		Route::get('', ['uses' => 'Admin\AdminClassPhpTemplatesController@index']);
		Route::get('private_ones', ['uses' => 'Admin\AdminClassPhpTemplatesController@private_ones']);
		Route::post('add', ['uses' => 'Admin\AdminClassPhpTemplatesController@add']);
		Route::get('{template}/delete', ['uses' => 'Admin\AdminClassPhpTemplatesController@delete']);
		Route::get('{template}/edit', ['uses' => 'Admin\AdminClassPhpTemplatesController@edit']);
		Route::put('{template}', ['uses' => 'Admin\AdminClassPhpTemplatesController@update']);
	});

	// оплаты
	Route::group(['prefix' => 'payments'], function (){
		Route::get('', ['uses' => 'Admin\AdminPaymentsController@index']);
		Route::get('{payment}/delete', ['uses' => 'Admin\AdminPaymentsController@delete']);
	});

	// репорты пользователей
	Route::group(['prefix' => 'user_reports'], function (){
		Route::get('', ['uses' => 'Admin\AdminUserReportsController@index']);
		Route::get('{report}/delete', ['uses' => 'Admin\AdminUserReportsController@destroy']);
	});

	// пульс проекта
	Route::group(['prefix' => 'project_pulse'], function (){
		Route::get('', ['uses' => 'Admin\AdminProjectPulseController@index']);
		Route::post('', ['uses' => 'Admin\AdminProjectPulseController@store']);
	});
});

// просто страницы
Route::get('oplata', ['uses' => 'HtmlPagesController@oplata']);
Route::get('does_it_charge', ['uses' => 'HtmlPagesController@does_it_charge']);
Route::get('contacts', ['uses' => 'HtmlPagesController@contacts']);
Route::get('requisites', ['uses' => 'HtmlPagesController@requisites']);
Route::get('personal-info-agreement', ['uses' => 'HtmlPagesController@personal_info_agreement']);
Route::get('politika-konfidencialnosti', ['uses' => 'HtmlPagesController@politika_konfidencialnosti']);

// яндекс.касса
Route::group(['prefix' => 'yandex_kassa'], function (){
	Route::any('check_order', ['uses' => 'YandexKassaController@checkOrder']);
	Route::any('payment_aviso', ['uses' => 'YandexKassaController@paymentAviso']);
	Route::any('success', ['uses' => 'YandexKassaController@success']);
	Route::any('fail', ['uses' => 'YandexKassaController@fail']);
});

// предложения функционала
Route::group(['prefix' => 'functional_suggestions'], function (){
	Route::get('', ['uses' => 'FunctionalSuggestionController@index']);
	Route::post('add', ['uses' => 'FunctionalSuggestionController@store']);
	Route::get('{suggestion}/upvote', ['uses' => 'FunctionalSuggestionController@upvote']);
	Route::get('{suggestion}/delete', ['uses' => 'FunctionalSuggestionController@destroy']);
});

// помощь проекту
Route::group(['prefix' => 'project_help'], function (){
	Route::get('', ['uses' => 'ProjectHelpController@index']);
	Route::group(['prefix' => 'bitrix'], function (){
		Route::group(['prefix' => 'events'], function (){
			Route::get('', ['uses' => 'ProjectHelpController@bitrixEvents']);
			Route::post('add', ['uses' => 'ProjectHelpController@bitrixEventsAdd']);
			Route::get('{event}/mark_as_bad', ['uses' => 'ProjectHelpController@bitrixEventsMarkAsBad']);
		});
		Route::group(['prefix' => 'class_php_templates'], function (){
			Route::post('add', ['uses' => 'ProjectHelpController@bitrixClassPhpTemplatesAdd', 'middleware' => ['auth']]);
			Route::get('{template}/delete', ['uses' => 'ProjectHelpController@bitrixClassPhpTemplatesDelete', 'middleware' => ['auth']]);
		});
	});
});

// пульс проекта
Route::group(['prefix' => 'project_pulse'], function (){
	Route::get('', ['uses' => 'ProjectPulsePostController@index']);
	Route::get('{post}/delete', ['uses' => 'ProjectPulsePostController@destroy']);
});

Route::get('{section_code}/{article_code}', ['uses' => 'ArticleController@show']);
Route::get('{section_code}', ['uses' => 'ArticleSectionController@show']);

//Route::post('my/bitrix/{bitrix}/download', 'Modules\Bitrix\BitrixController@download_zip');
//Route::resource('my/bitrix', 'Modules\Bitrix\BitrixController', [
//	'names' => [
//		'show' => 'bitrix_module_detail'
//	],
//	'only'  => ['create', 'show', 'store', 'update', 'destroy']
//]);