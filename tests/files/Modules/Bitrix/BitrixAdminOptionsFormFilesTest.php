<?php

use App\Models\Modules\Bitrix\BitrixAdminOptions;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;

class BitrixAdminOptionsFormFilesTest extends TestCase{
	// todo значение по умолчанию
	// todo подстановка чужих айдишников

	use DatabaseTransactions;

	private $module;

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->createBitrixModule();
	}

	function tearDown(){
		parent::tearDown();

		$this->module->deleteFolder();
	}

	function createPropOnForm($module, $rowNumber, $params){
		$this->visit('/my-bitrix/'.$module->id.'/admin_options');
		$inputs = [];
		if (isset($params['name'])){
			$inputs['option_name['.$rowNumber.']'] = $params['name'];
		}
		if (isset($params['code'])){
			$inputs['option_code['.$rowNumber.']'] = $params['code'];
		}
		if (isset($params['type'])){
			$inputs['option_type['.$rowNumber.']'] = $params['type'];
		}
		if (isset($params['width'])){
			$inputs['option_width['.$rowNumber.']'] = $params['width'];
		}
		if (isset($params['height'])){
			$inputs['option_height['.$rowNumber.']'] = $params['height'];
		}
		if (isset($params['vals_key0'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['option_'.($rowNumber).'_vals_key[0]'] = $params['vals_key0'];
		}
		if (isset($params['vals_value0'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['option_'.($rowNumber).'_vals_value[0]'] = $params['vals_value0'];
		}
		if (isset($params['vals_key1'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['option_'.($rowNumber).'_vals_key[1]'] = $params['vals_key1'];
		}
		if (isset($params['vals_value1'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['option_'.($rowNumber).'_vals_value[1]'] = $params['vals_value1'];
		}
		if (isset($params['vals_type'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = $params['vals_type'];
		}
		if (isset($params['iblock'])){
			$inputs['option_'.($rowNumber).'_spec_args[0]'] = $params['iblock'];
		}
		if (isset($params['default_value'])){
			$inputs['default_value['.$rowNumber.']'] = $params['default_value'];
		}
		if (isset($params['vals_default'])){
			$inputs['option_'.($rowNumber).'_vals_default'] = $params['vals_default'];
		}
		//dd($inputs);
		$this->submitForm('save', $inputs);

		if (isset($params['code'])){
			return BitrixAdminOptions::where('code', $params['code'])->first();
		}

		return true;
	}

	function deletePropOnForm($module, $option){
		$this->visit('/my-bitrix/'.$module->id.'/admin_options');
		$this->click('delete_option_'.$option->id);
	}

	function getPropsArrayFromFile($module){
		$optionsFileContent = $this->disk()->get($this->module->module_folder.'/options.php');
		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'aTabs');

		return $optionsArr;
	}

	function getLangFileArray($module, $lang = 'ru'){
		$optionsFileContent = $this->disk()->get($this->module->module_folder.'/lang/'.$lang.'/options.php');
		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'MESS');

		return $optionsArr;
	}

	/** @test */
	function smn_can_create_string_option_without_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['text', 0]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_two_string_options_without_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$this->createPropOnForm($this->module, 1, [
			'name' => 'Тест',
			'code' => 'test_from_test',
			'type' => 'text',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['text', 0]],
			['test_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_TEST_FROM_TEST_TITLE')", '', ['text', 0]]
		];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_TEST_FROM_TEST_TITLE' => 'Тест'], $optionsLangArr);
	}

	/** @test */
	function if_there_are_two_options_with_the_same_code_in_files_will_be_only_last(){
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$this->createPropOnForm($this->module, 1, [
			'name' => 'Тест',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['text', 0]]
		];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertFalse($optionsLangArr[$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE'] == 'Ololo');
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Тест'], $optionsLangArr);
	}

	/** @test */
	function it_wont_create_string_option_without_code(){
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => '',
			'type' => 'text',
		]);

		if (file_exists($this->module->getFolder(true).'/options.php')){
			$optionsArr = $this->getPropsArrayFromFile($this->module);

			$optionArrExpected = [];
			$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		}else{
			$this->assertFalse(file_exists($this->module->getFolder(true).'/options.php')); // прост для наглядности
		}

		if (file_exists($this->module->getFolder(true).'/lang/ru/options.php')){
			$optionsLangArr = $this->getLangFileArray($this->module);
			$this->assertFalse(isset($optionsLangArr[$this->module->lang_key.'__TITLE']));
			$this->assertFalse(isset($optionsLangArr[$this->module->lang_key.'_TITLE']));
		}else{
			$this->assertFalse(file_exists($this->module->getFolder(true).'/lang/ru/options.php')); // прост для наглядности
		}
	}

	/** @test */
	function smn_can_create_textarea_option_without_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'textarea',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['textarea', 0, 0]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_select_option_without_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'selectbox',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array()]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_multiselect_option_without_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'multiselectbox',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['multiselectbox', Array()]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_checkbox_option_without_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'checkbox',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['checkbox', 'Y']]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_string_option_with_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name'          => 'Ololo',
			'code'          => 'ololo_from_test',
			'type'          => 'text',
			'width'         => '10',
			'default_value' => 'test',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_DEFAULT_VALUE')", ['text', 10]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_DEFAULT_VALUE' => 'test'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_textarea_option_with_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name'          => 'Ololo',
			'code'          => 'ololo_from_test',
			'type'          => 'textarea',
			'height'        => '30',
			'width'         => '20',
			'default_value' => 'test',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_DEFAULT_VALUE')", ['textarea', 30, 20]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_DEFAULT_VALUE' => 'test'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_select_option_with_one_options(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array('a' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'A'."_TITLE')")]]];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'A'.'_TITLE' => 'b'], $optionsLangArr);
	}

	/** @test */
	function smn_cannot_create_select_option_with_one_options_where_no_key(){
		$this->createPropOnForm($this->module, 0, [
			'name'      => 'Ololo',
			'code'      => 'ololo_from_test',
			'type'      => 'selectbox',
			'vals_key0' => 'a',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array()]]];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_cannot_create_select_option_with_one_options_where_no_value(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_value0' => 'b',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array()]]];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_select_option_with_two_options(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
			'vals_key1'   => 'c',
			'vals_value1' => 'd',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array('a' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'A'."_TITLE')", 'c' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'C'."_TITLE')")]]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'A'.'_TITLE' => 'b'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'C'.'_TITLE' => 'd'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_select_option_with_two_options_and_one_is_default(){
		$this->createPropOnForm($this->module, 0, [
			'name'         => 'Ololo',
			'code'         => 'ololo_from_test',
			'type'         => 'selectbox',
			'vals_key0'    => 'a',
			'vals_value0'  => 'b',
			'vals_key1'    => 'c',
			'vals_value1'  => 'd',
			'vals_default' => '1',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_DEFAULT_VALUE')", ['selectbox', Array('a' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'A'."_TITLE')", 'c' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'C'."_TITLE')")]]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'A'.'_TITLE' => 'b'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'C'.'_TITLE' => 'd'], $optionsLangArr);
		$this->assertEquals($optionsLangArr[$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_DEFAULT_VALUE'], 'c');
	}

	/** @test */
	function smn_can_create_select_option_with_iblocks_list(){
		$this->createPropOnForm($this->module, 0, [
			'name'      => 'Ololo',
			'code'      => 'ololo_from_test',
			'type'      => 'selectbox',
			'vals_type' => 'iblocks_list',
		]);

		$optionsFileContent = $this->disk()->get($this->module->module_folder.'/options.php');
		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', '$iblocks_list()']]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertNotFalse(strpos($optionsFileContent, '$iblocks_list = function($IBLOCK_TYPE){'));
	}

	/** @test */
	function smn_can_create_select_option_with_iblock_elements_list(){
		$this->createPropOnForm($this->module, 0, [
			'name'      => 'Ololo',
			'code'      => 'ololo_from_test',
			'type'      => 'selectbox',
			'vals_type' => 'iblock_items_list',
		]);

		$optionsFileContent = $this->disk()->get($this->module->module_folder.'/options.php');
		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', '$iblock_items_list()']]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertNotFalse(strpos($optionsFileContent, '$iblock_items_list = function($IBLOCK_ID){'));
	}

	/** @test */
	function smn_can_create_select_option_with_iblock_elements_list_with_param(){
		$this->createPropOnForm($this->module, 0, [
			'name'      => 'Ololo',
			'code'      => 'ololo_from_test',
			'type'      => 'selectbox',
			'vals_type' => 'iblock_items_list',
			'iblock'    => 'COption::GetOptionString("aristov.test", "iblock")',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', '$iblock_items_list(COption::GetOptionString("aristov.test", "iblock"))']]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_select_option_with_iblock_props_list(){
		$this->createPropOnForm($this->module, 0, [
			'name'      => 'Ololo',
			'code'      => 'ololo_from_test',
			'type'      => 'selectbox',
			'vals_type' => 'iblock_props_list',
			'iblock'    => 'COption::GetOptionString("aristov.test", "iblock")',
		]);

		$optionsFileContent = $this->disk()->get($this->module->module_folder.'/options.php');
		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', '$iblock_props_list(COption::GetOptionString("aristov.test", "iblock"))']]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertNotFalse(strpos($optionsFileContent, '$iblock_props_list = function($IBLOCK_ID){'));
	}

	/** @test */
	function smn_can_change_option_at_select_option_with_one_option(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'c',
			'vals_value0' => 'd',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array('c' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'C'."_TITLE')")]]];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'C'.'_TITLE' => 'd'], $optionsLangArr);
	}

	/** @test */
	function smn_can_remove_option_at_select_option_with_one_option(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => '',
			'vals_value0' => 'd',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array()]]];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_remove_option_at_select_option_with_one_option_and_make_it_iblock_elements_list(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$this->createPropOnForm($this->module, 0, [
			'name'      => 'Ololo',
			'code'      => 'ololo_from_test',
			'type'      => 'multiselectbox',
			'vals_type' => 'iblock_items_list',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['multiselectbox', '$iblock_items_list()']]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_add_option_at_select_option_with_already_one_option(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key1'   => 'c',
			'vals_value1' => 'd',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array('a' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'A'."_TITLE')", 'c' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'C'."_TITLE')")]]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */ // todo я не понимаю почему, но этот тест не падает, хотя при ручном тестировании всё ломается
	function if_we_create_select_option_with_options_and_then_create_another_select_option_then_the_first_would_still_keep_its_options(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$this->createPropOnForm($this->module, 1, [
			'name'        => 'Ololo_2',
			'code'        => 'ololo_from_test_2',
			'type'        => 'selectbox',
			'vals_key0'   => 'c',
			'vals_value0' => 'd',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array('a' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'A'."_TITLE')")]],
			['ololo_from_test_2', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_2_TITLE')", '', ['selectbox', Array('c' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_2_".'C'."_TITLE')")]]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'A'.'_TITLE' => 'b'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_2_'.'C'.'_TITLE' => 'd'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_multiselect_option_with_one_options(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'multiselectbox',
			'vals_key0'   => '2',
			'vals_value0' => 'b',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['multiselectbox', Array('2' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'2'."_TITLE')")]]];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'2'.'_TITLE' => 'b'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_multiselect_option_with_two_options(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'multiselectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
			'vals_key1'   => 'g',
			'vals_value1' => 'd',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['multiselectbox', Array('a' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'A'."_TITLE')", 'g' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'G'."_TITLE')")]]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'A'.'_TITLE' => 'b'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'G'.'_TITLE' => 'd'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_multiselect_option_with_two_options_and_one_is_default(){
		$this->createPropOnForm($this->module, 0, [
			'name'         => 'Ololo',
			'code'         => 'ololo_from_test',
			'type'         => 'multiselectbox',
			'vals_key0'    => 'a',
			'vals_value0'  => 'b',
			'vals_key1'    => 'c',
			'vals_value1'  => 'd',
			'vals_default' => '1',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_DEFAULT_VALUE')", ['multiselectbox', Array('a' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'A'."_TITLE')", 'c' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'C'."_TITLE')")]]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'A'.'_TITLE' => 'b'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'C'.'_TITLE' => 'd'], $optionsLangArr);
		$this->assertEquals($optionsLangArr[$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_DEFAULT_VALUE'], 'c');
	}

	/** @test */
	function smn_can_create_multiselect_option_with_iblocks_list(){
		$this->createPropOnForm($this->module, 0, [
			'name'      => 'Ololo',
			'code'      => 'ololo_from_test',
			'type'      => 'multiselectbox',
			'vals_type' => 'iblocks_list',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['multiselectbox', '$iblocks_list()']]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_multiselect_option_with_iblock_elements_list(){
		$this->createPropOnForm($this->module, 0, [
			'name'      => 'Ololo',
			'code'      => 'ololo_from_test',
			'type'      => 'multiselectbox',
			'vals_type' => 'iblock_items_list',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['multiselectbox', '$iblock_items_list()']]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_multiselect_option_with_iblock_props_list(){
		$this->createPropOnForm($this->module, 0, [
			'name'      => 'Ololo',
			'code'      => 'ololo_from_test',
			'type'      => 'multiselectbox',
			'vals_type' => 'iblock_props_list',
			'iblock'    => 'COption::GetOptionString("aristov.test", "iblock")',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['multiselectbox', '$iblock_props_list(COption::GetOptionString("aristov.test", "iblock"))']]
		];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_change_name_of_string_option_with_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name'  => 'Ololo',
			'code'  => 'ololo_from_test',
			'type'  => 'text',
			'width' => '10',
		]);

		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo trololo',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['text', 10]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo trololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_change_name_of_textarea_option_with_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name'   => 'Ololo',
			'code'   => 'ololo_from_test',
			'type'   => 'textarea',
			'height' => '30',
			'width'  => '20',
		]);

		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo2',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['textarea', 30, 20]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo2'], $optionsLangArr);
	}

	/** @test */
	function smn_can_change_name_of_select_option_with_one_options(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololosko',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array('a' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'A'."_TITLE')")]]];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololosko'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'A'.'_TITLE' => 'b'], $optionsLangArr);
	}

	/** @test */
	function smn_can_change_name_of_multiselect_option_with_one_options(){
		$this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'multiselectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololoskos',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['multiselectbox', Array('a' => "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_".'A'."_TITLE')")]]];
		//dd($optionArrExpected);
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololoskos'], $optionsLangArr);
		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_'.'A'.'_TITLE' => 'b'], $optionsLangArr);
	}

	/** @test */
	function smn_can_change_name_of_checkbox_option(){
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'checkbox',
		]);
		$this->createPropOnForm($this->module, 0, [
			'name' => 'Olologa',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['checkbox', 'Y']]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Olologa'], $optionsLangArr);
	}

	/** @test */
	function smn_can_change_width_of_string_option_with_dop_params(){
		$this->createPropOnForm($this->module, 0, [
			'name'  => 'Ololo',
			'code'  => 'ololo_from_test',
			'type'  => 'text',
			'width' => '10',
		]);

		$this->createPropOnForm($this->module, 0, [
			'width' => '20',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['text', 20]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_change_string_option_with_dop_params_to_textarea_option(){
		$this->createPropOnForm($this->module, 0, [
			'name'  => 'Ololo',
			'code'  => 'ololo_from_test',
			'type'  => 'text',
			'width' => '10',
		]);

		$this->createPropOnForm($this->module, 0, [
			'type'   => 'textarea',
			'height' => '30',
		]);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST_TITLE')", '', ['textarea', 30, 10]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_delete_string_option(){
		$option = $this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$this->deletePropOnForm($this->module, $option);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE', $optionsLangArr);
	}

	/** @test */
	function smn_can_delete_one_string_option_of_two(){
		$option = $this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$option2 = $this->createPropOnForm($this->module, 1, [
			'name' => 'Ololo2',
			'code' => 'ololo_from_test2',
			'type' => 'text',
		]);

		$this->deletePropOnForm($this->module, $option);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test2', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST2_TITLE')", '', ['text', 0]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST2_TITLE' => 'Ololo2'], $optionsLangArr);
		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE', $optionsLangArr);
	}

	/** @test */
	function smn_can_delete_two_string_options_of_two(){
		$option = $this->createPropOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$option2 = $this->createPropOnForm($this->module, 1, [
			'name' => 'Ololo2',
			'code' => 'ololo_from_test2',
			'type' => 'text',
		]);

		$this->deletePropOnForm($this->module, $option);
		$this->deletePropOnForm($this->module, $option2);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE', $optionsLangArr);
		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST2_TITLE', $optionsLangArr);
	}

	/** @test */
	function smn_can_delete_select_option_with_one_option(){
		$option = $this->createPropOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);
		$this->deletePropOnForm($this->module, $option);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [];

		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE', $optionsLangArr);
		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE_'.'A'.'_TITLE', $optionsLangArr);
	}
}

?>