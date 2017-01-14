<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Models\Modules\Bitrix\BitrixComponentsParams;
use App\Models\Modules\Bitrix\BitrixComponentsTemplates;
use App\Models\Modules\Bitrix\BitrixComponentsArbitraryFiles;

class BitrixComponentsInterfaceTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/components';

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		if ($this->module){
			$this->module->deleteFolder();
		}
	}

	/** @test */
	function author_can_get_to_this_page(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path);

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_components(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('Компоненты');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_components_en(){
		$this->setLang('en');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('Components');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->logOut();

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal/auth');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function not_author_cannot_get_to_index_page_of_anothers_module(){
		$this->signIn(factory(App\Models\User::class)->create());

		$this->deleteFolder($this->standartModuleCode);

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal');
	}

	/** @test */
	function not_author_cannot_get_to_component_detail_page_of_anothers_module(){
		// есть один модуль с компонентом
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$this->module->deleteFolder();

		// у другого юзера тоже есть модуль с компонентом
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$component2 = $this->createComponentOnForm($module2);
		$module2->deleteFolder();

		// не должно быть такого, чтобы подменив айдишник компонента на айди компонента из другого модуля, мы хоть что-то увидели
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$component->id);
		$this->seePageIs('/personal');
	}

	/** @test */
	function it_returns_component_data_on_detail_page(){
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/components/'.$component->id);
		$this->see('Heh');
		$this->see('1487');
		$this->see('trololo');
		$this->see('My cool component');
		$this->see('dummy');
	}

	/** @test */
	function it_makes_hello_world_component_instead_of_empty(){
		$component = $this->createComponentOnForm($this->module, [
			'name' => 'Heh',
			'sort' => '1487',
			'code' => 'trololo',
			'desc' => 'My cool component',
		]);

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/components/'.$component->id);
		$this->see('Heh');
		$this->see('1487');
		$this->see('trololo');
		$this->see('My cool component');

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/visual_path');
		$this->seeInField('path_id_1', $this->module->PARTNER_CODE."_".$this->module->code."_components");
		$this->seeInField('path_name_1', $this->module->name);
		$this->seeInField('path_sort_1', '500');

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');
		$this->seeInField('component_php', '<?'."\n".'if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();'."\n"."\n".'$this->IncludeComponentTemplate();'."\n".'?>');

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/templates');
		$this->see('.default (Дефолтный)');
	}

	/** @test */
	function it_can_delete_component_from_detail(){
		$component = $this->createComponentOnForm($this->module);

		$this->deleteComponentFromDetail($component);

		$this->deleteFolder($this->standartModuleCode);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path);
	}

	/** @test */
	function not_author_cannot_delete_component(){
		// есть один модуль с компонентом
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$this->module->deleteFolder();

		// у другого юзера тоже есть модуль с компонентом
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$component2 = $this->createComponentOnForm($module2);
		$module2->deleteFolder();

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$component->id.'/delete');
		$this->seePageIs('/personal');
	}

	/** @test */
	function not_author_cannot_get_to_component_visual_path_page_of_anothers_module(){
		// есть один модуль с компонентом
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$this->module->deleteFolder();

		// у другого юзера тоже есть модуль с компонентом
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$component2 = $this->createComponentOnForm($module2);
		$module2->deleteFolder();

		// не должно быть такого, чтобы подменив айдишник компонента на айди компонента из другого модуля, мы хоть что-то увидели
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$component->id.'/visual_path');
		$this->seePageIs('/personal');
	}

	/** @test */
	function it_can_store_visual_path_form(){
		$component = $this->createComponentOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/visual_path');

		$this->submitForm('store_path', [
			'path_id_1'   => 'ololo1',
			'path_name_1' => 'ololo2',
			'path_sort_1' => '500',
			'path_id_2'   => 'trololo1',
			'path_name_2' => 'trololo2',
			'path_sort_2' => '1000',
			'path_id_3'   => 'foo1',
			'path_name_3' => 'foo2',
			'path_sort_3' => '1500',
		]);

		$this->seeInField('path_id_1', 'ololo1');
		$this->seeInField('path_name_1', 'ololo2');
		$this->seeInField('path_sort_1', '500');
		$this->seeInField('path_id_2', 'trololo1');
		$this->seeInField('path_name_2', 'trololo2');
		$this->seeInField('path_sort_2', '1000');
		$this->seeInField('path_id_3', 'foo1');
		$this->seeInField('path_name_3', 'foo2');
		$this->seeInField('path_sort_3', '1500');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_can_store_component_php(){
		$component = $this->createComponentOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');

		$this->submitForm('save', [
			'component_php' => '<? echo "Hi"; ?>',
		]);

		$this->seeInField('component_php', '<? echo "Hi"; ?>');
	}

	/** @test */
	function not_author_cannot_get_to_component_component_php_page_of_anothers_module(){
		// есть один модуль с компонентом
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$this->module->deleteFolder();

		// у другого юзера тоже есть модуль с компонентом
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$component2 = $this->createComponentOnForm($module2);
		$module2->deleteFolder();

		// не должно быть такого, чтобы подменив айдишник компонента на айди компонента из другого модуля, мы хоть что-то увидели
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$component->id.'/component_php');
		$this->seePageIs('/personal');
	}

	/** @test */
	function user_can_add_his_class_php_template(){
		$component = $this->createComponentOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');

		$this->submitForm('add_template', [
			'name'     => 'Test template',
			'template' => '<? echo "Hi"; ?>',
		]);

		$this->see('Test template');
	}

	/** @test */
	function not_author_can_cannot_see_class_php_templates_of_other_users(){
		$component = $this->createComponentOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');

		$this->submitForm('add_template', [
			'name'     => 'Test template',
			'template' => '<? echo "Hi"; ?>',
		]);

		// а теперь другой
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$component = $this->createComponentOnForm($module2);

		$this->visit('/my-bitrix/'.$module2->id.'/components/'.$component->id.'/component_php');

		$this->dontSee('Test template');
	}

	/** @test */
	function not_author_cannot_get_to_component_arbitrary_files_page_of_anothers_module(){
		// есть один модуль с компонентом
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$this->module->deleteFolder();

		// у другого юзера тоже есть модуль с компонентом
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$component2 = $this->createComponentOnForm($module2);
		$module2->deleteFolder();

		// не должно быть такого, чтобы подменив айдишник компонента на айди компонента из другого модуля, мы хоть что-то увидели
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$component->id.'/other_files');
		$this->seePageIs('/personal');
	}

	/** @test */
	function it_can_store_arbitrary_file(){
		$component = $this->createComponentOnForm($this->module);

		$this->storeComponentArbitraryFileOnForm($this->module, $component, '/ololo/', 'ololo.php', '<? echo "Hi"; ?>');

		$this->deleteFolder($this->standartModuleCode);

		$this->see('/ololo/ololo.php');
	}

	/** @test */
	function it_can_store_arbitrary_file_in_template(){
		$component = $this->createComponentOnForm($this->module);
		$template = $this->createComponentTemplateOnForm($this->module, $component, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);
		$this->storeComponentArbitraryFileOnForm($this->module, $component, '/ololo/', 'ololo.php', '<? echo "Hi"; ?>', $template);

		$this->deleteFolder($this->standartModuleCode);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/templates/'.$template->id.'/files');

		$this->see('/ololo/ololo.php');
	}

	/** @test */
	function not_author_cannot_delete_component_arbitrary_file_of_anothers_component(){
		// есть один модуль с компонентом с файлом
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$file1 = $this->storeComponentArbitraryFileOnForm($this->module, $component, '/ololo/', 'ololo.php', '<? echo "Hi"; ?>');
		$this->module->deleteFolder();

		// у другого юзера тоже есть модуль с компонентом с файлом
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$component2 = $this->createComponentOnForm($module2);
		$file2 = $this->storeComponentArbitraryFileOnForm($module2, $component2, '/trololo/', 'trololo.php', 'test');
		$module2->deleteFolder();

		// не должно быть такого, чтобы подменив айдишник файла на айди компонента из другого модуля, мы хоть что-то увидели
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$component2->id.'/other_files/'.$file1->id.'/delete');
		$this->seePageIs('/personal');
	}

	/** @test */
	function it_can_find_name_of_noname_system_param(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name' => '',
			'code' => 'CACHE_TIME',
			'type' => 'STRING',
		]);

		$this->see('Время кеширования (сек.)');
	}

	/** @test */
	function not_author_cannot_delete_component_param_of_another_component(){
		// есть один модуль с компонентом с параметром
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$param1 = $this->createComponentParamOnForm($this->module, $component, 0, [
			'name' => '',
			'code' => 'CACHE_TIME',
			'type' => 'STRING',
		]);
		$this->module->deleteFolder();

		// у другого юзера тоже есть модуль с компонентом с параметром
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$component2 = $this->createComponentOnForm($module2);
		$param2 = $this->createComponentParamOnForm($module2, $component2, 0, [
			'name' => '',
			'code' => 'CACHE_TIME',
			'type' => 'STRING',
		]);
		$module2->deleteFolder();

		// не должно быть такого, чтобы подменив айдишник параметра на айди компонента из другого модуля, мы хоть что-то увидели
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$component2->id.'/params/'.$param1->id.'/delete');
		$this->seePageIs('/personal');
	}

	/** @test */
	function not_author_cannot_get_to_component_templates_page_of_anothers_module(){
		// есть один модуль с компонентом
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$this->module->deleteFolder();

		// у другого юзера тоже есть модуль с компонентом
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$component2 = $this->createComponentOnForm($module2);
		$module2->deleteFolder();

		// не должно быть такого, чтобы подменив айдишник компонента на айди компонента из другого модуля, мы хоть что-то увидели
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$component->id.'/templates');
		$this->seePageIs('/personal');
	}

	/** @test */
	function not_author_cannot_get_to_component_template_detail_page_of_another_component(){
		// есть один модуль с компонентом с шаблоном
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);
		$template = $this->createComponentTemplateOnForm($this->module, $component, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);
		$this->module->deleteFolder();

		// у другого юзера тоже есть модуль с компонентом с шаблоном
		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$component2 = $this->createComponentOnForm($module2);
		$template2 = $this->createComponentTemplateOnForm($module2, $component2, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);
		$module2->deleteFolder();

		// не должно быть такого, чтобы подменив айдишник шаблона на айди шаблона из другого компонента, мы хоть что-то увидели
		$this->visit('/my-bitrix/'.$module2->id.$this->path.'/'.$component2->id.'/templates/'.$template->id);
		$this->seePageIs('/personal');
	}

	/** @test */
	function it_can_store_template(){
		$component = $this->createComponentOnForm($this->module);
		$template = $this->createComponentTemplateOnForm($this->module, $component, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/templates/'.$template->id);
		$this->seeInField('name', 'Test');
		$this->seeInField('template_php', '<? echo "HW"; ?>');
		$this->seeInField('style_css', '123');
		$this->seeInField('script_js', '234');
		$this->seeInField('result_modifier_php', '345');
		$this->seeInField('component_epilog_php', '<? ?>');
	}

	/** @test */
	function it_can_update_template(){
		$component = $this->createComponentOnForm($this->module);
		$template = $this->createComponentTemplateOnForm($this->module, $component, [
			'name'                 => 'Test2',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "ololo"; ?>',
			'style_css'            => '.ololo{color: #fff;}',
			'script_js'            => 'console.log("ololo")',
			'result_modifier_php'  => '',
			'component_epilog_php' => '',
		]);

		$this->submitForm('save', [
			'name'                 => 'Test',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/templates/'.$template->id);
		$this->seeInField('name', 'Test');
		$this->seeInField('template_php', '<? echo "HW"; ?>');
		$this->seeInField('style_css', '123');
		$this->seeInField('script_js', '234');
		$this->seeInField('result_modifier_php', '345');
		$this->seeInField('component_epilog_php', '<? ?>');
	}

	/** @test */
	function it_shows_params_according_to_templates(){
		$component = $this->createComponentOnForm($this->module);
		$template = $this->createComponentTemplateOnForm($this->module, $component, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);
		$commonParam = $this->createComponentParamOnForm($this->module, $component, 0, [
			'name' => 'Ololoparam',
			'code' => 'trololo',
			'type' => 'STRING',
		]);
		$templateParam = $this->createComponentParamOnForm($this->module, $component, 0, [
			'name'        => 'Masha',
			'code'        => 'nasha',
			'type'        => 'STRING',
			'template_id' => $template->id,
		]);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/params');
		$this->see('Ololoparam');

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/templates/'.$template->id.'/params');
		$this->see('Masha');
	}

	/** @test */
	function it_can_parse_component_from_zip(){
		$archive = public_path().'/for_tests/bitrix_catalog.section.zip';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($archive, 'archive');
		$this->press('upload');

		$uriArr = explode('/', $this->currentUri);
		$componenID = $uriArr[count($uriArr) - 1]; // вохможно не лучший способ, но мб единственный

		// инфа на детальной
		$this->see('catalog.section');
		$this->see('Элементы раздела');
		$this->see('Выводит элементы раздела с указанным набором свойств, цен и т.д.');
		$this->see('30');

		// путь в визуальном редакторе
		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$componenID.'/visual_path');
		$this->seeInField('path_id_1', 'content');
		$this->seeInField('path_sort_1', '500');
		$this->seeInField('path_id_2', 'catalog');
		$this->seeInField('path_name_2', 'Каталог');
		$this->seeInField('path_sort_2', '30');
		$this->seeInField('path_id_3', 'catalog_cmpx');
		$this->seeInField('path_sort_3', '500');

		// параметры
		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$componenID.'/params');
		$this->see('Инфоблок');
		$this->see('ID раздела');
		$this->see('Код раздела');
		$this->see('Свойства раздела');
		$this->see('По какому полю сортируем элементы');
		$this->see('Порядок сортировки элементов');
		$this->see('Поле для второй сортировки элементов');
		$this->see('Порядок второй сортировки элементов');
		$this->see('Имя массива со значениями фильтра для фильтрации элементов');
		$this->see('Показывать элементы подразделов раздела');
		$this->see('Показывать все элементы, если не указан раздел');
		$this->see('URL, ведущий на страницу с содержимым раздела');
		$this->see('URL, ведущий на страницу с содержимым элемента раздела');
		$this->see('Название переменной, в которой передается код группы');
		$this->see('Устанавливать заголовок страницы');
		$this->see('Устанавливать заголовок окна браузера');
		$this->see('Установить заголовок окна браузера из свойства');
		$this->see('Установить ключевые слова страницы из свойства');
		$this->see('Установить описание страницы из свойства');
		$this->see('Устанавливать в заголовках ответа время модификации страницы');
		$this->see('Использовать основной раздел для показа элемента');
		$this->see('Включать раздел в цепочку навигации');
		$this->see('Количество элементов на странице');
		$this->see('Количество элементов выводимых в одной строке таблицы');
		$this->see('Свойства');
		$this->see('Свойства предложений');
		$this->see('По какому полю сортируем предложения товара');
		$this->see('Порядок сортировки предложений товара');
		$this->see('Поле для второй сортировки предложений товара');
		$this->see('Порядок второй сортировки предложений товара');
		$this->see('Максимальное количество предложений для показа (0 - все)');
		$this->see('Тип цены');
		$this->see('Использовать вывод цен с диапазонами');
		$this->see('Выводить цены для количества');
		$this->see('Включать НДС в цену');
		$this->see('URL, ведущий на страницу с корзиной покупателя');
		$this->see('Название переменной, в которой передается действие');
		$this->see('Название переменной, в которой передается код товара для покупки');
		$this->see('Разрешить указание количества товара');
		$this->see('Название переменной, в которой передается количество товара');
		$this->see('Добавлять в корзину свойства товаров и предложений');
		$this->see('Название переменной, в которой передаются характеристики товара');
		$this->see('Разрешить добавлять в корзину товары, у которых заполнены не все характеристики');
		$this->see('Характеристики товара');
		$this->see('Установить фоновую картинку для шаблона из свойства');
		$this->see('Время кеширования (сек.)');
		$this->see('Кешировать при установленном фильтре');
		$this->see('Учитывать права доступа');
		$this->see('Не подключать js-библиотеки в компоненте');
		$this->see('Включить поддержку ЧПУ');
		$this->see('Правило для обработки');
		$this->see('Включить режим AJAX');
		$this->see('Тип инфоблока');
		$this->see('IBLOCK_ID');
		$this->see('SECTION_ID');
		$this->see('SECTION_CODE');
		$this->see('SECTION_USER_FIELDS');
		$this->see('ELEMENT_SORT_FIELD');
		$this->see('ELEMENT_SORT_ORDER');
		$this->see('ELEMENT_SORT_FIELD2');
		$this->see('ELEMENT_SORT_ORDER2');
		$this->see('FILTER_NAME');
		$this->see('INCLUDE_SUBSECTIONS');
		$this->see('SHOW_ALL_WO_SECTION');
		$this->see('SECTION_URL');
		$this->see('DETAIL_URL');
		$this->see('SECTION_ID_VARIABLE');
		$this->see('SET_TITLE');
		$this->see('SET_BROWSER_TITLE');
		$this->see('BROWSER_TITLE');
		$this->see('SET_META_KEYWORDS');
		$this->see('META_KEYWORDS');
		$this->see('SET_META_DESCRIPTION');
		$this->see('META_DESCRIPTION');
		$this->see('SET_LAST_MODIFIED');
		$this->see('USE_MAIN_ELEMENT_SECTION');
		$this->see('ADD_SECTIONS_CHAIN');
		$this->see('PAGE_ELEMENT_COUNT');
		$this->see('LINE_ELEMENT_COUNT');
		$this->see('PROPERTY_CODE');
		$this->see('OFFERS_FIELD_CODE');
		$this->see('OFFERS_PROPERTY_CODE');
		$this->see('OFFERS_SORT_FIELD');
		$this->see('OFFERS_SORT_ORDER');
		$this->see('OFFERS_SORT_FIELD2');
		$this->see('OFFERS_SORT_ORDER2');
		$this->see('OFFERS_LIMIT');
		$this->see('PRICE_CODE');
		$this->see('USE_PRICE_COUNT');
		$this->see('SHOW_PRICE_COUNT');
		$this->see('PRICE_VAT_INCLUDE');
		$this->see('BASKET_URL');
		$this->see('ACTION_VARIABLE');
		$this->see('PRODUCT_ID_VARIABLE');
		$this->see('USE_PRODUCT_QUANTITY');
		$this->see('PRODUCT_QUANTITY_VARIABLE');
		$this->see('ADD_PROPERTIES_TO_BASKET');
		$this->see('PRODUCT_PROPS_VARIABLE');
		$this->see('PARTIAL_PRODUCT_PROPERTIES');
		$this->see('PRODUCT_PROPERTIES');
		$this->see('BACKGROUND_IMAGE');
		$this->see('CACHE_TIME');
		$this->see('CACHE_FILTER');
		$this->see('CACHE_GROUPS');
		$this->see('DISABLE_INIT_JS_IN_COMPONENT');
		$this->see('SEF_MODE');
		$this->see('SEF_RULE');
		$this->see('AJAX_MODE');
		$this->see('IBLOCK_TYPE');

		// прочие файлы
		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$componenID.'/other_files');
		$this->see('/images/cat_list.gif');

		// шаблоны
		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$componenID.'/templates');
		$this->see('.default');
		$this->see('board');
		$this->see('links');
		$this->see('list');

		// первый шаблон
		$this->click('.default');
		$uriArr = explode('/', $this->currentUri);
		$templateID = $uriArr[count($uriArr) - 1]; // вохможно не лучший способ, но мб единственный
		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$componenID.'/templates/'.$templateID.'/params');
		$this->see('Цветовая тема');
		$this->see('Схема отображения');
		$this->see('Дополнительная картинка основного товара');
		$this->see('Свойство меток товара');
		$this->see('Дополнительные картинки предложения');
		$this->see('Свойства для отбора предложений');
		$this->see('Разрешить оповещения для отсутствующих товаров');
		$this->see('Показывать процент скидки');
		$this->see('Показывать старую цену');
		$this->see('Показывать кнопку добавления в корзину или покупки');
		$this->see('Показывать кнопку продолжения покупок во всплывающих окнах');
		$this->see('Текст кнопки \"Купить\"');
		$this->see('Текст кнопки \"Добавить в корзину\"');
		$this->see('Текст кнопки \"Уведомить о поступлении\"');
		$this->see('Текст кнопки \"Сравнить\"');
		$this->see('Текст кнопки \"Подробнее\"');
		$this->see('Сообщение об отсутствии товара');
		$this->see('TEMPLATE_THEME');
		$this->see('PRODUCT_DISPLAY_MODE');
		$this->see('ADD_PICT_PROP');
		$this->see('LABEL_PROP');
		$this->see('OFFER_ADD_PICT_PROP');
		$this->see('OFFER_TREE_PROPS');
		$this->see('PRODUCT_SUBSCRIPTION');
		$this->see('SHOW_DISCOUNT_PERCENT');
		$this->see('SHOW_OLD_PRICE');
		$this->see('ADD_TO_BASKET_ACTION');
		$this->see('SHOW_CLOSE_POPUP');
		$this->see('MESS_BTN_BUY');
		$this->see('MESS_BTN_ADD_TO_BASKET');
		$this->see('MESS_BTN_SUBSCRIBE');
		$this->see('MESS_BTN_COMPARE');
		$this->see('MESS_BTN_DETAIL');
		$this->see('MESS_NOT_AVAILABLE');

		// остальные файлы шаблона
		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$componenID.'/templates/'.$templateID.'/files');
		$this->see('/functions.php');
		$this->see('/images/arr_left.png');
		$this->see('/images/arr_right.png');
		$this->see('/images/fade_left.png');
		$this->see('/images/fade_right.png');
		$this->see('/images/missing.png');
		$this->see('/images/no_photo.png');
		$this->see('/images/no_prop_value.png');
		$this->see('/images/stick.png');
		$this->see('/images/stick_disc.png');
		$this->see('/images/x2border.png');
		$this->see('/images/x2border_active.png');
		$this->see('/script.map.js');
		$this->see('/script.min.js');
		$this->see('/style.min.css');
		$this->see('/themes/black/images/x2border_active.png');
		$this->see('/themes/black/style.css');
		$this->see('/themes/black/style.min.css');
		$this->see('/themes/blue/images/x2border.png');
		$this->see('/themes/blue/images/x2border_active.png');
		$this->see('/themes/blue/style.css');
		$this->see('/themes/blue/style.min.css');
		$this->see('/themes/green/images/x2border.png');
		$this->see('/themes/green/images/x2border_active.png');
		$this->see('/themes/green/style.css');
		$this->see('/themes/green/style.min.css');
		$this->see('/themes/red/images/x2border_active.png');
		$this->see('/themes/red/style.css');
		$this->see('/themes/red/style.min.css');
		$this->see('/themes/wood/images/x2border.png');
		$this->see('/themes/wood/images/x2border_active.png');
		$this->see('/themes/wood/style.css');
		$this->see('/themes/wood/style.min.css');
		$this->see('/themes/yellow/images/x2border.png');
		$this->see('/themes/yellow/images/x2border_active.png');
		$this->see('/themes/yellow/style.css');
		$this->see('/themes/yellow/style.min.css');
	}
}

?>

