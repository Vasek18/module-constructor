<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;

class BitrixAdminOptionsFormFilesTest extends TestCase{
	// todo доп параметры у новых селектов
	// todo доп параметры у уже созданных селектов
	// todo доп параметры у уже созданных настроек
	// todo удаление настройки
	// todo удаление опшионов у селекта
	// todo изменение опшионов у селекта
	// todo значение по умолчанию

	use DatabaseTransactions;

	function createPropOnForm($module, $rowNumber, $params){
		$this->visit('/my-bitrix/'.$module->id.'/admin_options');
		$inputs = [
			'option_name['.$rowNumber.']' => $params['name'],
			'option_code['.$rowNumber.']' => $params['code'],
			'option_type['.$rowNumber.']' => $params['type'],
		];
		if (isset($params['width'])){
			$inputs['option_width['.$rowNumber.']'] = $params['width'];
		}
		if (isset($params['height'])){
			$inputs['option_height['.$rowNumber.']'] = $params['height'];
		}
		if (isset($params['vals_key1'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['option_'.($rowNumber).'_vals_key[1]'] = $params['vals_key1'];
		}
		if (isset($params['vals_value1'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['option_'.($rowNumber).'_vals_value[1]'] = $params['vals_value1'];
		}
		//dd($inputs);
		$this->submitForm('save', $inputs);
	}

	function getPropsArrayFromFile($module){
		$optionsFileContent = $this->disk()->get($module->module_folder.'/options.php');
		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'aTabs');

		return $optionsArr;
	}

	function getLangFileArray($module, $lang = 'ru'){
		$optionsFileContent = $this->disk()->get($module->module_folder.'/lang/'.$lang.'/options.php');
		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'MESS');

		return $optionsArr;
	}

	/** @test */
	function smn_can_create_string_option_without_dop_params(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$optionsArr = $this->getPropsArrayFromFile($module);
		$optionsLangArr = $this->getLangFileArray($module);

		$this->deleteFolder($this->standartModuleCode);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['text', 0]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$module->lang_key.'_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_two_string_options_without_dop_params(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$this->createPropOnForm($module, 1, [
			'name' => 'Тест',
			'code' => 'test_from_test',
			'type' => 'text',
		]);

		$optionsArr = $this->getPropsArrayFromFile($module);
		$optionsLangArr = $this->getLangFileArray($module);

		$this->deleteFolder($this->standartModuleCode);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['text', 0]],
			['test_from_test', "Loc::getMessage('".$module->lang_key."_TEST_FROM_TEST_TITLE')", '', ['text', 0]]
		];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$module->lang_key.'_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$module->lang_key.'_TEST_FROM_TEST_TITLE' => 'Тест'], $optionsLangArr);
	}

	/** @test */
	function if_there_are_two_options_with_the_same_code_in_files_will_be_only_last(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$this->createPropOnForm($module, 1, [
			'name' => 'Тест',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$optionsArr = $this->getPropsArrayFromFile($module);
		$optionsLangArr = $this->getLangFileArray($module);

		$this->deleteFolder($this->standartModuleCode);

		$optionArrExpected = [
			['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['text', 0]]
		];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertFalse($optionsLangArr[$module->lang_key.'_OLOLO_FROM_TEST_TITLE'] == 'Ololo');
		$this->assertArraySubset([$module->lang_key.'_OLOLO_FROM_TEST_TITLE' => 'Тест'], $optionsLangArr);
	}

	/** @test */
	function it_wont_create_string_option_without_code(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 0, [
			'name' => 'Ololo',
			'code' => '',
			'type' => 'text',
		]);

		$this->deleteFolder($this->standartModuleCode);

		if (file_exists($module->getFolder(true).'/options.php')){
			$optionsArr = $this->getPropsArrayFromFile($module);

			$optionArrExpected = [];
			$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		}else{
			$this->assertFalse(file_exists($module->getFolder(true).'/options.php')); // прост для наглядности
		}

		if (file_exists($module->getFolder(true).'/lang/ru/options.php')){
			$optionsLangArr = $this->getLangFileArray($module);

			$this->assertFalse(isset($optionsLangArr[$module->lang_key.'__TITLE']));
			$this->assertFalse(isset($optionsLangArr[$module->lang_key.'_TITLE']));
		}else{
			$this->assertFalse(file_exists($module->getFolder(true).'/lang/ru/options.php')); // прост для наглядности
		}
	}

	/** @test */
	function smn_can_create_textarea_option_without_dop_params(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'textarea',
		]);

		$optionsArr = $this->getPropsArrayFromFile($module);
		$optionsLangArr = $this->getLangFileArray($module);

		$this->deleteFolder($this->standartModuleCode);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['textarea', 0, 0]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$module->lang_key.'_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_select_option_without_dop_params(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'selectbox',
		]);

		$optionsArr = $this->getPropsArrayFromFile($module);
		$optionsLangArr = $this->getLangFileArray($module);

		$this->deleteFolder($this->standartModuleCode);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array()]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$module->lang_key.'_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_multiselect_option_without_dop_params(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'multiselectbox',
		]);

		$optionsArr = $this->getPropsArrayFromFile($module);
		$optionsLangArr = $this->getLangFileArray($module);

		$this->deleteFolder($this->standartModuleCode);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['multiselectbox', Array()]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$module->lang_key.'_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_checkbox_option_without_dop_params(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 0, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'checkbox',
		]);

		$optionsArr = $this->getPropsArrayFromFile($module);
		$optionsLangArr = $this->getLangFileArray($module);

		$this->deleteFolder($this->standartModuleCode);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['checkbox', 'Y']]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$module->lang_key.'_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_string_option_with_dop_params(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 0, [
			'name'  => 'Ololo',
			'code'  => 'ololo_from_test',
			'type'  => 'text',
			'width' => '10',
		]);

		$optionsArr = $this->getPropsArrayFromFile($module);
		$optionsLangArr = $this->getLangFileArray($module);

		$this->deleteFolder($this->standartModuleCode);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['text', 10]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$module->lang_key.'_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function smn_can_create_textarea_option_with_dop_params(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 0, [
			'name'   => 'Ololo',
			'code'   => 'ololo_from_test',
			'type'   => 'textarea',
			'height' => '30',
			'width'  => '20',
		]);

		$optionsArr = $this->getPropsArrayFromFile($module);
		$optionsLangArr = $this->getLangFileArray($module);

		$this->deleteFolder($this->standartModuleCode);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['textarea', 30, 20]]];
		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);

		$this->assertArraySubset([$module->lang_key.'_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */ // todo
	function smn_can_create_select_option_with_one_options(){
		//$this->signIn();
		//$module = $this->createBitrixModule();
		//
		//$this->createPropOnForm($module, 0, [
		//	'name'        => 'Ololo',
		//	'code'        => 'ololo_from_test',
		//	'type'        => 'selectbox',
		//	'vals_key1'   => 'a',
		//	'vals_value1' => 'b',
		//]);
		//
		//$optionsArr = $this->getPropsArrayFromFile($module);
		//$optionsLangArr = $this->getLangFileArray($module);
		//
		//$this->deleteFolder($this->standartModuleCode);
		//
		//$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['selectbox', Array('a' => "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE_".'a'."_TITLE')")]]];
		//$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);
		//
		//$this->assertArraySubset([$module->lang_key.'_OLOLO_FROM_TEST_TITLE' => 'Ololo'], $optionsLangArr);
	}

	/** @test */ // todo
	function smn_can_create_multiselect_option_with_dop_params(){

	}
}

?>