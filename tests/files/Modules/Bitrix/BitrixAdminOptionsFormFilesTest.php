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
		$optionsArr = $vArrParse->parseFromText($optionsFileContent, 'aTabs');

		return $optionsArr;
	}

	/** @test */
	function smn_can_create_option(){
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
}

?>