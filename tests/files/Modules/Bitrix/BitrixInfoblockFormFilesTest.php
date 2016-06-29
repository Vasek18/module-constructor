<?php

use App\Models\Modules\Bitrix\BitrixInfoblocks;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;

// todo
// чёрт ногу сломит
class BitrixInfoblockFormFilesTest extends TestCase{

	use DatabaseTransactions;

	function createIblockOnForm($module, $params){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');
		$inputs = [];

		foreach ($params as $code => $val){
			$inputs[$code] = $val;
		}

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

	// берёт сразу все инфоблоки и записывает их в массивы, то есть возвращается не массив установки, а массив массивов установки
	// также записывает туда и массивы создания свойств
	function getIblockCreationFuncCallParamsArray($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		$gottenInstallationFuncCodeParts = preg_split('/(\$this\-\>createIblock\(|\$this\-\>createIblockProp\()/is', $gottenInstallationFuncCode);
		// dd($gottenInstallationFuncCodeParts);
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
			"CANONICAL_PAGE_URL" => "test",
			"INDEX_SECTION"      => "Y",
			"INDEX_ELEMENT"      => "Y"
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$optionsLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"     => '$iblockType',
			"ACTIVE"             => "Y",
			"LID"                => "s1",
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
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
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
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][TRANSLIT]"          => "Y",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][LOWER]"             => "Y",
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][SPACE]"             => "test",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"    => "test",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"  => "test",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"   => "test",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][SPACE]"      => "test",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TRANSLIT]"   => "Y",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][LOWER]"      => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_ALT][TEMPLATE]"   => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_TITLE][TEMPLATE]" => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TEMPLATE]"  => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][SPACE]"     => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TRANSLIT]"  => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][LOWER]"     => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"    => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"  => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"   => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][SPACE]"      => "test",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TRANSLIT]"   => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][LOWER]"      => "Y",

		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$optionsLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"      => '$iblockType',
			"ACTIVE"              => "Y",
			"LID"                 => "s1",
			"VERSION"             => "2",
			"CODE"                => "trololo",
			"NAME"                => 'Loc::getMessage("'.$module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"                => "555",
			"LIST_PAGE_URL"       => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"    => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"     => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
					"LOWER"    => "Y",
					"TRANSLIT" => "Y",
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
					"LOWER"    => "Y",
					"TRANSLIT" => "Y",
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
					"LOWER"    => "Y",
					"TRANSLIT" => "Y",
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
					"LOWER"    => "Y",
					"TRANSLIT" => "Y",
				),
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
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_fields_tab(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
			'VERSION'                                                         => '2',
			'NAME'                                                            => 'Ololo',
			'CODE'                                                            => 'trololo',
			"SORT"                                                            => "555",
			"LIST_PAGE_URL"                                                   => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"                                                => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"                                                 => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$optionsLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => "s1",
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
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $optionsLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_string_prop(){
		$this->signIn();
		$module = $this->createBitrixModule();

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
			]
		);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$optionsLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => "s1",
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

		$this->assertEquals(2, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationFuncCodeArray[1], 'Prop array doesnt match');
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME' => 'Тест'], $optionsLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_google_map_prop(){
		$this->signIn();
		$module = $this->createBitrixModule();

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
		$optionsLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => "s1",
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

		$this->assertEquals(2, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationFuncCodeArray[1], 'Prop array doesnt match');
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME' => 'Тест'], $optionsLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_required_string_prop(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
				'VERSION'                    => '2',
				'NAME'                       => 'Ololo',
				'CODE'                       => 'trololo',
				"SORT"                       => "555",
				"LIST_PAGE_URL"              => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
				"SECTION_PAGE_URL"           => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
				"DETAIL_PAGE_URL"            => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
				"properties[NAME][0]"        => "Тест",
				"properties[CODE][0]"        => "TEST",
				"properties[IS_REQUIRED][0]" => "Y",
			]
		);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$optionsLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => "s1",
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

		$this->assertEquals(2, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationFuncCodeArray[1], 'Prop array doesnt match');
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $optionsLangArr);
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME' => 'Тест'], $optionsLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_changed_permissions(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$ib = $this->createIblockOnForm($module, [
			'VERSION'          => '2',
			'NAME'             => 'Ololo',
			'CODE'             => 'trololo',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi",
			"GROUP_ID"         => "Array('2' => 'X')",
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($module);
		$optionsLangArr = $this->getLangFileArray($module);
		$module->deleteFolder();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => "s1",
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
		$this->assertArraySubset([$module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $optionsLangArr);
	}
}

?>