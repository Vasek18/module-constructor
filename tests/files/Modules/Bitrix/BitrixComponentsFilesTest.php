<?php

use Chumper\Zipper\Zipper;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;

/** @group bitrix_files */
class BitrixComponentsFilesTest extends BitrixTestCase{

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
	function it_creates_standard_component(){
		$component = $this->createComponentOnForm($this->module, [
			'name' => 'Heh',
			'sort' => '334',
			'code' => 'ololo.trololo',
			'desc' => 'HelloWorld',
		]);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$description_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.description.php'), 'MESS');
		$description_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.description.php'), '$arComponentDescription');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertTrue(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'No component folder');
		$this->assertEquals('Heh', $description_lang_arr[$component->lang_key."_COMPONENT_NAME"]);
		$this->assertEquals('HelloWorld', $description_lang_arr[$component->lang_key."_COMPONENT_DESCRIPTION"]);
		$this->assertEquals('334', $description_arr["SORT"]);
	}

	/** @test */
	function it_creates_component_in_another_namespace(){
		$component = $this->createComponentOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '334',
			'code'      => 'ololo.trololo',
			'namespace' => 'vregions',
		]);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$description_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.description.php'), 'MESS');
		$description_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.description.php'), '$arComponentDescription');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertTrue(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'No component folder');
		$this->assertEquals('Heh', $description_lang_arr[$component->lang_key."_COMPONENT_NAME"]);
		$this->assertEquals('334', $description_arr["SORT"]);
	}

	/** @test */
	function it_makes_hello_world_component_instead_of_empty(){
		$component = $this->createComponentOnForm($this->module, [
			'name' => 'Heh',
			'code' => 'ololo.trololo',
		]);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$description_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.description.php'), 'MESS');
		$description_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.description.php'), '$arComponentDescription');
		$component_php = $this->disk()->get($component->getFolder().'/component.php');
		$default_template_php = $this->disk()->get($component->getFolder().'/templates/.default/template.php');

		$this->assertTrue(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'No component folder');
		$this->assertEquals('Heh', $description_lang_arr[$component->lang_key."_COMPONENT_NAME"]);
		$this->assertEquals('500', $description_arr["SORT"]);
		$this->assertEquals(array(
			"ID"   => $this->module->PARTNER_CODE."_".$this->module->code."_components",
			"SORT" => '500',
			"NAME" => 'GetMessage("'.$component->lang_key.'_COMPONENTS_FOLDER_NAME")',
		), $description_arr["PATH"]);
		// dd($component_php);
		$this->assertEquals('<?'."\n".'if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();'."\n"."\n".'$this->IncludeComponentTemplate();'."\n".'?>', $component_php);
		$this->assertEquals('Hello World', $default_template_php);
	}

	/** @test */
	function it_can_delete_component(){
		$component = $this->createComponentOnForm($this->module);

		$this->deleteComponentFromList($component);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$this->assertFalse(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'There is component folder');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_can_delete_component_from_detail(){
		$component = $this->createComponentOnForm($this->module);

		$this->deleteComponentFromDetail($component);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$this->assertFalse(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'There is component folder');

		$this->deleteFolder($this->standartModuleCode);
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

		$description_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.description.php'), 'MESS');
		$description_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.description.php'), '$arComponentDescription');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals(array(
			"NAME"        => 'GetMessage("'.$component->lang_key.'_COMPONENT_NAME")',
			"DESCRIPTION" => 'GetMessage("'.$component->lang_key.'_COMPONENT_DESCRIPTION")',
			"ICON"        => "/images/regions.gif",
			"SORT"        => '500',
			"PATH"        => array(
				"ID"    => "ololo1",
				"SORT"  => '500',
				"NAME"  => 'GetMessage("'.$component->lang_key.'_COMPONENTS_FOLDER_NAME")',
				"CHILD" => array(
					"ID"    => "trololo1",
					"NAME"  => 'GetMessage("'.$component->lang_key.'_COMPONENTS_SUBFOLDER_NAME")',
					"SORT"  => '1000',
					"CHILD" => array(
						"ID"   => "foo1",
						"NAME" => 'GetMessage("'.$component->lang_key.'_COMPONENTS_SUBSUBFOLDER_NAME")',
						"SORT" => '1500',
					),
				),
			),
		), $description_arr);

		$this->assertEquals('ololo2', $description_lang_arr[''.$component->lang_key.'_COMPONENTS_FOLDER_NAME']);
		$this->assertEquals('trololo2', $description_lang_arr[''.$component->lang_key.'_COMPONENTS_SUBFOLDER_NAME']);
		$this->assertEquals('foo2', $description_lang_arr[''.$component->lang_key.'_COMPONENTS_SUBSUBFOLDER_NAME']);
	}

	/** @test */
	function it_can_store_component_php(){
		$component = $this->createComponentOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');

		$this->submitForm('save', [
			'component_php' => '<? echo "Hi"; ?>',
		]);

		$component_php = $this->disk()->get($component->getFolder().'/component.php');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals('<? echo "Hi"; ?>', $component_php);
	}

	/** @test */
	function it_can_store_class_php(){
		$component = $this->createComponentOnForm($this->module);
		$this->payDays(1);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');

		$this->submitForm('save', [
			'class_php' => 'I\'m class',
		]);

		$class_php = $this->disk()->get($component->getFolder().'/class.php');

		$this->assertEquals('I\'m class', $class_php);
	}

	/** @test */
	function if_class_php_or_component_php_is_empty_there_shouldnt_be_file(){
		$component = $this->createComponentOnForm($this->module);
		$this->payDays(1);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');
		// сначала создадим
		$this->submitForm('save', [
			'class_php' => 'I\'m class',
		]);
		$this->submitForm('save', [
			'class_php'     => '',
			'component_php' => '',
		]);

		$this->assertFalse($this->disk()->exists($component->getFolder().'/class.php'));
		$this->assertFalse($this->disk()->exists($component->getFolder().'/component.php'));
	}

	/** @test */
	function it_can_give_class_php_templates(){
		$component = $this->createComponentOnForm($this->module);
		$this->payDays(1);
		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php/get_templates?items_list=items_list');

		$templates = json_decode($this->response->getContent());

		$this->assertEquals('', $templates->component_php);
		$this->see('function generateArOrder');
		$this->see('function generateArFilter');
		$this->see('function generateArSelect');
		$this->see('function getItems');
		$this->see('function executeComponent');
	}

	/** @test */
	function it_can_store_arbitrary_file(){
		$component = $this->createComponentOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/other_files');

		$file = public_path().'/ololo.php';
		file_put_contents($file, '<? echo "Hi"; ?>');

		$this->type('/', 'path');
		$this->attach($file, 'file');
		$this->press('upload');

		$savedFile = $this->disk()->get($component->getFolder().'/ololo.php');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals('<? echo "Hi"; ?>', $savedFile);
	}

	/** @test */
	function it_can_store_arbitrary_file_in_template(){
		$component = $this->createComponentOnForm($this->module);
		$template = $this->createTemplateOnForm($this->module, $component, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);
		$this->storeComponentArbitraryFileOnForm($this->module, $component, '/ololo/', 'ololo.php', '<? echo "Hi"; ?>', $template);

		$this->assertFileNotExists($component->getFolder(true).'/ololo/ololo.php');
		$this->assertFileExists($template->getFolder(true).'/ololo/ololo.php');
		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_can_store_string_param_without_dop_params(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name' => 'Ololo',
			'code' => 'trololo',
			'type' => 'STRING',
		]);

		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"   => "STRING",
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);
		$this->assertEquals('Выберите', $params_lang_arr[$this->module->lang_key.'_SELECT']);
		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
	}

	/** @test */
	function it_can_store_string_param_with_dop_params(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name'     => 'Ololo',
			'code'     => 'trololo',
			'type'     => 'STRING',
			'multiple' => '1',
			'cols'     => '20',
			'default'  => 'vregions',
		]);

		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT"   => "BASE",
			"NAME"     => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"     => "STRING",
			'MULTIPLE' => 'Y',
			'COLS'     => '20',
			'DEFAULT'  => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_DEFAULT")',
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
		$this->assertEquals('vregions', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_DEFAULT']);
	}

	/** @test */
	function it_can_store_select_param_without_dop_params(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name' => 'Ololo',
			'code' => 'trololo',
			'type' => 'LIST',
		]);

		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"   => "LIST",
			"VALUES" => "",
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
	}

	/** @test */
	function it_can_store_select_param_with_array_vals_type_but_without_options(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name'      => 'Ololo',
			'code'      => 'trololo',
			'type'      => 'LIST',
			'vals_type' => 'array',
		]);

		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"   => "LIST",
			"VALUES" => "",
			"VALUES" => Array(),
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
	}

	/** @test */
	function it_can_store_select_param_with_options(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			'type'        => 'LIST',
			'vals_type'   => 'array',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
			'vals_key1'   => 'c',
			'vals_value1' => 'd',
		]);

		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"   => "LIST",
			"VALUES" => Array(
				'a' => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_A_VALUE")',
				'c' => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_C_VALUE")'
			),
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
		$this->assertEquals('b', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_A_VALUE']);
		$this->assertEquals('d', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_C_VALUE']);
	}

	/** @test */
	function it_can_store_iblock_types_list_param(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name'      => 'Ololo',
			'code'      => 'trololo',
			'type'      => 'LIST',
			'vals_type' => 'iblocks_types_list',
		]);

		$paramsFile = $this->disk()->get($component->getFolder().'/.parameters.php');
		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"   => "LIST",
			"VALUES" => '$iblocks_types_list()',
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);
		$this->assertNotFalse(strpos($paramsFile, '$iblocks_types_list = function(){'), 'No helper function');

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
	}

	/** @test */
	function it_can_store_iblocks_list_param(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name'      => 'Ololo',
			'code'      => 'trololo',
			'type'      => 'LIST',
			'vals_type' => 'iblocks_list',
		]);

		$paramsFile = $this->disk()->get($component->getFolder().'/.parameters.php');
		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"   => "LIST",
			"VALUES" => '$iblocks_list()',
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);
		$this->assertNotFalse(strpos($paramsFile, '$iblocks_list = function($IBLOCK_TYPE){'), 'No helper function');

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
	}

	/** @test */
	function it_can_store_iblock_props_list_param(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name'      => 'Ololo',
			'code'      => 'trololo',
			'type'      => 'LIST',
			'vals_type' => 'iblock_props_list',
			'spec_args' => '2',
		]);

		$paramsFile = $this->disk()->get($component->getFolder().'/.parameters.php');
		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"   => "LIST",
			"VALUES" => '$iblock_props_list(2)',
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);
		$this->assertNotFalse(strpos($paramsFile, '$iblock_props_list = function($IBLOCK_ID){'), 'No helper function');

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
	}

	/** @test */
	function it_can_store_iblock_items_list_param(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name'      => 'Ololo',
			'code'      => 'trololo',
			'type'      => 'LIST',
			'vals_type' => 'iblock_items_list',
			'spec_args' => '2',
		]);

		$paramsFile = $this->disk()->get($component->getFolder().'/.parameters.php');
		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"   => "LIST",
			"VALUES" => '$iblock_items_list(2)',
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);
		$this->assertNotFalse(strpos($paramsFile, '$iblock_items_list = function($IBLOCK_ID){'), 'No helper function');

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
	}

	/** @test */
	function it_can_delete_option_from_select(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			'type'        => 'LIST',
			'vals_type'   => 'array',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
			'vals_key1'   => 'c',
			'vals_value1' => 'd',
		]);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			'type'        => 'LIST',
			'vals_type'   => 'array',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
			'vals_key1'   => '',
			'vals_value1' => '',
		]);

		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"   => "LIST",
			"VALUES" => Array(
				'a' => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_A_VALUE")',
			),
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
		$this->assertEquals('b', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_A_VALUE']);
		$this->assertArrayNotHasKey('d', $params_lang_arr);
	}

	/** @test */
	function it_can_delete_param(){
		$component = $this->createComponentOnForm($this->module);

		$param = $this->createComponentParamOnForm($this->module, $component, 0, [
			'name'        => 'Ololo',
			'code'        => 'trololo',
			'type'        => 'LIST',
			'vals_type'   => 'array',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
			'vals_key1'   => 'c',
			'vals_value1' => 'd',
		]);

		$this->deleteComponentParamOnForm($this->module, $component, $param);

		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->assertArrayNotHasKey("TROLOLO", $params_arr["PARAMETERS"]);
		$this->assertArrayNotHasKey($component->lang_key.'_PARAM_TROLOLO_NAME', $params_lang_arr);
		$this->assertArrayNotHasKey($component->lang_key.'_PARAM_TROLOLO_A_VALUE', $params_lang_arr);
	}

	/** @test */
	function it_can_store_string_param_without_dop_params_for_only_one_template(){
		$component = $this->createComponentOnForm($this->module);
		$template = $this->createTemplateOnForm($this->module, $component, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);
		$commonParam = $this->createComponentParamOnForm($this->module, $component, 0, [
			'name' => 'Ololo',
			'code' => 'trololo',
			'type' => 'STRING',
		]);
		$templateParam = $this->createComponentParamOnForm($this->module, $component, 0, [
			'name'        => 'Masha',
			'code'        => 'nasha',
			'type'        => 'STRING',
			'template_id' => $template->id,
		]);

		$params_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.parameters.php'), '$arComponentParameters');
		$params_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.parameters.php'), 'MESS');
		$template_params_arr = vArrParse::parseFromText($this->disk()->get($template->getFolder().'/.parameters.php'), '$arTemplateParameters');
		$template_params_lang_arr = vArrParse::parseFromText($this->disk()->get($template->getFolder().'/lang/ru/.parameters.php'), 'MESS');

		$this->deleteFolder($this->standartModuleCode);

		$paramArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_TROLOLO_NAME")',
			"TYPE"   => "STRING",
		];
		$templateParamArrExpected = [
			"PARENT" => "BASE",
			"NAME"   => 'GetMessage("'.$component->lang_key.'_PARAM_NASHA_NAME")',
			"TYPE"   => "STRING",
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);
		$this->assertArrayNotHasKey("NASHA", $params_arr["PARAMETERS"]);
		$this->assertEquals($templateParamArrExpected, $template_params_arr["NASHA"]);

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
		$this->assertEquals('Masha', $template_params_lang_arr[$component->lang_key.'_PARAM_NASHA_NAME']);
	}

	/** @test */
	function it_can_change_order_of_params(){
		$component = $this->createComponentOnForm($this->module);

		$this->createComponentParamOnForm($this->module, $component, 0, [
			'name' => 'Ololo',
			'code' => 'trololo',
			'type' => 'STRING',
			'sort' => '200',
		]);
		$this->createComponentParamOnForm($this->module, $component, 1, [
			'name' => 'Test',
			'code' => 'test',
			'type' => 'STRING',
			'sort' => '100',
		]);

		$paramsFile = $this->disk()->get($component->getFolder().'/.parameters.php');

		$this->assertRegexp('/"TEST".+"TROLOLO"/is', $paramsFile);
	}

	/** @test */
	function it_can_store_template(){
		$component = $this->createComponentOnForm($this->module);
		$template = $this->createTemplateOnForm($this->module, $component, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);

		$template_php = $this->disk()->get($template->getFolder().'/template.php');
		$style_css = $this->disk()->get($template->getFolder().'/style.css');
		$script_js = $this->disk()->get($template->getFolder().'/script.js');
		$result_modifier_php = $this->disk()->get($template->getFolder().'/result_modifier.php');
		$component_epilog_php = $this->disk()->get($template->getFolder().'/component_epilog.php');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals('<? echo "HW"; ?>', $template_php);
		$this->assertEquals('123', $style_css);
		$this->assertEquals('234', $script_js);
		$this->assertEquals('345', $result_modifier_php);
		$this->assertEquals('<? ?>', $component_epilog_php);
	}

	/** @test */
	function it_can_update_template(){
		$component = $this->createComponentOnForm($this->module);
		$template = $this->createTemplateOnForm($this->module, $component, [
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

		$template_php = $this->disk()->get($template->getFolder().'/template.php');
		$style_css = $this->disk()->get($template->getFolder().'/style.css');
		$script_js = $this->disk()->get($template->getFolder().'/script.js');
		$result_modifier_php = $this->disk()->get($template->getFolder().'/result_modifier.php');
		$component_epilog_php = $this->disk()->get($template->getFolder().'/component_epilog.php');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals('<? echo "HW"; ?>', $template_php);
		$this->assertEquals('123', $style_css);
		$this->assertEquals('234', $script_js);
		$this->assertEquals('345', $result_modifier_php);
		$this->assertEquals('<? ?>', $component_epilog_php);
	}

	/** @test */
	function archive_for_download_contains_folders_starting_with_dot(){
		$component = $this->createComponentOnForm($this->module, [
			'name' => 'Heh',
			'sort' => '334',
			'code' => 'ololo',
			'desc' => 'HelloWorld',
		]);

		// скачиваем
		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$component->id);
		$this->click('download');

		// есть архив
		$archivePath = public_path().'/user_downloads/ololo.zip';
		$this->assertFileExists($archivePath);

		// проверка, что файл в принципе есть
		$zipper = new Zipper;
		$zipper->make($archivePath);
		$template_php = $zipper->getFileContent('ololo\templates\.default\template.php');
		$zipper->close();

		unlink($archivePath);
	}
}

?>