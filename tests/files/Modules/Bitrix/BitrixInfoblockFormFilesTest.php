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

		foreach ($params as $code => $val){
			$inputs[$code] = $val;
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

	function getLangFileArray($module, $lang = 'ru'){
		$optionsFileContent = $this->disk()->get($module->module_folder.'/lang/'.$lang.'/install/index.php');
		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'MESS');

		return $optionsArr;
	}

	// берёт сразу все инфоблоки и записывает их в массивы, то есть возврщается не массив устновки, а массив массивов установки
	function getIblockCreationFuncCallParamsArray($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		$gottenInstallationFuncCodeParts = explode('$this->createIblock(', $gottenInstallationFuncCode);
		unset($gottenInstallationFuncCodeParts[0]);
		foreach ($gottenInstallationFuncCodeParts as $gottenInstallationFuncCodePart){
			$answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
		}

		return $answer;
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_infoblock_tab(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
			'VERSION'            => '2',
			'NAME'               => 'Ololo',
			'CODE'               => 'trololo',
			"SORT"               => "555",
			"LIST_PAGE_URL"      => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"   => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"    => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"CANONICAL_PAGE_URL" => "test"
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$optionsLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

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
			"FIELDS"             => Array(
				"ACTIVE"                         => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE"              => Array(
					"DEFAULT_VALUE" => "text",
				),
				"PREVIEW_TEXT_TYPE_ALLOW_CHANGE" => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"DETAIL_TEXT_TYPE"               => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE_ALLOW_CHANGE"  => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"CODE"                           => Array(
					"DEFAULT_VALUE" => Array(
						"TRANS_LEN"   => "100",
						"TRANS_CASE"  => "L",
						"TRANS_SPACE" => "-",
						"TRANS_OTHER" => "-",
						"TRANS_EAT"   => "Y",
					),
				),
			),
			"GROUP_ID"           => [
				2 => "D"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	// todo чекбоксы
	function it_writes_creation_code_with_all_the_params_from_seo_tab(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
			'VERSION'                                                           => '2',
			'NAME'                                                              => 'Ololo',
			'CODE'                                                              => 'trololo',
			"SORT"                                                              => "555",
			"LIST_PAGE_URL"                                                     => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"                                                  => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"                                                   => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"CANONICAL_PAGE_URL"                                                => "test",
			"IPROPERTY_TEMPLATES[SECTION_META_TITLE][TEMPLATE]"                 => "test",
			"IPROPERTY_TEMPLATES[SECTION_META_KEYWORDS][TEMPLATE]"              => "test",
			"IPROPERTY_TEMPLATES[SECTION_META_DESCRIPTION][TEMPLATE]"           => "test",
			"IPROPERTY_TEMPLATES[SECTION_PAGE_TITLE][TEMPLATE]"                 => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_META_TITLE][TEMPLATE]"                 => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_META_KEYWORDS][TEMPLATE]"              => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_META_DESCRIPTION][TEMPLATE]"           => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_PAGE_TITLE][TEMPLATE]"                 => "test",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_ALT][TEMPLATE]"           => "test",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_TITLE][TEMPLATE]"         => "test",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][TEMPLATE]"          => "test",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][SPACE]"             => "test",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"    => "test",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"  => "test",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"   => "test",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][SPACE]"     => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_ALT][TEMPLATE]"   => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_TITLE][TEMPLATE]" => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TEMPLATE]"  => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][SPACE]"     => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"    => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"  => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"   => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][SPACE]"      => "test",

		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$optionsLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"      => '$iblockType',
			"VERSION"             => "2",
			"CODE"                => "trololo",
			"NAME"                => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"                => "555",
			"LIST_PAGE_URL"       => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"    => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"     => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"CANONICAL_PAGE_URL"  => "test",
			"INDEX_SECTION"       => "Y",
			"INDEX_ELEMENT"       => "Y",
			"IPROPERTY_TEMPLATES" => Array(
				"SECTION_META_TITLE"                 => Array(
					"TEMPLATE" => "test",
				),
				"SECTION_META_KEYWORDS"              => Array(
					"TEMPLATE" => "test",
				),
				"SECTION_META_DESCRIPTION"           => Array(
					"TEMPLATE" => "test",
				),
				"SECTION_PAGE_TITLE"                 => Array(
					"TEMPLATE" => "test",
				),
				"ELEMENT_META_TITLE"                 => Array(
					"TEMPLATE" => "test",
				),
				"ELEMENT_META_KEYWORDS"              => Array(
					"TEMPLATE" => "test",
				),
				"ELEMENT_META_DESCRIPTION"           => Array(
					"TEMPLATE" => "test",
				),
				"ELEMENT_PAGE_TITLE"                 => Array(
					"TEMPLATE" => "test",
				),
				"SECTION_PICTURE_FILE_ALT"           => Array(
					"TEMPLATE" => "test",
				),
				"SECTION_PICTURE_FILE_TITLE"         => Array(
					"TEMPLATE" => "test",
				),
				"SECTION_PICTURE_FILE_NAME"          => Array(
					"TEMPLATE" => "test",
					"SPACE"    => "test",
				),
				"SECTION_DETAIL_PICTURE_FILE_ALT"    => Array(
					"TEMPLATE" => "test",
				),
				"SECTION_DETAIL_PICTURE_FILE_TITLE"  => Array(
					"TEMPLATE" => "test",
				),
				"SECTION_DETAIL_PICTURE_FILE_NAME"   => Array(
					"TEMPLATE" => "test",
					"SPACE"    => "test",
				),
				"ELEMENT_PREVIEW_PICTURE_FILE_ALT"   => Array(
					"TEMPLATE" => "test",
				),
				"ELEMENT_PREVIEW_PICTURE_FILE_TITLE" => Array(
					"TEMPLATE" => "test",
				),
				"ELEMENT_PREVIEW_PICTURE_FILE_NAME"  => Array(
					"TEMPLATE" => "test",
					"SPACE"    => "test",
				),
				"ELEMENT_DETAIL_PICTURE_FILE_ALT"    => Array(
					"TEMPLATE" => "test",
				),
				"ELEMENT_DETAIL_PICTURE_FILE_TITLE"  => Array(
					"TEMPLATE" => "test",
				),
				"ELEMENT_DETAIL_PICTURE_FILE_NAME"   => Array(
					"TEMPLATE" => "test",
					"SPACE"    => "test",
				),
			),
			"FIELDS"              => Array(
				"ACTIVE"                         => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE"              => Array(
					"DEFAULT_VALUE" => "text",
				),
				"PREVIEW_TEXT_TYPE_ALLOW_CHANGE" => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"DETAIL_TEXT_TYPE"               => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE_ALLOW_CHANGE"  => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"CODE"                           => Array(
					"DEFAULT_VALUE" => Array(
						"TRANS_LEN"   => "100",
						"TRANS_CASE"  => "L",
						"TRANS_SPACE" => "-",
						"TRANS_OTHER" => "-",
						"TRANS_EAT"   => "Y",
					),
				),
			),
			"GROUP_ID"            => [
				2 => "D"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $optionsLangArr);
	}
}

?>