<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;

class BitrixAdminOptionsFormFilesTest extends BitrixTestCase{
	use DatabaseTransactions;

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		$this->module->deleteFolder();
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$this->createAdminOptionOnForm($this->module, 1, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$this->createAdminOptionOnForm($this->module, 1, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);

		$this->createAdminOptionOnForm($this->module, 1, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'  => 'Ololo',
			'code'  => 'ololo_from_test',
			'type'  => 'text',
			'width' => '10',
		]);

		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'   => 'Ololo',
			'code'   => 'ololo_from_test',
			'type'   => 'textarea',
			'height' => '30',
			'width'  => '20',
		]);

		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'multiselectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'checkbox',
		]);
		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'  => 'Ololo',
			'code'  => 'ololo_from_test',
			'type'  => 'text',
			'width' => '10',
		]);

		$this->createAdminOptionOnForm($this->module, 0, [
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
		$this->createAdminOptionOnForm($this->module, 0, [
			'name'  => 'Ololo',
			'code'  => 'ololo_from_test',
			'type'  => 'text',
			'width' => '10',
		]);

		$this->createAdminOptionOnForm($this->module, 0, [
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
		$option = $this->createAdminOptionOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$this->deleteAdminOptionOnForm($this->module, $option);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE', $optionsLangArr);
	}

	/** @test */
	function smn_can_delete_one_string_option_of_two(){
		$option = $this->createAdminOptionOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$option2 = $this->createAdminOptionOnForm($this->module, 1, [
			'name' => 'Ololo2',
			'code' => 'ololo_from_test2',
			'type' => 'text',
		]);

		$this->deleteAdminOptionOnForm($this->module, $option);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [['ololo_from_test2', "Loc::getMessage('".$this->module->lang_key."_OPTION_OLOLO_FROM_TEST2_TITLE')", '', ['text', 0]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$this->module->lang_key.'_OPTION_OLOLO_FROM_TEST2_TITLE' => 'Ololo2'], $optionsLangArr);
		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE', $optionsLangArr);
	}

	/** @test */
	function smn_can_delete_two_string_options_of_two(){
		$option = $this->createAdminOptionOnForm($this->module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$option2 = $this->createAdminOptionOnForm($this->module, 1, [
			'name' => 'Ololo2',
			'code' => 'ololo_from_test2',
			'type' => 'text',
		]);

		$this->deleteAdminOptionOnForm($this->module, $option);
		$this->deleteAdminOptionOnForm($this->module, $option2);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE', $optionsLangArr);
		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST2_TITLE', $optionsLangArr);
	}

	/** @test */
	function smn_can_delete_select_option_with_one_option(){
		$option = $this->createAdminOptionOnForm($this->module, 0, [
			'name'        => 'Ololo',
			'code'        => 'ololo_from_test',
			'type'        => 'selectbox',
			'vals_key0'   => 'a',
			'vals_value0' => 'b',
		]);
		$this->deleteAdminOptionOnForm($this->module, $option);

		$optionsArr = $this->getPropsArrayFromFile($this->module);
		$optionsLangArr = $this->getLangFileArray($this->module);

		$optionArrExpected = [];

		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE', $optionsLangArr);
		$this->assertArrayNotHasKey($this->module->lang_key.'_OPTION_OLOLO_FROM_TEST_TITLE_'.'A'.'_TITLE', $optionsLangArr);
	}
}

?>