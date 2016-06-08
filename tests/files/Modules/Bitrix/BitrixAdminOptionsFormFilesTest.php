<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;

class BitrixAdminOptionsFormFilesTest extends TestCase{

	use DatabaseTransactions;

	function createPropOnForm($module, $rowNumber, $params){
		$this->visit('/my-bitrix/'.$module->id.'/admin_options');
		$inputs = [
			'option_name['.$rowNumber.']' => $params['name'],
			'option_code['.$rowNumber.']' => $params['code'],
			'option_type['.$rowNumber.']' => $params['type'],
		];
		$this->submitForm('save', $inputs);
	}

	function getPropsArrayFromFile($module){
		$optionsFileContent = $this->disk()->get($module->module_folder.'/options.php');
		$vArrParse = new vArrParse();
		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'aTabs');

		return $optionsArr;
	}

	/** @test */
	function smn_can_create_string_option_without_dop_params(){
		// todo проверка лангов
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->createPropOnForm($module, 1, [
			'name' => 'Ololo',
			'code' => 'ololo_from_test',
			'type' => 'text',
		]);

		$optionsArr = $this->getPropsArrayFromFile($module);

		$optionArrExpected = [['ololo_from_test', "Loc::getMessage('".$module->lang_key."_OLOLO_FROM_TEST_TITLE')", '', ['text', 0]]];

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals($optionArrExpected, $optionsArr[0]['OPTIONS']);
	}

	/** @test */
	function smn_can_create_two_string_option_without_dop_params(){
	}

	/** @test */
	function it_wont_create_string_option_without_code(){
	}

	/** @test */
	function smn_can_create_textarea_option_without_dop_params(){
	}

	/** @test */
	function smn_can_create_select_option_without_dop_params(){
	}

	/** @test */
	function smn_can_create_multiselect_option_without_dop_params(){
	}

	/** @test */
	function smn_can_create_checkbox_option_without_dop_params(){
	}

	/** @test */
	function smn_can_create_string_option_with_dop_params(){
	}

	/** @test */
	function smn_can_create_textarea_option_with_dop_params(){
	}

	/** @test */
	function smn_can_create_select_option_with_dop_params(){
	}

	/** @test */
	function smn_can_create_multiselect_option_with_dop_params(){
	}

	/** @test */
	function smn_can_create_checkbox_option_with_dop_params(){
	}
}

?>