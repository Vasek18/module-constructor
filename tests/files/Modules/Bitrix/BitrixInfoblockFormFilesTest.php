<?php

use App\Models\Modules\Bitrix\BitrixInfoblocks;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;
use App\Models\Modules\Bitrix\BitrixIblocksProps;
use App\Models\Modules\Bitrix\BitrixIblocksElements;

// todo чёрт ногу сломит
// todo отключение чекбоксов
class BitrixInfoblockFormFilesTest extends TestCase{

	use DatabaseTransactions;

	function createIblockOnForm($module, $params = []){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');
		$inputs = [];

		if (!isset($params['VERSION'])){
			$params['VERSION'] = '2';
		}
		if (!isset($params['NAME'])){
			$params['NAME'] = 'Ololo';
		}
		if (!isset($params['CODE'])){
			$params['CODE'] = 'trololo';
		}
		if (!isset($params['SORT'])){
			$params["SORT"] = "555";
		}
		if (!isset($params['LIST_PAGE_URL'])){
			$params["LIST_PAGE_URL"] = "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi";
		}
		if (!isset($params['SECTION_PAGE_URL'])){
			$params["SECTION_PAGE_URL"] = "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi";
		}
		if (!isset($params['DETAIL_PAGE_URL'])){
			$params["DETAIL_PAGE_URL"] = "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi";
		}

		foreach ($params as $code => $val){
			$inputs[$code] = $val;
		}

		//dd($params);

		$this->submitForm('save', $inputs);

		if (isset($params['CODE'])){
			return BitrixInfoblocks::where('code', $params['CODE'])->where('module_id', $module->id)->first();
		}

		return true;
	}

	function changeIblockOnForm($module, $iblock, $params = []){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib/'.$iblock->id);
		$inputs = [];

		foreach ($params as $code => $val){
			$inputs[$code] = $val;
		}

		//dd($params);

		$this->submitForm('save', $inputs);

		return $iblock;
	}

	function createIblockElementOnForm($module, $iblock, $params = []){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib/'.$iblock->id.'/create_element');
		$this->submitForm('save', $params);

		if ($params["CODE"]){
			return $prop = BitrixIblocksElements::where('code', $params["CODE"])->where('iblock_id', $iblock->id)->first();
		}

		return false;
	}

	function getLangFileArray($module, $lang = 'ru'){
		$optionsFileContent = $this->disk()->get($module->module_folder.'/lang/'.$lang.'/install/index.php');
		$optionsArr = vArrParse::parseFromText($optionsFileContent, 'MESS');

		return $optionsArr;
	}

	// берёт сразу все инфоблоки и записывает их в массивы, то есть возвращается не массив установки, а массив массивов установки
	// также записывает туда и массивы создания свойств
	function getIblockCreationFuncCallParamsArray($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		// dd($installationFileContent);

		preg_match_all('/(\$this\-\>createIblock\([^\;]+\);)/is', $gottenInstallationFuncCode, $matches);

		foreach ($matches[1] as $gottenInstallationFuncCodePart){
			$answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
		}

		return $answer;
	}

	// берёт сразу все свойства и записывает их в массивы, то есть возвращается не массив установки, а массив массивов установки
	function getIblockPropsCreationFuncCallParamsArray($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		// dd($installationFileContent);

		preg_match_all('/\$this\-\>createIblockProp\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
		// dd($matches[1]);
		foreach ($matches[1] as $gottenInstallationFuncCodePart){
			$answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
		}

		return $answer;
	}

	function getIblockElementsCreationFuncCallParamsArray($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		// dd($installationFileContent);

		preg_match_all('/\$this\-\>createIblockElement\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
		// dd($matches[1]);
		foreach ($matches[1] as $gottenInstallationFuncCodePart){
			$answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
		}

		return $answer;
	}

	function removeIblock($module, $iblock){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/');
		$this->click('delete_iblock_'.$iblock->id);
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_infoblock_tab(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			"CANONICAL_PAGE_URL" => "test",
			"INDEX_SECTION"      => "Y",
			"INDEX_ELEMENT"      => "Y"
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"     => '$iblockType',
			"ACTIVE"             => "Y",
			"LID"                => '$this->getSitesIdsArray()',
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
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"           => [
				2 => "R"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArrayHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');

	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_seo_tab(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			"IPROPERTY_TEMPLATES[SECTION_META_TITLE][TEMPLATE]"                 => "test1",
			"IPROPERTY_TEMPLATES[SECTION_META_KEYWORDS][TEMPLATE]"              => "test2",
			"IPROPERTY_TEMPLATES[SECTION_META_DESCRIPTION][TEMPLATE]"           => "test3",
			"IPROPERTY_TEMPLATES[SECTION_PAGE_TITLE][TEMPLATE]"                 => "test4",
			"IPROPERTY_TEMPLATES[ELEMENT_META_TITLE][TEMPLATE]"                 => "test5",
			"IPROPERTY_TEMPLATES[ELEMENT_META_KEYWORDS][TEMPLATE]"              => "test6",
			"IPROPERTY_TEMPLATES[ELEMENT_META_DESCRIPTION][TEMPLATE]"           => "test7",
			"IPROPERTY_TEMPLATES[ELEMENT_PAGE_TITLE][TEMPLATE]"                 => "test8",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_ALT][TEMPLATE]"           => "test9",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_TITLE][TEMPLATE]"         => "test10",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][TEMPLATE]"          => "test11",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][TRANSLIT]"          => "Y",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][LOWER]"             => "Y",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][SPACE]"             => "_",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"    => "test13",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"  => "test14",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"   => "test15",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][SPACE]"      => "_",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TRANSLIT]"   => "Y",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][LOWER]"      => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_ALT][TEMPLATE]"   => "test17",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_TITLE][TEMPLATE]" => "test18",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TEMPLATE]"  => "test19",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][SPACE]"     => "_",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TRANSLIT]"  => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][LOWER]"     => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"    => "test21",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"  => "test22",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"   => "test23",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][SPACE]"      => "_",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TRANSLIT]"   => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][LOWER]"      => "Y",
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"      => '$iblockType',
			"ACTIVE"              => "Y",
			"LID"                 => '$this->getSitesIdsArray()',
			"VERSION"             => "2",
			"CODE"                => "trololo",
			"NAME"                => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"                => "555",
			"LIST_PAGE_URL"       => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"    => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"     => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"IPROPERTY_TEMPLATES" => Array(
				"SECTION_META_TITLE"                 => "test1",
				"SECTION_META_KEYWORDS"              => "test2",
				"SECTION_META_DESCRIPTION"           => "test3",
				"SECTION_PAGE_TITLE"                 => "test4",
				"ELEMENT_META_TITLE"                 => "test5",
				"ELEMENT_META_KEYWORDS"              => "test6",
				"ELEMENT_META_DESCRIPTION"           => "test7",
				"ELEMENT_PAGE_TITLE"                 => "test8",
				"SECTION_PICTURE_FILE_ALT"           => "test9",
				"SECTION_PICTURE_FILE_TITLE"         => "test10",
				"SECTION_PICTURE_FILE_NAME"          => "test11/lt_",
				"SECTION_DETAIL_PICTURE_FILE_ALT"    => "test13",
				"SECTION_DETAIL_PICTURE_FILE_TITLE"  => "test14",
				"SECTION_DETAIL_PICTURE_FILE_NAME"   => "test15/lt_",
				"ELEMENT_PREVIEW_PICTURE_FILE_ALT"   => "test17",
				"ELEMENT_PREVIEW_PICTURE_FILE_TITLE" => "test18",
				"ELEMENT_PREVIEW_PICTURE_FILE_NAME"  => "test19/lt_",
				"ELEMENT_DETAIL_PICTURE_FILE_ALT"    => "test21",
				"ELEMENT_DETAIL_PICTURE_FILE_TITLE"  => "test22",
				"ELEMENT_DETAIL_PICTURE_FILE_NAME"   => "test23/lt_",
			),
			"FIELDS"              => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"            => [
				2 => "R"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArrayHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_fields_tab(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			"FIELDS[IBLOCK_SECTION][IS_REQUIRED]"                             => "Y",
			"FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]"   => "Y",
			"FIELDS[ACTIVE][IS_REQUIRED]"                                     => "Y",
			"FIELDS[ACTIVE_FROM][IS_REQUIRED]"                                => "Y",
			"FIELDS[ACTIVE_TO][IS_REQUIRED]"                                  => "Y",
			"FIELDS[ACTIVE_TO][DEFAULT_VALUE]"                                => "test",
			"FIELDS[SORT][IS_REQUIRED]"                                       => "Y",
			"FIELDS[NAME][IS_REQUIRED]"                                       => "Y",
			"FIELDS[NAME][DEFAULT_VALUE]"                                     => "test",
			"FIELDS[PREVIEW_PICTURE][IS_REQUIRED]"                            => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"             => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"      => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"      => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]"                   => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WIDTH]"                   => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][HEIGHT]"                  => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"           => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]"                  => "resample",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][COMPRESSION]"             => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"      => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"          => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]"    => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"      => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]"          => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"     => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"    => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]"     => "test",
			"FIELDS[PREVIEW_TEXT_TYPE][IS_REQUIRED]"                          => "Y",
			"FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"           => "Y",
			"FIELDS[PREVIEW_TEXT][DEFAULT_VALUE]"                             => "test",
			"FIELDS[PREVIEW_TEXT][IS_REQUIRED]"                               => "Y",
			"FIELDS[DETAIL_PICTURE][IS_REQUIRED]"                             => "Y",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]"                    => "Y",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]"                    => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]"                   => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"            => "Y",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]"                   => "resample",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]"              => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"       => "Y",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"           => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]"     => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"       => "Y",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]"           => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"      => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"     => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]"      => "test",
			"FIELDS[DETAIL_TEXT_TYPE][IS_REQUIRED]"                           => "Y",
			"FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"            => "Y",
			"FIELDS[DETAIL_TEXT][DEFAULT_VALUE]"                              => "test",
			"FIELDS[DETAIL_TEXT][IS_REQUIRED]"                                => "Y",
			"FIELDS[XML_ID][IS_REQUIRED]"                                     => "Y",
			"FIELDS[CODE][IS_REQUIRED]"                                       => "Y",
			"FIELDS[CODE][DEFAULT_VALUE][UNIQUE]"                             => "Y",
			"FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]"                    => "Y",
			"FIELDS[CODE][DEFAULT_VALUE][TRANS_LEN]"                          => "test",
			"FIELDS[CODE][DEFAULT_VALUE][TRANS_SPACE]"                        => "test",
			"FIELDS[CODE][DEFAULT_VALUE][TRANS_OTHER]"                        => "test",
			"FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]"                          => "Y",
			"FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]"                         => "Y",
			"FIELDS[TAGS][IS_REQUIRED]"                                       => "Y",
			"FIELDS[ACTIVE][DEFAULT_VALUE]"                                   => "N",
			"FIELDS[ACTIVE_FROM][DEFAULT_VALUE]"                              => "=today",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]" => "br",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]" => "br",
			"FIELDS[PREVIEW_TEXT_TYPE][DEFAULT_VALUE]"                        => "html",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"  => "br",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"  => "br",
			"FIELDS[DETAIL_TEXT_TYPE][DEFAULT_VALUE]"                         => "html",
			"FIELDS[CODE][DEFAULT_VALUE][TRANS_CASE]"                         => "U",
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"IBLOCK_SECTION"                 => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => Array(
						"KEEP_IBLOCK_SECTION_ID" => "Y",
					),
				),
				"ACTIVE"                         => Array(
					"DEFAULT_VALUE" => "N",
				),
				"ACTIVE_FROM"                    => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => "=today",
				),
				"ACTIVE_TO"                      => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => "test",
				),
				"SORT"                           => Array(
					"IS_REQUIRED" => "Y",
				),
				"NAME"                           => Array(
					"DEFAULT_VALUE" => "test",
				),
				"PREVIEW_PICTURE"                => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => Array(
						"FROM_DETAIL"             => "Y",
						"DELETE_WITH_DETAIL"      => "Y",
						"UPDATE_WITH_DETAIL"      => "Y",
						"SCALE"                   => "Y",
						"WIDTH"                   => "test",
						"HEIGHT"                  => "test",
						"IGNORE_ERRORS"           => "Y",
						"METHOD"                  => "resample",
						"COMPRESSION"             => "test",
						"USE_WATERMARK_FILE"      => "Y",
						"WATERMARK_FILE"          => "test",
						"WATERMARK_FILE_ALPHA"    => "test",
						"WATERMARK_FILE_POSITION" => "br",
						"USE_WATERMARK_TEXT"      => "Y",
						"WATERMARK_TEXT"          => "test",
						"WATERMARK_TEXT_FONT"     => "test",
						"WATERMARK_TEXT_COLOR"    => "test",
						"WATERMARK_TEXT_SIZE"     => "test",
						"WATERMARK_TEXT_POSITION" => "br",
					),
				),
				"PREVIEW_TEXT_TYPE"              => Array(
					"DEFAULT_VALUE" => "html",
				),
				"PREVIEW_TEXT_TYPE_ALLOW_CHANGE" => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT"                   => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => "test",
				),
				"DETAIL_PICTURE"                 => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => Array(
						"SCALE"                   => "Y",
						"WIDTH"                   => "test",
						"HEIGHT"                  => "test",
						"IGNORE_ERRORS"           => "Y",
						"METHOD"                  => "resample",
						"COMPRESSION"             => "test",
						"USE_WATERMARK_FILE"      => "Y",
						"WATERMARK_FILE"          => "test",
						"WATERMARK_FILE_ALPHA"    => "test",
						"WATERMARK_FILE_POSITION" => "br",
						"USE_WATERMARK_TEXT"      => "Y",
						"WATERMARK_TEXT"          => "test",
						"WATERMARK_TEXT_FONT"     => "test",
						"WATERMARK_TEXT_COLOR"    => "test",
						"WATERMARK_TEXT_SIZE"     => "test",
						"WATERMARK_TEXT_POSITION" => "br",
					),
				),
				"DETAIL_TEXT_TYPE"               => Array(
					"DEFAULT_VALUE" => "html",
				),
				"DETAIL_TEXT_TYPE_ALLOW_CHANGE"  => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"DETAIL_TEXT"                    => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => "test",
				),
				"XML_ID"                         => Array(
					"IS_REQUIRED" => "Y",
				),
				"CODE"                           => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => Array(
						"UNIQUE"          => "Y",
						"TRANSLITERATION" => "Y",
						"TRANS_LEN"       => "test",
						"TRANS_CASE"      => "U",
						"TRANS_SPACE"     => "test",
						"TRANS_OTHER"     => "test",
						"TRANS_EAT"       => "Y",
						"USE_GOOGLE"      => "Y",
					),
				),
				"TAGS"                           => Array(
					"IS_REQUIRED" => "Y",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_string_prop(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
				"properties[NAME][0]" => "Тест",
				"properties[CODE][0]" => "TEST",
			]
		);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];
		$expectedPropCreationCodeArray = [
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "500",
			"CODE"          => "TEST",
			"NAME"          => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0], 'Prop array doesnt match');
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME' => 'Тест'], $installFileLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_google_map_prop(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
				'VERSION'             => '2',
				'NAME'                => 'Ololo',
				'CODE'                => 'trololo',
				"SORT"                => "555",
				"LIST_PAGE_URL"       => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
				"SECTION_PAGE_URL"    => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
				"DETAIL_PAGE_URL"     => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
				"properties[NAME][0]" => "Тест",
				"properties[CODE][0]" => "TEST",
				"properties[TYPE][0]" => "S:map_google",
			]
		);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];
		$expectedPropCreationCodeArray = [
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "500",
			"CODE"          => "TEST",
			"NAME"          => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "map_google",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0], 'Prop array doesnt match');
		$this->assertEquals('Ololo', $installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_NAME']);
		$this->assertEquals('Тест', $installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME']);
	}

	/** @test */
	function it_writes_creation_code_with_required_string_prop(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
				"properties[NAME][0]"        => "Тест",
				"properties[CODE][0]"        => "TEST",
				"properties[IS_REQUIRED][0]" => "Y",
			]
		);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];
		$expectedPropCreationCodeArray = [
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "500",
			"CODE"          => "TEST",
			"NAME"          => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "Y",
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0], 'Prop array doesnt match');
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME' => 'Тест'], $installFileLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_changed_permissions(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			"GROUP_ID" => "Array('2' => 'X')",
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "X"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_test_element(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module);
		$this->createIblockElementOnForm($module, $ib, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];
		$expectedInstallationElementsFuncCodeArray = [
			"IBLOCK_ID" => '$iblockID',
			"ACTIVE"    => "Y",
			"SORT"      => "500",
			"CODE"      => "trololo",
			"NAME"      => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_TROLOLO_NAME")',
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertArrayHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertArrayHasKey($ib->lang_key.'_ELEMENT_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_TROLOLO_NAME'], 'Trololo');
	}

	/** @test */
	function it_writes_creation_code_with_test_element_with_no_props_values_when_there_is_prop(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			"properties[NAME][0]"        => "Тест",
			"properties[CODE][0]"        => "TEST",
			"properties[IS_REQUIRED][0]" => "Y",
		]);
		$this->createIblockElementOnForm($module, $ib, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];
		$expectedInstallationElementsFuncCodeArray = [
			"IBLOCK_ID" => '$iblockID',
			"ACTIVE"    => "Y",
			"SORT"      => "500",
			"CODE"      => "trololo",
			"NAME"      => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_TROLOLO_NAME")',
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertArrayHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertArrayHasKey($ib->lang_key.'_ELEMENT_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_TROLOLO_NAME'], 'Trololo');
	}

	/** @test */
	function it_writes_creation_code_with_test_element_with_string_prop_value(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			"properties[NAME][0]"        => "Тест",
			"properties[CODE][0]"        => "TEST",
			"properties[IS_REQUIRED][0]" => "Y",
		]);
		$this->createIblockElementOnForm($module, $ib, [
			'NAME'        => 'Trololo',
			'CODE'        => 'trololo',
			'props[TEST]' => 'test',
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];
		$expectedInstallationElementsFuncCodeArray = [
			"IBLOCK_ID"       => '$iblockID',
			"ACTIVE"          => "Y",
			"SORT"            => "500",
			"CODE"            => "trololo",
			"NAME"            => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_TROLOLO_NAME")',
			"PROPERTY_VALUES" => Array(
				"TEST" => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_TROLOLO_PROP_TEST_VALUE")',
			)
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertArrayHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertArrayHasKey($ib->lang_key.'_ELEMENT_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_TROLOLO_NAME'], 'Trololo');
		$this->assertArrayHasKey($ib->lang_key.'_ELEMENT_TROLOLO_PROP_TEST_VALUE', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_TROLOLO_PROP_TEST_VALUE'], 'test');
	}

	/** @test */
	function it_writes_creation_code_with_test_element_with_google_map_prop_value(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			"properties[NAME][0]" => "Тест",
			"properties[CODE][0]" => "TEST",
			"properties[TYPE][0]" => "S:map_google",
		]);
		$this->createIblockElementOnForm($module, $ib, [
			'NAME'           => 'Trololo',
			'CODE'           => 'trololo',
			'props[TEST][0]' => '1',
			'props[TEST][1]' => '2',
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();
		// print_r($installFileLangArr);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];
		$expectedInstallationElementsFuncCodeArray = [
			"IBLOCK_ID"       => '$iblockID',
			"ACTIVE"          => "Y",
			"SORT"            => "500",
			"CODE"            => "trololo",
			"NAME"            => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_TROLOLO_NAME")',
			"PROPERTY_VALUES" => Array(
				"TEST" => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_TROLOLO_PROP_TEST_VALUE")',
			)
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertArrayHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertArrayHasKey($ib->lang_key.'_ELEMENT_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_TROLOLO_NAME'], 'Trololo');
		$this->assertArrayHasKey($ib->lang_key.'_ELEMENT_TROLOLO_PROP_TEST_VALUE', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_TROLOLO_PROP_TEST_VALUE'], '1,2');
	}

	/** @test */
	function it_removes_creation_code_when_there_is_no_iblock(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$iblock = $this->createIblockOnForm($module, [
			"properties[NAME][0]" => "Тест",
			"properties[CODE][0]" => "TEST",
			"properties[TYPE][0]" => "S:map_google",
		]);
		$this->removeIblock($module, $iblock);

		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		$gottenDeletionFuncCode = vFuncParse::parseFromText($installationFileContent, 'deleteNecessaryIblocks');

		$this->assertRegExp('/function createNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenInstallationFuncCode);
		$this->assertRegExp('/function deleteNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenDeletionFuncCode);
		$this->assertArrayNotHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertArrayNotHasKey($module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME', $installFileLangArr);
	}

	/** @test */
	function it_removes_creation_code_when_there_is_no_iblock_but_was_with_element(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$iblock = $this->createIblockOnForm($module);
		$this->createIblockElementOnForm($module, $iblock, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/');
		$this->click('delete_iblock_'.$iblock->id);

		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		$gottenDeletionFuncCode = vFuncParse::parseFromText($installationFileContent, 'deleteNecessaryIblocks');

		$this->assertRegExp('/function createNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenInstallationFuncCode);
		$this->assertRegExp('/function deleteNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenDeletionFuncCode);
		$this->assertArrayNotHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertArrayNotHasKey($iblock->lang_key.'_ELEMENT_TROLOLO_NAME', $installFileLangArr);
	}

	/** @test */
	function it_removes_creation_code_when_there_is_no_iblock_but_was_with_element_with_prop(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$iblock = $this->createIblockOnForm($module, [
			"properties[NAME][0]" => "Тест",
			"properties[CODE][0]" => "TEST",
		]);
		$this->createIblockElementOnForm($module, $iblock, [
			'NAME'        => 'Trololo',
			'CODE'        => 'trololo',
			'props[TEST]' => 'test',
		]);
		$this->removeIblock($module, $iblock);

		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		$gottenDeletionFuncCode = vFuncParse::parseFromText($installationFileContent, 'deleteNecessaryIblocks');

		$this->assertRegExp('/function createNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenInstallationFuncCode);
		$this->assertRegExp('/function deleteNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenDeletionFuncCode);
		$this->assertArrayNotHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertArrayNotHasKey($module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME', $installFileLangArr);
		$this->assertArrayNotHasKey($module->lang_key.'_ELEMENT_TROLOLO_NAME', $installFileLangArr);
		$this->assertArrayNotHasKey($iblock->lang_key.'_ELEMENT_TROLOLO_PROP_TEST_VALUE', $installFileLangArr);
	}

	/** @test */
	function it_save_the_creation_code_of_ib_when_the_second_was_deleted(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$iblock = $this->createIblockOnForm($module);

		$iblock2 = $this->createIblockOnForm($module, [
			'NAME' => 'Ololo_i',
			'CODE' => 'trololo_i',
		]);

		$this->removeIblock($module, $iblock2);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
		$this->assertArrayNotHasKey($module->lang_key.'_IBLOCK_TROLOLO_I_NAME', $installFileLangArr);
	}

	/** @test */
	function it_removes_creation_code_of_the_prop(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$iblock = $this->createIblockOnForm($module, [
				"properties[NAME][0]" => "Тест",
				"properties[CODE][0]" => "TEST",
			]
		);
		$prop = BitrixIblocksProps::where('code', 'TEST')->where('iblock_id', $iblock->id)->first();
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib/'.$iblock->id);
		$this->click('delete_prop_'.$prop->id);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals(0, count($gottenInstallationPropsFuncCodeArray));
		$this->assertArrayHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertArrayNotHasKey($module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME', $installFileLangArr);
	}

	/** @test */
	function it_removes_creation_code_of_test_element(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$iblock = $this->createIblockOnForm($module);
		$element = $this->createIblockElementOnForm($module, $iblock, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib/'.$iblock->id);
		$this->click('delete_element_'.$element->id);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals(0, count($gottenInstallationElementsFuncCodeArray));
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
		$this->assertArrayNotHasKey($iblock->lang_key.'_ELEMENT_TROLOLO_NAME', $installFileLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_infoblock_tab_on_existing_iblock(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$iblock = $this->createIblockOnForm($module, [
			"CANONICAL_PAGE_URL" => "test",
			"INDEX_SECTION"      => "Y",
			"INDEX_ELEMENT"      => "Y"
		]);

		$iblock_ = $this->changeIblockOnForm($module, $iblock, [
			'VERSION'            => '1',
			'NAME'               => 'Тест',
			"SORT"               => "300",
			"LIST_PAGE_URL"      => "ololo",
			"SECTION_PAGE_URL"   => "ololo/#SECTION_ID#",
			"DETAIL_PAGE_URL"    => "ololo/#ELEMENT_ID#",
			"CANONICAL_PAGE_URL" => "ololo",
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"     => '$iblockType',
			"ACTIVE"             => "Y",
			"LID"                => '$this->getSitesIdsArray()',
			"VERSION"            => "1",
			"CODE"               => "trololo",
			"NAME"               => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"               => "300",
			"LIST_PAGE_URL"      => "ololo",
			"SECTION_PAGE_URL"   => "ololo/#SECTION_ID#",
			"DETAIL_PAGE_URL"    => "ololo/#ELEMENT_ID#",
			"CANONICAL_PAGE_URL" => "ololo",
			"INDEX_SECTION"      => "Y", // todo
			"INDEX_ELEMENT"      => "Y", // todo
			"FIELDS"             => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"           => [
				2 => "R"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Тест'], $installFileLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_seo_tab_on_existing_iblock(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$iblock = $this->createIblockOnForm($module);
		$iblock_ = $this->changeIblockOnForm($module, $iblock, [
			"IPROPERTY_TEMPLATES[SECTION_META_TITLE][TEMPLATE]"                 => "test1",
			"IPROPERTY_TEMPLATES[SECTION_META_KEYWORDS][TEMPLATE]"              => "test2",
			"IPROPERTY_TEMPLATES[SECTION_META_DESCRIPTION][TEMPLATE]"           => "test3",
			"IPROPERTY_TEMPLATES[SECTION_PAGE_TITLE][TEMPLATE]"                 => "test4",
			"IPROPERTY_TEMPLATES[ELEMENT_META_TITLE][TEMPLATE]"                 => "test5",
			"IPROPERTY_TEMPLATES[ELEMENT_META_KEYWORDS][TEMPLATE]"              => "test6",
			"IPROPERTY_TEMPLATES[ELEMENT_META_DESCRIPTION][TEMPLATE]"           => "test7",
			"IPROPERTY_TEMPLATES[ELEMENT_PAGE_TITLE][TEMPLATE]"                 => "test8",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_ALT][TEMPLATE]"           => "test9",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_TITLE][TEMPLATE]"         => "test10",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][TEMPLATE]"          => "test11",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][TRANSLIT]"          => "Y",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][LOWER]"             => "Y",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][SPACE]"             => "_",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"    => "test13",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"  => "test14",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"   => "test15",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][SPACE]"      => "_",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TRANSLIT]"   => "Y",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][LOWER]"      => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_ALT][TEMPLATE]"   => "test17",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_TITLE][TEMPLATE]" => "test18",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TEMPLATE]"  => "test19",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][SPACE]"     => "_",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TRANSLIT]"  => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][LOWER]"     => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"    => "test21",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"  => "test22",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"   => "test23",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][SPACE]"      => "_",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TRANSLIT]"   => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][LOWER]"      => "Y",

		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"      => '$iblockType',
			"ACTIVE"              => "Y",
			"LID"                 => '$this->getSitesIdsArray()',
			"VERSION"             => "1",
			"CODE"                => "trololo",
			"NAME"                => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"                => "555",
			"LIST_PAGE_URL"       => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"    => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"     => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"IPROPERTY_TEMPLATES" => Array(
				"SECTION_META_TITLE"                 => "test1",
				"SECTION_META_KEYWORDS"              => "test2",
				"SECTION_META_DESCRIPTION"           => "test3",
				"SECTION_PAGE_TITLE"                 => "test4",
				"ELEMENT_META_TITLE"                 => "test5",
				"ELEMENT_META_KEYWORDS"              => "test6",
				"ELEMENT_META_DESCRIPTION"           => "test7",
				"ELEMENT_PAGE_TITLE"                 => "test8",
				"SECTION_PICTURE_FILE_ALT"           => "test9",
				"SECTION_PICTURE_FILE_TITLE"         => "test10",
				"SECTION_PICTURE_FILE_NAME"          => "test11/lt_",
				"SECTION_DETAIL_PICTURE_FILE_ALT"    => "test13",
				"SECTION_DETAIL_PICTURE_FILE_TITLE"  => "test14",
				"SECTION_DETAIL_PICTURE_FILE_NAME"   => "test15/lt_",
				"ELEMENT_PREVIEW_PICTURE_FILE_ALT"   => "test17",
				"ELEMENT_PREVIEW_PICTURE_FILE_TITLE" => "test18",
				"ELEMENT_PREVIEW_PICTURE_FILE_NAME"  => "test19/lt_",
				"ELEMENT_DETAIL_PICTURE_FILE_ALT"    => "test21",
				"ELEMENT_DETAIL_PICTURE_FILE_TITLE"  => "test22",
				"ELEMENT_DETAIL_PICTURE_FILE_NAME"   => "test23/lt_",
			),
			"FIELDS"              => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"            => [
				2 => "R"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArrayHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_fields_tab_on_existing_iblock(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$iblock = $this->createIblockOnForm($module);
		$iblock_ = $this->changeIblockOnForm($module, $iblock, [
			"FIELDS[IBLOCK_SECTION][IS_REQUIRED]"                             => "Y",
			"FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]"   => "Y",
			"FIELDS[ACTIVE][IS_REQUIRED]"                                     => "Y",
			"FIELDS[ACTIVE_FROM][IS_REQUIRED]"                                => "Y",
			"FIELDS[ACTIVE_TO][IS_REQUIRED]"                                  => "Y",
			"FIELDS[ACTIVE_TO][DEFAULT_VALUE]"                                => "test",
			"FIELDS[SORT][IS_REQUIRED]"                                       => "Y",
			"FIELDS[NAME][IS_REQUIRED]"                                       => "Y",
			"FIELDS[NAME][DEFAULT_VALUE]"                                     => "test",
			"FIELDS[PREVIEW_PICTURE][IS_REQUIRED]"                            => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]"             => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]"      => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]"      => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]"                   => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WIDTH]"                   => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][HEIGHT]"                  => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"           => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]"                  => "resample",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][COMPRESSION]"             => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"      => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"          => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]"    => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"      => "Y",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]"          => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"     => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"    => "test",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]"     => "test",
			"FIELDS[PREVIEW_TEXT_TYPE][IS_REQUIRED]"                          => "Y",
			"FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"           => "Y",
			"FIELDS[PREVIEW_TEXT][DEFAULT_VALUE]"                             => "test",
			"FIELDS[PREVIEW_TEXT][IS_REQUIRED]"                               => "Y",
			"FIELDS[DETAIL_PICTURE][IS_REQUIRED]"                             => "Y",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]"                    => "Y",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]"                    => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]"                   => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]"            => "Y",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]"                   => "resample",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]"              => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]"       => "Y",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]"           => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]"     => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]"       => "Y",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]"           => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]"      => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]"     => "test",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]"      => "test",
			"FIELDS[DETAIL_TEXT_TYPE][IS_REQUIRED]"                           => "Y",
			"FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]"            => "Y",
			"FIELDS[DETAIL_TEXT][DEFAULT_VALUE]"                              => "test",
			"FIELDS[DETAIL_TEXT][IS_REQUIRED]"                                => "Y",
			"FIELDS[XML_ID][IS_REQUIRED]"                                     => "Y",
			"FIELDS[CODE][IS_REQUIRED]"                                       => "Y",
			"FIELDS[CODE][DEFAULT_VALUE][UNIQUE]"                             => "Y",
			"FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]"                    => "Y",
			"FIELDS[CODE][DEFAULT_VALUE][TRANS_LEN]"                          => "test",
			"FIELDS[CODE][DEFAULT_VALUE][TRANS_SPACE]"                        => "test",
			"FIELDS[CODE][DEFAULT_VALUE][TRANS_OTHER]"                        => "test",
			"FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]"                          => "Y",
			"FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]"                         => "Y",
			"FIELDS[TAGS][IS_REQUIRED]"                                       => "Y",
			"FIELDS[ACTIVE][DEFAULT_VALUE]"                                   => "N",
			"FIELDS[ACTIVE_FROM][DEFAULT_VALUE]"                              => "=today",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]" => "br",
			"FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]" => "br",
			"FIELDS[PREVIEW_TEXT_TYPE][DEFAULT_VALUE]"                        => "html",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]"  => "br",
			"FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]"  => "br",
			"FIELDS[DETAIL_TEXT_TYPE][DEFAULT_VALUE]"                         => "html",
			"FIELDS[CODE][DEFAULT_VALUE][TRANS_CASE]"                         => "U",

		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "1",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"IBLOCK_SECTION"                 => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => Array(
						"KEEP_IBLOCK_SECTION_ID" => "Y",
					),
				),
				"ACTIVE"                         => Array(
					"DEFAULT_VALUE" => "N",
				),
				"ACTIVE_FROM"                    => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => "=today",
				),
				"ACTIVE_TO"                      => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => "test",
				),
				"SORT"                           => Array(
					"IS_REQUIRED" => "Y",
				),
				"NAME"                           => Array(
					"DEFAULT_VALUE" => "test",
				),
				"PREVIEW_PICTURE"                => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => Array(
						"FROM_DETAIL"             => "Y",
						"DELETE_WITH_DETAIL"      => "Y",
						"UPDATE_WITH_DETAIL"      => "Y",
						"SCALE"                   => "Y",
						"WIDTH"                   => "test",
						"HEIGHT"                  => "test",
						"IGNORE_ERRORS"           => "Y",
						"METHOD"                  => "resample",
						"COMPRESSION"             => "test",
						"USE_WATERMARK_FILE"      => "Y",
						"WATERMARK_FILE"          => "test",
						"WATERMARK_FILE_ALPHA"    => "test",
						"WATERMARK_FILE_POSITION" => "br",
						"USE_WATERMARK_TEXT"      => "Y",
						"WATERMARK_TEXT"          => "test",
						"WATERMARK_TEXT_FONT"     => "test",
						"WATERMARK_TEXT_COLOR"    => "test",
						"WATERMARK_TEXT_SIZE"     => "test",
						"WATERMARK_TEXT_POSITION" => "br",
					),
				),
				"PREVIEW_TEXT_TYPE"              => Array(
					"DEFAULT_VALUE" => "html",
				),
				"PREVIEW_TEXT_TYPE_ALLOW_CHANGE" => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT"                   => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => "test",
				),
				"DETAIL_PICTURE"                 => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => Array(
						"SCALE"                   => "Y",
						"WIDTH"                   => "test",
						"HEIGHT"                  => "test",
						"IGNORE_ERRORS"           => "Y",
						"METHOD"                  => "resample",
						"COMPRESSION"             => "test",
						"USE_WATERMARK_FILE"      => "Y",
						"WATERMARK_FILE"          => "test",
						"WATERMARK_FILE_ALPHA"    => "test",
						"WATERMARK_FILE_POSITION" => "br",
						"USE_WATERMARK_TEXT"      => "Y",
						"WATERMARK_TEXT"          => "test",
						"WATERMARK_TEXT_FONT"     => "test",
						"WATERMARK_TEXT_COLOR"    => "test",
						"WATERMARK_TEXT_SIZE"     => "test",
						"WATERMARK_TEXT_POSITION" => "br",
					),
				),
				"DETAIL_TEXT_TYPE"               => Array(
					"DEFAULT_VALUE" => "html",
				),
				"DETAIL_TEXT_TYPE_ALLOW_CHANGE"  => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"DETAIL_TEXT"                    => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => "test",
				),
				"XML_ID"                         => Array(
					"IS_REQUIRED" => "Y",
				),
				"CODE"                           => Array(
					"IS_REQUIRED"   => "Y",
					"DEFAULT_VALUE" => Array(
						"UNIQUE"          => "Y",
						"TRANSLITERATION" => "Y",
						"TRANS_LEN"       => "test",
						"TRANS_CASE"      => "U",
						"TRANS_SPACE"     => "test",
						"TRANS_OTHER"     => "test",
						"TRANS_EAT"       => "Y",
						"USE_GOOGLE"      => "Y",
					),
				),
				"TAGS"                           => Array(
					"IS_REQUIRED" => "Y",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArrayHasKey($module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
	}

	/** @test */
	function it_writes_creation_code_with_string_prop_on_existing_iblock(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$iblock = $this->createIblockOnForm($module);
		$iblock_ = $this->changeIblockOnForm($module, $iblock, [
				"properties[NAME][0]" => "Тест",
				"properties[CODE][0]" => "TEST",
			]
		);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($module);
		$installFileLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "1",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"FIELDS"           => Array(
				"ACTIVE"            => Array(
					"DEFAULT_VALUE" => "Y",
				),
				"PREVIEW_TEXT_TYPE" => Array(
					"DEFAULT_VALUE" => "text",
				),
				"DETAIL_TEXT_TYPE"  => Array(
					"DEFAULT_VALUE" => "text",
				),
			),
			"GROUP_ID"         => [
				2 => "R"
			]
		];
		$expectedPropCreationCodeArray = [
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "500",
			"CODE"          => "TEST",
			"NAME"          => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0], 'Prop array doesnt match');
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME' => 'Тест'], $installFileLangArr);
	}
}

?>