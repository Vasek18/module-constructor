<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Helpers\vArrParse;
use App\Models\Modules\Bitrix\BitrixComponentsParams;
use App\Models\Modules\Bitrix\BitrixComponentsTemplates;
use App\Models\Modules\Bitrix\BitrixComponentsArbitraryFiles;

class BitrixComponentsFilesTest extends TestCase{

	use DatabaseTransactions;

	protected $path = '/components';
	private $module;

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->createBitrixModule();
	}

	function tearDown(){
		parent::tearDown();
	}

	function createOnForm($module, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.$this->path.'/create');

		if (!isset($inputs['name'])){
			$inputs['name'] = 'ololo';
		}
		if (!isset($inputs['code'])){
			$inputs['code'] = 'trololo';
		}

		$this->submitForm('create_component', $inputs);

		if (isset($inputs['code'])){
			return BitrixComponent::where('code', $inputs['code'])->where('module_id', $module->id)->first();
		}

		return true;
	}

	function deleteComponentFromList($component){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->click('delete_component_'.$component->id);
	}

	function deleteComponentFromDetail($component){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$component->id);
		$this->click('delete');
	}

	function createComponentParamOnForm($component, $rowNumber, $params){
		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/params');
		$inputs = [];
		if (isset($params['name'])){
			$inputs['param_name['.$rowNumber.']'] = $params['name'];
		}
		if (isset($params['code'])){
			$inputs['param_code['.$rowNumber.']'] = $params['code'];
		}
		if (isset($params['type'])){
			$inputs['param_type['.$rowNumber.']'] = $params['type'];
		}
		if (isset($params['refresh'])){
			$inputs['param_refresh['.$rowNumber.']'] = $params['refresh'];
		}
		if (isset($params['multiple'])){
			$inputs['param_multiple['.$rowNumber.']'] = $params['multiple'];
		}
		if (isset($params['cols'])){
			$inputs['param_cols['.$rowNumber.']'] = $params['cols'];
		}
		if (isset($params['size'])){
			$inputs['param_size['.$rowNumber.']'] = $params['size'];
		}
		if (isset($params['default'])){
			$inputs['param_default['.$rowNumber.']'] = $params['default'];
		}
		if (isset($params['additional_values'])){
			$inputs['param_additional_values['.$rowNumber.']'] = $params['additional_values'];
		}
		if (isset($params['vals_key0'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['param_'.($rowNumber).'_vals_key[0]'] = $params['vals_key0'];
		}
		if (isset($params['vals_value0'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['param_'.($rowNumber).'_vals_value[0]'] = $params['vals_value0'];
		}
		if (isset($params['vals_key1'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['param_'.($rowNumber).'_vals_key[1]'] = $params['vals_key1'];
		}
		if (isset($params['vals_value1'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['param_'.($rowNumber).'_vals_value[1]'] = $params['vals_value1'];
		}
		if (isset($params['vals_type'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = $params['vals_type'];
		}
		if (isset($params['iblock'])){
			$inputs['param_'.($rowNumber).'_spec_args[0]'] = $params['iblock'];
		}
		if (isset($params['template_id'])){
			$inputs['param_template_id['.$rowNumber.']'] = $params['template_id'];
		}
		//dd($inputs);
		$this->submitForm('save', $inputs);

		if (isset($params['code'])){
			return BitrixComponentsParams::where('component_id', $component->id)->where('code', $params['code'])->first();
		}

		return true;
	}

	function createTemplateOnForm($module, $component, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.'/components/'.$component->id.'/templates/create');

		$this->submitForm('save', $inputs);

		if (isset($inputs['code'])){
			return BitrixComponentsTemplates::where('code', $inputs['code'])->where('component_id', $component->id)->first();
		}

		return true;
	}

	function storeArbitraryFileOnForm($module, $component, $path, $name, $content, $template = false){
		if ($template){
			$this->visit('/my-bitrix/'.$module->id.'/components/'.$component->id.'/templates/'.$template->id.'/files');
		}else{
			$this->visit('/my-bitrix/'.$module->id.'/components/'.$component->id.'/other_files');
		}

		$file = public_path().'/'.$name;
		file_put_contents($file, $content);

		$this->type($path, 'path');
		$this->attach($file, 'file');
		$this->press('upload');

		unlink($file);

		return BitrixComponentsArbitraryFiles::where('component_id', $component->id)->where('filename', $name)->where('path', $path)->first();
	}

	/** @test */
	function it_creates_standard_component(){
		$component = $this->createOnForm($this->module, [
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
		$component = $this->createOnForm($this->module, [
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
		$component = $this->createOnForm($this->module, [
			'name' => 'Heh',
			'code' => 'ololo.trololo',
		]);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$description_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.description.php'), 'MESS');
		$description_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.description.php'), '$arComponentDescription');
		$component_php = $this->disk()->get($component->getFolder().'/component.php');
		$default_template_php = $this->disk()->get($component->getFolder().'/templates/.default/template.php');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertTrue(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'No component folder');
		$this->assertEquals('Heh', $description_lang_arr[$component->lang_key."_COMPONENT_NAME"]);
		$this->assertEquals('500', $description_arr["SORT"]);
		$this->assertEquals(array(
			"ID"   => $this->module->PARTNER_CODE."_".$this->module->code."_components",
			"SORT" => '500',
			"NAME" => 'GetMessage("'.$component->lang_key.'_COMPONENTS_FOLDER_NAME")',
		), $description_arr["PATH"]);
		$this->assertEquals('<? $this->IncludeComponentTemplate(); ?>', $component_php);
		$this->assertEquals('Hello World', $default_template_php);
	}

	/** @test */
	function it_can_delete_component(){
		$component = $this->createOnForm($this->module);

		$this->deleteComponentFromList($component);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$this->assertFalse(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'There is component folder');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_can_delete_component_from_detail(){
		$component = $this->createOnForm($this->module);

		$this->deleteComponentFromDetail($component);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$this->assertFalse(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'There is component folder');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_can_store_visual_path_form(){
		$component = $this->createOnForm($this->module);

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
		$component = $this->createOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');

		$this->submitForm('save', [
			'component_php' => '<? echo "Hi"; ?>',
		]);

		$component_php = $this->disk()->get($component->getFolder().'/component.php');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals('<? echo "Hi"; ?>', $component_php);
	}

	/** @test */
	function it_can_store_arbitrary_file(){
		$component = $this->createOnForm($this->module);

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
		$component = $this->createOnForm($this->module);
		$template = $this->createTemplateOnForm($this->module, $component, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);
		$this->storeArbitraryFileOnForm($this->module, $component, '/ololo/', 'ololo.php', '<? echo "Hi"; ?>', $template);

		$this->assertFileNotExists($component->getFolder(true).'/ololo/ololo.php');
		$this->assertFileExists($template->getFolder(true).'/ololo/ololo.php');
		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_can_store_string_param_without_dop_params(){
		$component = $this->createOnForm($this->module);

		$this->createComponentParamOnForm($component, 0, [
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

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
	}

	/** @test */
	function it_can_store_string_param_with_dop_params(){
		$component = $this->createOnForm($this->module);

		$this->createComponentParamOnForm($component, 0, [
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
			'DEFAULT'  => 'vregions',
		];
		$this->assertEquals($paramArrExpected, $params_arr["PARAMETERS"]["TROLOLO"]);

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
	}

	/** @test */
	function it_can_store_select_param_without_dop_params(){
		$component = $this->createOnForm($this->module);

		$this->createComponentParamOnForm($component, 0, [
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
		$component = $this->createOnForm($this->module);

		$this->createComponentParamOnForm($component, 0, [
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
		$component = $this->createOnForm($this->module);

		$this->createComponentParamOnForm($component, 0, [
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
	function it_can_store_string_param_without_dop_params_for_only_one_template(){
		$component = $this->createOnForm($this->module);
		$template = $this->createTemplateOnForm($this->module, $component, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);
		$commonParam = $this->createComponentParamOnForm($component, 0, [
			'name' => 'Ololo',
			'code' => 'trololo',
			'type' => 'STRING',
		]);
		$templateParam = $this->createComponentParamOnForm($component, 0, [
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
		$this->assertEquals($templateParamArrExpected, $template_params_arr["PARAMETERS"]["NASHA"]);

		$this->assertEquals('Ololo', $params_lang_arr[$component->lang_key.'_PARAM_TROLOLO_NAME']);
		$this->assertEquals('Masha', $template_params_lang_arr[$component->lang_key.'_PARAM_NASHA_NAME']);
	}

	/** @test */
	function it_can_store_template(){
		$component = $this->createOnForm($this->module);
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
		$component = $this->createOnForm($this->module);
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
}

?>