<?php

use App\Models\Modules\Bitrix\BitrixInfoblocks;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;

class BitrixInfoblockFormFilesTest extends TestCase{

	use DatabaseTransactions;

	function createIblockOnForm($module, $params){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');
		$inputs = [];
		if (isset($params['name'])){
			$inputs['NAME'] = $params['name'];
		}
		if (isset($params['code'])){
			$inputs['CODE'] = $params['code'];
		}
		if (isset($params['sort'])){
			$inputs['SORT'] = $params['sort'];
		}

		$this->submitForm('save', $inputs);

		if (isset($params['code'])){
			return BitrixInfoblocks::where('code', $params['code'])->where('module_id', $module->id)->first();
		}

		return true;
	}

	//function getPropsArrayFromFile($module){
	//	$optionsFileContent = $this->disk()->get($module->module_folder.'/options.php');
	//	$optionsArr = vArrParse::parseFromText($optionsFileContent, 'aTabs');
	//
	//	return $optionsArr;
	//}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_infoblock_tab(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
			'name' => 'Ololo',
			'code' => 'trololo'
		]);

		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$module->deleteFolder();

		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		$gottenInstallationFuncCodeParts = explode('$this->createIblock(', $gottenInstallationFuncCode);
		$gottenInstallationFuncCodeArray = vArrParse::parseFromText($gottenInstallationFuncCodeParts[1]);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"     => '$iblockType',
			"VERSION"            => "1",
			"CODE"               => "trololo",
			"NAME"               => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"               => "500",
			"LIST_PAGE_URL"      => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID#",
			"SECTION_PAGE_URL"   => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID#",
			"DETAIL_PAGE_URL"    => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID#",
			"CANONICAL_PAGE_URL" => "",
			"INDEX_SECTION"      => "Y",
			"INDEX_ELEMENT"      => "Y",
			"GROUP_ID"           => [
				2 => "D"
			]
		];

		$this->assertEquals(1, substr_count($gottenInstallationFuncCode, 'createNecessaryIblocks'));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray);
	}

}

?>