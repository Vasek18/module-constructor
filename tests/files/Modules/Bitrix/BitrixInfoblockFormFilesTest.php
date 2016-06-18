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
		if (isset($params['NAME'])){
			$inputs['NAME'] = $params['NAME'];
		}
		if (isset($params['CODE'])){
			$inputs['CODE'] = $params['CODE'];
		}
		if (isset($params['SORT'])){
			$inputs['SORT'] = $params['SORT'];
		}
		if (isset($params['VERSION'])){
			$inputs['VERSION'] = $params['VERSION'];
		}
		if (isset($params['LIST_PAGE_URL'])){
			$inputs['LIST_PAGE_URL'] = $params['LIST_PAGE_URL'];
		}
		if (isset($params['SECTION_PAGE_URL'])){
			$inputs['SECTION_PAGE_URL'] = $params['SECTION_PAGE_URL'];
		}
		if (isset($params['DETAIL_PAGE_URL'])){
			$inputs['DETAIL_PAGE_URL'] = $params['DETAIL_PAGE_URL'];
		}
		if (isset($params['CANONICAL_PAGE_URL'])){
			$inputs['CANONICAL_PAGE_URL'] = $params['CANONICAL_PAGE_URL'];
		}
		//if (isset($params['INDEX_SECTION'])){ // todo
		//	$inputs['INDEX_SECTION'] = $params['INDEX_SECTION'];
		//}
		//else{
		//	$this->uncheck('INDEX_SECTION');
		//}
		//if (isset($params['INDEX_ELEMENT'])){ // todo
		//	$inputs['INDEX_ELEMENT'] = $params['INDEX_ELEMENT'];
		//}
		//else{
		//	$this->uncheck('INDEX_SECTION');
		//}

		//dd($params);

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
			'VERSION'             => '2',
			'NAME'             => 'Ololo',
			'CODE'             => 'trololo',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"CANONICAL_PAGE_URL"  => "test",
		]);

		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$module->deleteFolder();

		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		$gottenInstallationFuncCodeParts = explode('$this->createIblock(', $gottenInstallationFuncCode);
		$gottenInstallationFuncCodeArray = vArrParse::parseFromText($gottenInstallationFuncCodeParts[1]);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"     => '$iblockType',
			"VERSION"            => "2",
			"CODE"               => "trololo",
			"NAME"               => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"               => "555",
			"LIST_PAGE_URL"      => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"   => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"    => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"CANONICAL_PAGE_URL" => "test",
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