<?php

use App\Models\Modules\Bitrix\BitrixIblocksElements;
use App\Models\Modules\Bitrix\BitrixIblocksPropsVals;
use App\Models\Modules\Bitrix\BitrixIblocksSections;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Helpers\vArrParse;
use App\Helpers\vFuncParse;
use App\Models\Modules\Bitrix\BitrixIblocksProps;

// todo чёрт ногу сломит
// todo отключение чекбоксов
/** @group bitrix_files */
class BitrixInfoblockFormFilesTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/data_storage';

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		if ($this->module){
			$this->module->deleteFolder();
		}
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

	function getIblockSectionsCreationFuncCallParamsArray($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		// dd($installationFileContent);

		preg_match_all('/\$this\-\>createIblockSection\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
		// dd($matches[1]);
		foreach ($matches[1] as $gottenInstallationFuncCodePart){
			$answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
		}

		return $answer;
	}

	function getIblockPropsValsCreationFuncCallParamsArray($module){
		$answer = [];
		$installationFileContent = file_get_contents($module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		// dd($installationFileContent);

		preg_match_all('/\$this\-\>createIblockPropVal\(([^\;]+)\);/is', $gottenInstallationFuncCode, $matches);
		// dd($matches[1]);
		foreach ($matches[1] as $gottenInstallationFuncCodePart){
			$answer[] = vArrParse::parseFromText($gottenInstallationFuncCodePart);
		}

		return $answer;
	}

	/** @test */
	function at_first_there_is_no_optional_functions(){
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$this->assertFalse(strpos($installationFileContent, 'function createIblockType'));
		$this->assertFalse(strpos($installationFileContent, 'function removeIblockType'));
		$this->assertFalse(strpos($installationFileContent, 'function createIblock'));
		$this->assertFalse(strpos($installationFileContent, 'function createIblockProp'));
		$this->assertFalse(strpos($installationFileContent, 'function createIblockElement'));
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_infoblock_tab(){
		$ib = $this->createIblockOnForm($this->module, [
			"CANONICAL_PAGE_URL" => "test",
			"INDEX_SECTION"      => "Y",
			"INDEX_ELEMENT"      => "Y"
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"     => '$iblockType',
			"ACTIVE"             => "Y",
			"LID"                => '$this->getSitesIdsArray()',
			"VERSION"            => "2",
			"CODE"               => "trololo",
			"NAME"               => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"               => "555",
			"LIST_PAGE_URL"      => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"   => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');

		// обязательные ланги
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TYPE_NAME_EN'], $this->module->module_full_id);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TYPE_NAME_RU'], $this->module->name);

		$this->assertNotFalse(strpos($installationFileContent, 'function createIblockType'));
		$this->assertNotFalse(strpos($installationFileContent, 'function removeIblockType'));
		$this->assertNotFalse(strpos($installationFileContent, 'function createIblock'));
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_seo_tab(){
		$ib = $this->createIblockOnForm($this->module, [
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

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"      => '$iblockType',
			"ACTIVE"              => "Y",
			"LID"                 => '$this->getSitesIdsArray()',
			"VERSION"             => "2",
			"CODE"                => "trololo",
			"NAME"                => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"                => "555",
			"LIST_PAGE_URL"       => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"     => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_fields_tab(){
		$ib = $this->createIblockOnForm($this->module, [
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

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
	}

	/** @test */
	function it_writes_creation_code_with_string_prop(){
		$ib = $this->createIblockOnForm($this->module, [
				"properties[NAME][0]"                      => "Тест",
				"properties[CODE][0]"                      => "TEST",
				"properties[dop_params][0][HINT]"          => "Подсказка",
				"properties[dop_params][0][DEFAULT_VALUE]" => "ololo",
			]
		);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');
		$prop = BitrixIblocksProps::where('CODE', 'TEST')->first();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
			"HINT"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_HINT")',
			"DEFAULT_VALUE" => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_DEFAULT_VALUE")',
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0], 'Prop array doesnt match');
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME'], 'Тест');
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_HINT'], 'Подсказка');
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_DEFAULT_VALUE'], 'ololo');

		$this->assertNotFalse(strpos($installationFileContent, 'function createIblockProp'));
	}

	/** @test */
	function it_writes_creation_code_with_google_map_prop(){
		$ib = $this->createIblockOnForm($this->module, [
				'VERSION'             => '2',
				'NAME'                => 'Ololo',
				'CODE'                => 'trololo',
				"SORT"                => "555",
				"LIST_PAGE_URL"       => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
				"SECTION_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
				"DETAIL_PAGE_URL"     => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
				"properties[NAME][0]" => "Тест",
				"properties[CODE][0]" => "TEST",
				"properties[TYPE][0]" => "S:map_google",
			]
		);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "map_google",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0], 'Prop array doesnt match');
		$this->assertEquals('Ololo', $installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME']);
		$this->assertEquals('Тест', $installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME']);
	}

	/** @test */
	function it_writes_creation_code_with_list_prop(){
		$ib = $this->createIblockOnForm($this->module, [
				"properties[NAME][0]"              => "Тест",
				"properties[CODE][0]"              => "TEST",
				"properties[TYPE][0]"              => "L",
				"properties[VALUES][0][XML_ID][0]" => "green",
				"properties[VALUES][0][VALUE][0]"  => "Зелёный",
			]
		);

		$installFileLangArr = $this->getLangFileArray($this->module);
		$gottenInstallationPropsValsFuncCodeArray = $this->getIblockPropsValsCreationFuncCallParamsArray($this->module);

		$prop = BitrixIblocksProps::where('CODE', 'TEST')->first();
		$val1 = BitrixIblocksPropsVals::where('value', 'Зелёный')->first();

		$val1Arr = Array(
			"VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_VAL_'.$val1->id.'_VALUE")',
			"DEF"         => "N",
			"XML_ID"      => "green",
			"SORT"        => "500",
			"PROPERTY_ID" => '$prop'.$prop->id."ID",
		);

		$this->assertEquals($val1Arr, $gottenInstallationPropsValsFuncCodeArray[0]);
	}

	/** @test */
	function it_writes_creation_code_with_required_string_prop(){
		$ib = $this->createIblockOnForm($this->module, [
				"properties[NAME][0]"        => "Тест",
				"properties[CODE][0]"        => "TEST",
				"properties[IS_REQUIRED][0]" => "Y",
			]
		);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "Y",
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0], 'Prop array doesnt match');
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME'], 'Тест');
	}

	/** @test */
	function it_writes_creation_code_with_changed_permissions(){
		$ib = $this->createIblockOnForm($this->module, [
			"GROUP_ID" => "Array('2' => 'X')",
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$this->assertArraySubset([$this->module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_test_element(){
		$ib = $this->createIblockOnForm($this->module);
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
			"NAME"      => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Trololo');

		$this->assertNotFalse(strpos($installationFileContent, 'function createIblockElement'));
	}

	/** @test */
	function it_writes_creation_code_with_test_element_with_no_props_values_when_there_is_prop(){
		$ib = $this->createIblockOnForm($this->module, [
			"properties[NAME][0]"        => "Тест",
			"properties[CODE][0]"        => "TEST",
			"properties[IS_REQUIRED][0]" => "Y",
		]);
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
			"NAME"      => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Trololo');
	}

	/** @test */
	function it_writes_creation_code_with_test_element_with_string_prop_value(){
		$ib = $this->createIblockOnForm($this->module, [
			"properties[NAME][0]"        => "Тест",
			"properties[CODE][0]"        => "TEST",
			"properties[IS_REQUIRED][0]" => "Y",
		]);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME'                 => 'Trololo',
			'CODE'                 => 'trololo',
			'props['.$prop->id.']' => 'test',
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
			"NAME"            => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
			"PROPERTY_VALUES" => Array(
				'$prop'.$prop->id.'ID' => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE")',
			)
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Trololo');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE'], 'test');
	}

	/** @test */
	function it_writes_creation_code_with_test_element_with_html_text_prop_value(){
		$ib = $this->createIblockOnForm($this->module, [
			"properties[NAME][0]" => "Тест",
			"properties[CODE][0]" => "TEST",
			"properties[TYPE][0]" => "S:HTML",
		]);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME'                 => 'Trololo',
			'CODE'                 => 'trololo',
			'props['.$prop->id.']' => 'Big text',
		]);

		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationElementsFuncCodeArray = [
			"IBLOCK_ID"       => '$iblockID',
			"ACTIVE"          => "Y",
			"SORT"            => "500",
			"CODE"            => "trololo",
			"NAME"            => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
			"PROPERTY_VALUES" => Array(
				'$prop'.$prop->id.'ID' => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE")',
			)
		];
		$expectedPropCreationCodeArray = [
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "500",
			"CODE"          => "TEST",
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "HTML",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		];

		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME'], 'Тест');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Trololo');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE'], 'Big text');
	}

	/** @test */
	function it_writes_creation_code_with_test_element_with_google_map_prop_value(){
		$ib = $this->createIblockOnForm($this->module, [
			"properties[NAME][0]" => "Тест",
			"properties[CODE][0]" => "TEST",
			"properties[TYPE][0]" => "S:map_google",
		]);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME'                    => 'Trololo',
			'CODE'                    => 'trololo',
			'props['.$prop->id.'][0]' => '1',
			'props['.$prop->id.'][1]' => '2',
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		// print_r($installFileLangArr);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
			"NAME"            => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
			"PROPERTY_VALUES" => Array(
				'$prop'.$prop->id.'ID' => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE")',
			)
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Trololo');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE'], '1,2');
	}

	/** @test */
	function it_writes_creation_code_with_test_element_with_multiple_string_prop_value(){
		$ib = $this->createIblockOnForm($this->module, [
			"properties[NAME][0]"        => "Тест",
			"properties[CODE][0]"        => "TEST",
			"properties[MULTIPLE][0]"    => "Y",
			"properties[IS_REQUIRED][0]" => "Y",
		]);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME'                    => 'Trololo',
			'CODE'                    => 'trololo',
			'props['.$prop->id.'][0]' => 'test',
			'props['.$prop->id.'][1]' => 'ololo',
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
			"NAME"            => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
			"PROPERTY_VALUES" => Array(
				'$prop'.$prop->id.'ID' => Array(
					'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE_0")',
					'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE_1")',
				),
			)
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Trololo');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE_0'], 'test');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE_1'], 'ololo');
	}

	/** @test */
	function it_writes_creation_code_with_test_element_with_multiple_string_prop_but_single_value(){
		$ib = $this->createIblockOnForm($this->module, [
			"properties[NAME][0]"        => "Тест",
			"properties[CODE][0]"        => "TEST",
			"properties[MULTIPLE][0]"    => "Y",
			"properties[IS_REQUIRED][0]" => "Y",
		]);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME'                    => 'Trololo',
			'CODE'                    => 'trololo',
			'props['.$prop->id.'][0]' => 'test',
		]);

		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationElementsFuncCodeArray = [
			"IBLOCK_ID"       => '$iblockID',
			"ACTIVE"          => "Y",
			"SORT"            => "500",
			"CODE"            => "trololo",
			"NAME"            => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
			"PROPERTY_VALUES" => Array(
				'$prop'.$prop->id.'ID' => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE")',
			)
		];

		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Trololo');
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE'], 'test');
	}

	/** @test */
	function it_writes_creation_code_with_test_section(){
		$ib = $this->createIblockOnForm($this->module);
		$section = $this->createIblockSectionOnForm($this->module, $ib, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);

		$gottenInstallationSectionsFuncCodeArray = $this->getIblockSectionsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$expectedInstallationSectionsFuncCodeArray = [
			"IBLOCK_ID" => '$iblockID',
			"ACTIVE"    => "Y",
			"SORT"      => "500",
			"CODE"      => "trololo",
			"NAME"      => 'Loc::getMessage("'.$ib->lang_key.'_SECTION_'.$section->id.'_NAME")',
		];

		$this->assertEquals($expectedInstallationSectionsFuncCodeArray, $gottenInstallationSectionsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$ib->lang_key.'_SECTION_'.$section->id.'_NAME'], 'Trololo');

		$this->assertNotFalse(strpos($installationFileContent, 'function createIblockSection'));
	}

	/** @test */
	function it_removes_creation_code_when_there_is_no_iblock(){
		$iblock = $this->createIblockOnForm($this->module, [
			"properties[NAME][0]" => "Тест",
			"properties[CODE][0]" => "TEST",
			"properties[TYPE][0]" => "S:map_google",
		]);
		$this->removeIblock($this->module, $iblock);

		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');
		$installFileLangArr = $this->getLangFileArray($this->module);

		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		$gottenDeletionFuncCode = vFuncParse::parseFromText($installationFileContent, 'deleteNecessaryIblocks');

		$this->assertRegExp('/function createNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenInstallationFuncCode);
		$this->assertRegExp('/function deleteNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenDeletionFuncCode);
		$this->assertArrayNotHasKey($this->module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertArrayNotHasKey($this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME', $installFileLangArr);

		$this->assertFalse(strpos($installationFileContent, 'function createIblockType'));
		$this->assertFalse(strpos($installationFileContent, 'function removeIblockType'));
		$this->assertFalse(strpos($installationFileContent, 'function createIblock'));
		$this->assertFalse(strpos($installationFileContent, 'function createIblockProp'));
		$this->assertFalse(strpos($installationFileContent, 'function createIblockElement'));
	}

	/** @test */
	function it_removes_creation_code_when_there_is_no_iblock_but_was_with_element(){

		$iblock = $this->createIblockOnForm($this->module);
		$this->createIblockElementOnForm($this->module, $iblock, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);
		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/');
		$this->click('delete_iblock_'.$iblock->id);

		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');
		$installFileLangArr = $this->getLangFileArray($this->module);

		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		$gottenDeletionFuncCode = vFuncParse::parseFromText($installationFileContent, 'deleteNecessaryIblocks');

		$this->assertRegExp('/function createNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenInstallationFuncCode);
		$this->assertRegExp('/function deleteNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenDeletionFuncCode);
		$this->assertArrayNotHasKey($this->module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertArrayNotHasKey($iblock->lang_key.'_ELEMENT_TROLOLO_NAME', $installFileLangArr);
	}

	/** @test */
	function it_removes_creation_code_when_there_is_no_iblock_but_was_with_element_with_prop(){
		$iblock = $this->createIblockOnForm($this->module, [
			"properties[NAME][0]" => "Тест",
			"properties[CODE][0]" => "TEST",
		]);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();
		$this->createIblockElementOnForm($this->module, $iblock, [
			'NAME'                 => 'Trololo',
			'CODE'                 => 'trololo',
			'props['.$prop->id.']' => 'test',
		]);
		$this->removeIblock($this->module, $iblock);

		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');
		$installFileLangArr = $this->getLangFileArray($this->module);

		$gottenInstallationFuncCode = vFuncParse::parseFromText($installationFileContent, 'createNecessaryIblocks');
		$gottenDeletionFuncCode = vFuncParse::parseFromText($installationFileContent, 'deleteNecessaryIblocks');

		$this->assertRegExp('/function createNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenInstallationFuncCode);
		$this->assertRegExp('/function deleteNecessaryIblocks\(\){\s*return true;\s*}/is', $gottenDeletionFuncCode);
		$this->assertArrayNotHasKey($this->module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertArrayNotHasKey($this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME', $installFileLangArr);
		$this->assertArrayNotHasKey($this->module->lang_key.'_ELEMENT_TROLOLO_NAME', $installFileLangArr);
		$this->assertArrayNotHasKey($iblock->lang_key.'_ELEMENT_TROLOLO_PROP_TEST_VALUE', $installFileLangArr);
	}

	/** @test */
	function it_save_the_creation_code_of_ib_when_the_second_was_deleted(){

		$iblock = $this->createIblockOnForm($this->module);

		$iblock2 = $this->createIblockOnForm($this->module, [
			'NAME' => 'Ololo_i',
			'CODE' => 'trololo_i',
		]);

		$this->removeIblock($this->module, $iblock2);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$this->assertArraySubset([$this->module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
		$this->assertArrayNotHasKey($this->module->lang_key.'_IBLOCK_TROLOLO_I_NAME', $installFileLangArr);

		$this->assertNotFalse(strpos($installationFileContent, 'function createIblockType'));
		$this->assertNotFalse(strpos($installationFileContent, 'function removeIblockType'));
		$this->assertNotFalse(strpos($installationFileContent, 'function createIblock'));
	}

	/** @test */
	function it_removes_creation_code_of_the_prop(){
		$iblock = $this->createIblockOnForm($this->module, [
				"properties[NAME][0]" => "Тест",
				"properties[CODE][0]" => "TEST",
			]
		);
		$prop = BitrixIblocksProps::where('code', 'TEST')->where('iblock_id', $iblock->id)->first();
		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id);
		$this->click('delete_prop_'.$prop->id);

		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');
		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$this->assertArrayHasKey($this->module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertArrayNotHasKey($this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_TEST_NAME', $installFileLangArr);
		$this->assertFalse(strpos($installationFileContent, 'function createIblockProp'));
	}

	/** @test */
	function it_removes_creation_code_of_test_element(){
		$iblock = $this->createIblockOnForm($this->module);
		$element = $this->createIblockElementOnForm($this->module, $iblock, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);
		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id);
		$this->click('delete_element_'.$element->id);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$this->assertArraySubset([$this->module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
		$this->assertArrayNotHasKey($iblock->lang_key.'_ELEMENT_TROLOLO_NAME', $installFileLangArr);
		$this->assertFalse(strpos($installationFileContent, 'function createIblockElement'));
	}

	/** @test */
	function it_removes_creation_code_of_test_section(){
		$iblock = $this->createIblockOnForm($this->module);
		$element = $this->createIblockSectionOnForm($this->module, $iblock, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);
		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id);
		$this->click('delete_section_'.$element->id);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationSectionsFuncCodeArray = $this->getIblockSectionsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "2",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$this->assertEquals(0, count($gottenInstallationSectionsFuncCodeArray));
		$this->assertArraySubset([$this->module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Ololo'], $installFileLangArr);
		$this->assertArrayNotHasKey($iblock->lang_key.'_SECTION_TROLOLO_NAME', $installFileLangArr);
		$this->assertFalse(strpos($installationFileContent, 'function createIblockSection'));
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_infoblock_tab_on_existing_iblock(){

		$iblock = $this->createIblockOnForm($this->module, [
			"CANONICAL_PAGE_URL" => "test",
			"INDEX_SECTION"      => "Y",
			"INDEX_ELEMENT"      => "Y"
		]);

		$iblock_ = $this->changeIblockOnForm($this->module, $iblock, [
			'VERSION'            => '1',
			'NAME'               => 'Тест',
			"SORT"               => "300",
			"LIST_PAGE_URL"      => "ololo",
			"SECTION_PAGE_URL"   => "ololo/#SECTION_ID#",
			"DETAIL_PAGE_URL"    => "ololo/#ELEMENT_ID#",
			"CANONICAL_PAGE_URL" => "ololo",
		]);

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"     => '$iblockType',
			"ACTIVE"             => "Y",
			"LID"                => '$this->getSitesIdsArray()',
			"VERSION"            => "1",
			"CODE"               => "trololo",
			"NAME"               => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
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
		$this->assertArraySubset([$this->module->lang_key.'_IBLOCK_TROLOLO_NAME' => 'Тест'], $installFileLangArr);
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_seo_tab_on_existing_iblock(){

		$iblock = $this->createIblockOnForm($this->module);
		$iblock_ = $this->changeIblockOnForm($this->module, $iblock, [
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

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"      => '$iblockType',
			"ACTIVE"              => "Y",
			"LID"                 => '$this->getSitesIdsArray()',
			"VERSION"             => "1",
			"CODE"                => "trololo",
			"NAME"                => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"                => "555",
			"LIST_PAGE_URL"       => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"     => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
	}

	/** @test */
	function it_writes_creation_code_with_all_the_params_from_fields_tab_on_existing_iblock(){

		$iblock = $this->createIblockOnForm($this->module);
		$iblock_ = $this->changeIblockOnForm($this->module, $iblock, [
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

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "1",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
		$this->assertArrayHasKey($this->module->lang_key.'_IBLOCK_TROLOLO_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
	}

	/** @test */
	function it_writes_creation_code_with_string_prop_on_existing_iblock(){

		$iblock = $this->createIblockOnForm($this->module);
		$iblock_ = $this->changeIblockOnForm($this->module, $iblock, [
				"properties[NAME][0]" => "Тест",
				"properties[CODE][0]" => "TEST",
			]
		);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"   => '$iblockType',
			"ACTIVE"           => "Y",
			"LID"              => '$this->getSitesIdsArray()',
			"VERSION"          => "1",
			"CODE"             => "trololo",
			"NAME"             => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_NAME")',
			"SORT"             => "555",
			"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
			"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
			"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
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
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0], 'Prop array doesnt match');
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_NAME'], 'Ololo');
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME'], 'Тест');
	}

	/** @test */
	function it_imports_main_iblock_params_from_xml(){
		$file = public_path().'/for_tests/test_iblock.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$gottenInstallationFuncCodeArray = $this->getIblockCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedInstallationFuncCodeArray = [
			"IBLOCK_TYPE_ID"     => '$iblockType',
			"ACTIVE"             => "Y",
			"LID"                => '$this->getSitesIdsArray()',
			// "VERSION"            => "1",
			"CODE"               => "test",
			"NAME"               => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_NAME")',
			"SORT"               => "500",
			"LIST_PAGE_URL"      => "#SITE_DIR#/test/",
			"SECTION_PAGE_URL"   => "#SITE_DIR#/test/#SECTION_CODE_PATH#/",
			"DETAIL_PAGE_URL"    => "#SITE_DIR#/test/#SECTION_CODE_PATH#/#CODE#.html",
			"CANONICAL_PAGE_URL" => 'canon"', // todo
			// "INDEX_SECTION"      => "Y",
			// "INDEX_ELEMENT"      => "Y",
			// "FIELDS"             => Array(
			// 	"ACTIVE"            => Array(
			// 		"DEFAULT_VALUE" => "Y",
			// 	),
			// 	"PREVIEW_TEXT_TYPE" => Array(
			// 		"DEFAULT_VALUE" => "text",
			// 	),
			// 	"DETAIL_TEXT_TYPE"  => Array(
			// 		"DEFAULT_VALUE" => "text",
			// 	),
			// ),
			// "GROUP_ID"           => [
			// 	2 => "R"
			// ]
		];

		$this->assertEquals(1, count($gottenInstallationFuncCodeArray));
		$this->assertEquals($expectedInstallationFuncCodeArray, $gottenInstallationFuncCodeArray[0]);
		$this->assertArrayHasKey($this->module->lang_key.'_IBLOCK_TEST_NAME', $installFileLangArr);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TEST_NAME'], 'Тест');
	}

	/** @test */
	function it_imports_iblock_properties_from_xml(){
		$file = public_path().'/for_tests/test_iblock.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$prop = BitrixIblocksProps::where('code', 'TESTOVOE_SVOISVTO')->first();
		$prop2 = BitrixIblocksProps::where('code', 'ANOTHER_ONE')->first();
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$expectedPropCreationCodeArray = [
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "400",
			"CODE"          => "TESTOVOE_SVOISVTO",
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		];
		$expectedPropCreationCodeArray2 = [
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "500",
			"CODE"          => "ANOTHER_ONE",
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop2->id.'_NAME")',
			"PROPERTY_TYPE" => "E",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "Y",
			"IS_REQUIRED"   => "Y",
		];

		$this->assertEquals($expectedPropCreationCodeArray, $gottenInstallationPropsFuncCodeArray[0], 'Prop array doesnt match');
		$this->assertArraySubset([$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_NAME' => 'Тестовое свойство'], $installFileLangArr);
		$this->assertEquals($expectedPropCreationCodeArray2, $gottenInstallationPropsFuncCodeArray[1], 'Prop array doesnt match');
		$this->assertArraySubset([$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop2->id.'_NAME' => 'Ещё свойство'], $installFileLangArr);
	}

	/** @test */
	function it_imports_iblock_elements_from_xml(){
		$file = public_path().'/for_tests/test_iblock.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$iblock = BitrixInfoblocks::where('code', "test")->first();
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$element = BitrixIblocksElements::where('name', 'Тест')->first();
		$element2 = BitrixIblocksElements::where('code', 'ololo')->first();
		$prop = BitrixIblocksProps::where('code', 'TESTOVOE_SVOISVTO')->first();
		$prop2 = BitrixIblocksProps::where('code', 'ANOTHER_ONE')->first();

		$expectedInstallationElementsFuncCodeArray = [
			"IBLOCK_ID"       => '$iblockID',
			"ACTIVE"          => "Y",
			"SORT"            => "400",
			"CODE"            => "",
			"NAME"            => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
			"PROPERTY_VALUES" => Array(
				'$prop'.$prop->id.'ID'  => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE")',
				'$prop'.$prop2->id.'ID' => Array(
					'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop2->id.'_VALUE_0")',
					'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop2->id.'_VALUE_1")',
				)
			)
		];
		$expectedInstallationElementsFuncCodeArray2 = [
			"IBLOCK_ID"       => '$iblockID',
			"ACTIVE"          => "Y",
			"SORT"            => "500",
			"CODE"            => "ololo",
			"NAME"            => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element2->id.'_NAME")',
			"PROPERTY_VALUES" => Array(
				'$prop'.$prop2->id.'ID' => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element2->id.'_PROP_'.$prop2->id.'_VALUE")',
			)
		];

		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$iblock->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Тест');
		$this->assertEquals($installFileLangArr[$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE'], 'Ололо');

		$this->assertEquals($expectedInstallationElementsFuncCodeArray2, $gottenInstallationElementsFuncCodeArray[1]);
		$this->assertEquals($installFileLangArr[$iblock->lang_key.'_ELEMENT_'.$element2->id.'_PROP_'.$prop2->id.'_VALUE'], '447');
	}

	/** @test
	 * тест на несколько категорий находится в тесте интерфейса
	 */
	function it_imports_iblock_section_with_element_in_it_from_xml(){
		$file = public_path().'/for_tests/test_iblock_with_section.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$iblock = BitrixInfoblocks::where('code', "test")->first();
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$gottenInstallationSectionsFuncCodeArray = $this->getIblockSectionsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$element = BitrixIblocksElements::where('code', 'vlogennyy_element')->first();
		$section = BitrixIblocksSections::where('code', 'testovyy_razdel')->first();
		$prop = BitrixIblocksProps::where('code', 'ANOTHER_ONE')->first();

		$expectedInstallationElementFuncCodeArray = [
			"IBLOCK_ID"         => '$iblockID',
			"ACTIVE"            => "Y",
			"SORT"              => "500",
			"CODE"              => "vlogennyy_element",
			"NAME"              => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
			"IBLOCK_SECTION_ID" => '$section'.$section->id.'ID',
			"PROPERTY_VALUES"   => Array(
				'$prop'.$prop->id.'ID' => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_PROP_'.$prop->id.'_VALUE")',
			)
		];
		$expectedInstallationSectionFuncCodeArray = [
			"IBLOCK_ID" => '$iblockID',
			"ACTIVE"    => "Y",
			"SORT"      => "500",
			"CODE"      => "testovyy_razdel",
			"NAME"      => 'Loc::getMessage("'.$iblock->lang_key.'_SECTION_'.$section->id.'_NAME")',
		];

		$this->assertEquals($expectedInstallationElementFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$iblock->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Вложенный элемент');

		$this->assertEquals($expectedInstallationSectionFuncCodeArray, $gottenInstallationSectionsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$iblock->lang_key.'_SECTION_'.$section->id.'_NAME'], 'Тестовый раздел');
	}

	/** @test */
	function it_imports_empty_iblock_from_xml(){
		$file = public_path().'/for_tests/test_empty_iblock.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$gottenInstallationSectionsFuncCodeArray = $this->getIblockSectionsCreationFuncCallParamsArray($this->module);

		$this->assertEquals(0, count($gottenInstallationElementsFuncCodeArray));
		$this->assertEquals(0, count($gottenInstallationSectionsFuncCodeArray));
	}

	/** @test */
	function it_imports_list_prop_from_xml(){
		$file = public_path().'/for_tests/test_iblock_with_list_prop.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$gottenInstallationPropsValsFuncCodeArray = $this->getIblockPropsValsCreationFuncCallParamsArray($this->module);

		$prop = BitrixIblocksProps::where('code', 'COLOR')->first();
		$val1 = BitrixIblocksPropsVals::where('value', 'Зелёный')->first();
		$val2 = BitrixIblocksPropsVals::where('value', 'Любви')->first();
		$val3 = BitrixIblocksPropsVals::where('value', 'Синий')->first();
		$element = \App\Models\Modules\Bitrix\BitrixIblocksElements::where('name', 'Трава')->first();
		$element2 = \App\Models\Modules\Bitrix\BitrixIblocksElements::where('name', 'Твоя мамка')->first();

		$propArray = Array(
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "500",
			"CODE"          => "COLOR",
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_NAME")',
			"PROPERTY_TYPE" => "L",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		);

		$val1Arr = Array(
			"VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_VAL_'.$val1->id.'_VALUE")',
			"DEF"         => "Y",
			"SORT"        => "100",
			"PROPERTY_ID" => '$prop'.$prop->id."ID",
		);
		$val2Arr = Array(
			"VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_VAL_'.$val2->id.'_VALUE")',
			"DEF"         => "N",
			"SORT"        => "200",
			"PROPERTY_ID" => '$prop'.$prop->id."ID",
		);
		$val3Arr = Array(
			"VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_PARAM_'.$prop->id.'_VAL_'.$val3->id.'_VALUE")',
			"DEF"         => "N",
			"SORT"        => "300",
			"PROPERTY_ID" => '$prop'.$prop->id."ID",
		);

		$elArr1 = Array(
			"IBLOCK_ID"       => '$iblockID',
			"ACTIVE"          => "Y",
			"SORT"            => "500",
			"CODE"            => "",
			"NAME"            => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_ELEMENT_'.$element->id.'_NAME")',
			"PROPERTY_VALUES" => Array(
				'$prop'.$prop->id.'ID' => '$val'.$val1->id.'ID',
			),
		);

		$elArr2 = Array(
			"IBLOCK_ID"       => '$iblockID',
			"ACTIVE"          => "Y",
			"SORT"            => "500",
			"CODE"            => "",
			"NAME"            => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TEST_ELEMENT_'.$element2->id.'_NAME")',
			"PROPERTY_VALUES" => Array(
				'$prop'.$prop->id.'ID' => '$val'.$val2->id.'ID',
			),
		);

		$this->assertEquals($propArray, $gottenInstallationPropsFuncCodeArray[0]);
		$this->assertEquals($val1Arr, $gottenInstallationPropsValsFuncCodeArray[0]);
		$this->assertEquals($val2Arr, $gottenInstallationPropsValsFuncCodeArray[1]);
		$this->assertEquals($val3Arr, $gottenInstallationPropsValsFuncCodeArray[2]);
		$this->assertEquals($elArr1, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($elArr2, $gottenInstallationElementsFuncCodeArray[1]);
	}

	/** @test */
	function not_author_cannot_delete_prop_of_anothers_iblock(){
		$iblock = $this->createIblockOnForm($this->module, [
				"properties[NAME][0]" => "Тест",
				"properties[CODE][0]" => "TEST",
			]
		);
		$prop = BitrixIblocksProps::where('code', 'TEST')->where('iblock_id', $iblock->id)->first();
		// $this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id.'/props/'.$prop->id.'/delete');

		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$iblock2 = $this->createIblockOnForm($module2);

		// удаление
		$this->visit('/my-bitrix/'.$module2->id.'/data_storage/ib/'.$iblock2->id.'/props/'.$prop->id.'/delete');

		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');
		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);

		$module2->deleteFolder();

		$this->assertEquals(Array(
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "500",
			"CODE"          => "TEST",
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME")',
			"PROPERTY_TYPE" => "S",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		), $gottenInstallationPropsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME'], 'Тест');
		$this->assertNotFalse(strpos($installationFileContent, 'function createIblockProp'));
	}

	/** @test */
	function not_author_cannot_delete_element_of_anothers_iblock(){
		$iblock = $this->createIblockOnForm($this->module);
		$element = $this->createIblockElementOnForm($this->module, $iblock, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);
		// $this->visit('/'); // это нужно, чтобы back() не вёл на детальную
		// $this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id.'/delete_element/'.$element->id);

		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$iblock2 = $this->createIblockOnForm($module2);

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id.'/delete_element/'.$element->id);
		$this->visit('/my-bitrix/'.$module2->id.'/data_storage/ib/'.$iblock->id.'/delete_element/'.$element->id);
		$this->visit('/my-bitrix/'.$module2->id.'/data_storage/ib/'.$iblock2->id.'/delete_element/'.$element->id);

		$module2->deleteFolder();

		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$this->assertEquals(1, count($gottenInstallationElementsFuncCodeArray));
		$this->assertEquals($installFileLangArr[$iblock->lang_key.'_ELEMENT_'.$element->id.'_NAME'], 'Trololo');
		$this->assertNotFalse(strpos($installationFileContent, 'function createIblockElement'));
	}

	/** @test */
	function not_author_cannot_delete_section_of_anothers_iblock(){
		$iblock = $this->createIblockOnForm($this->module);
		$section = $this->createIblockSectionOnForm($this->module, $iblock, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
		]);
		// $this->visit('/'); // это нужно, чтобы back() не вёл на детальную
		// $this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id.'/delete_section/'.$section->id);

		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();
		$iblock2 = $this->createIblockOnForm($module2);

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id.'/delete_section/'.$section->id);
		$this->visit('/my-bitrix/'.$module2->id.'/data_storage/ib/'.$iblock->id.'/delete_section/'.$section->id);
		$this->visit('/my-bitrix/'.$module2->id.'/data_storage/ib/'.$iblock2->id.'/delete_section/'.$section->id);

		$module2->deleteFolder();

		$gottenInstallationSectionsFuncCodeArray = $this->getIblockSectionsCreationFuncCallParamsArray($this->module);
		$installFileLangArr = $this->getLangFileArray($this->module);
		$installationFileContent = file_get_contents($this->module->getFolder(true).'/install/index.php');

		$expectedInstallationSectionsFuncCodeArray = [
			"IBLOCK_ID" => '$iblockID',
			"ACTIVE"    => "Y",
			"SORT"      => "500",
			"CODE"      => "trololo",
			"NAME"      => 'Loc::getMessage("'.$iblock->lang_key.'_SECTION_'.$section->id.'_NAME")',
		];

		$this->assertEquals($expectedInstallationSectionsFuncCodeArray, $gottenInstallationSectionsFuncCodeArray[0]);
		$this->assertEquals($installFileLangArr[$iblock->lang_key.'_SECTION_'.$section->id.'_NAME'], 'Trololo');

		$this->assertNotFalse(strpos($installationFileContent, 'function createIblockSection'));
	}

	/** @test */
	function it_can_bind_element_to_section(){
		$iblock = $this->createIblockOnForm($this->module);
		$element = $this->createIblockElementOnForm($this->module, $iblock, [
			'NAME' => 'Testelem',
			'CODE' => 'testelem',
		]);
		$section = $this->createIblockSectionOnForm($this->module, $iblock, [
			'NAME' => 'Mysection',
			'CODE' => 'mysection',
		]);
		$element2 = $this->createIblockElementOnForm($this->module, $iblock, [
			'NAME'       => 'Fooel',
			'CODE'       => 'fooel',
			'SECTION_ID' => $section->id,
		]);

		$gottenInstallationSectionsFuncCodeArray = $this->getIblockSectionsCreationFuncCallParamsArray($this->module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);

		$expectedInstallationElementFuncCodeArray1 = [
			"IBLOCK_ID" => '$iblockID',
			"ACTIVE"    => "Y",
			"SORT"      => "500",
			"CODE"      => "testelem",
			"NAME"      => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
		];
		$expectedInstallationElementFuncCodeArray2 = [
			"IBLOCK_ID"         => '$iblockID',
			"ACTIVE"            => "Y",
			"SORT"              => "500",
			"CODE"              => "fooel",
			"NAME"              => 'Loc::getMessage("'.$iblock->lang_key.'_ELEMENT_'.$element2->id.'_NAME")',
			"IBLOCK_SECTION_ID" => '$section'.$section->id.'ID',
		];

		$this->assertEquals($expectedInstallationElementFuncCodeArray1, $gottenInstallationElementsFuncCodeArray[0]);
		$this->assertEquals($expectedInstallationElementFuncCodeArray2, $gottenInstallationElementsFuncCodeArray[1]);
	}

	/** @test */
	function it_writes_creation_code_of_list_prop_with_vals(){
		$ib = $this->createIblockOnForm($this->module, [
				'VERSION'                         => '2',
				'NAME'                            => 'Ololo',
				'CODE'                            => 'trololo',
				"SORT"                            => "555",
				"LIST_PAGE_URL"                   => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
				"SECTION_PAGE_URL"                => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
				"DETAIL_PAGE_URL"                 => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
				"properties[NAME][0]"             => "Цвет",
				"properties[CODE][0]"             => "COLOR",
				"properties[TYPE][0]"             => "L",
				"properties[VALUES][0][VALUE][0]" => "Зелёный",
				"properties[VALUES][0][VALUE][1]" => "Любви",
				"properties[VALUES][0][VALUE][2]" => "Синий",
				"properties[VALUES][0][SORT][0]"  => "100",
				"properties[VALUES][0][SORT][1]"  => "200",
				"properties[VALUES][0][SORT][2]"  => "300",
				"properties[VALUES][0][DEFAULT]"  => "0",
			]
		);

		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$gottenInstallationPropsValsFuncCodeArray = $this->getIblockPropsValsCreationFuncCallParamsArray($this->module);

		$prop = BitrixIblocksProps::where('code', 'COLOR')->first();
		$val1 = BitrixIblocksPropsVals::where('value', 'Зелёный')->first();
		$val2 = BitrixIblocksPropsVals::where('value', 'Любви')->first();
		$val3 = BitrixIblocksPropsVals::where('value', 'Синий')->first();

		$propArray = Array(
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "500",
			"CODE"          => "COLOR",
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME")',
			"PROPERTY_TYPE" => "L",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		);

		$val1Arr = Array(
			"VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_VAL_'.$val1->id.'_VALUE")',
			"DEF"         => "Y",
			"SORT"        => "100",
			"PROPERTY_ID" => '$prop'.$prop->id."ID",
		);
		$val2Arr = Array(
			"VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_VAL_'.$val2->id.'_VALUE")',
			"DEF"         => "N",
			"SORT"        => "200",
			"PROPERTY_ID" => '$prop'.$prop->id."ID",
		);
		$val3Arr = Array(
			"VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_VAL_'.$val3->id.'_VALUE")',
			"DEF"         => "N",
			"SORT"        => "300",
			"PROPERTY_ID" => '$prop'.$prop->id."ID",
		);

		$this->assertEquals($propArray, $gottenInstallationPropsFuncCodeArray[0]);
		$this->assertEquals($val1Arr, $gottenInstallationPropsValsFuncCodeArray[0]);
		$this->assertEquals($val2Arr, $gottenInstallationPropsValsFuncCodeArray[1]);
		$this->assertEquals($val3Arr, $gottenInstallationPropsValsFuncCodeArray[2]);
	}

	/** @test */
	function it_writes_creation_code_of_list_prop_with_vals_in_created_iblock(){
		$ib = $this->createIblockOnForm($this->module, [
				'VERSION'          => '2',
				'NAME'             => 'Ololo',
				'CODE'             => 'trololo',
				"SORT"             => "555",
				"LIST_PAGE_URL"    => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
				"SECTION_PAGE_URL" => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
				"DETAIL_PAGE_URL"  => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
			]
		);

		$this->changeIblockOnForm($this->module, $ib, [
				'VERSION'                         => '2',
				'NAME'                            => 'Ololo',
				'CODE'                            => 'trololo',
				"SORT"                            => "555",
				"LIST_PAGE_URL"                   => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
				"SECTION_PAGE_URL"                => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
				"DETAIL_PAGE_URL"                 => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
				"properties[NAME][0]"             => "Цвет",
				"properties[CODE][0]"             => "COLOR",
				"properties[TYPE][0]"             => "L",
				"properties[VALUES][0][VALUE][0]" => "Зелёный",
				"properties[VALUES][0][VALUE][1]" => "Любви",
				"properties[VALUES][0][VALUE][2]" => "Синий",
				"properties[VALUES][0][SORT][0]"  => "100",
				"properties[VALUES][0][SORT][1]"  => "200",
				"properties[VALUES][0][SORT][2]"  => "300",
				"properties[VALUES][0][DEFAULT]"  => "0",
			]
		);

		$gottenInstallationPropsFuncCodeArray = $this->getIblockPropsCreationFuncCallParamsArray($this->module);
		$gottenInstallationPropsValsFuncCodeArray = $this->getIblockPropsValsCreationFuncCallParamsArray($this->module);

		$prop = BitrixIblocksProps::where('code', 'COLOR')->first();
		$val1 = BitrixIblocksPropsVals::where('value', 'Зелёный')->first();
		$val2 = BitrixIblocksPropsVals::where('value', 'Любви')->first();
		$val3 = BitrixIblocksPropsVals::where('value', 'Синий')->first();

		$propArray = Array(
			"IBLOCK_ID"     => '$iblockID',
			"ACTIVE"        => "Y",
			"SORT"          => "500",
			"CODE"          => "COLOR",
			"NAME"          => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_NAME")',
			"PROPERTY_TYPE" => "L",
			"USER_TYPE"     => "",
			"MULTIPLE"      => "N",
			"IS_REQUIRED"   => "N",
		);

		$val1Arr = Array(
			"VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_VAL_'.$val1->id.'_VALUE")',
			"DEF"         => "Y",
			"SORT"        => "100",
			"PROPERTY_ID" => '$prop'.$prop->id."ID",
		);
		$val2Arr = Array(
			"VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_VAL_'.$val2->id.'_VALUE")',
			"DEF"         => "N",
			"SORT"        => "200",
			"PROPERTY_ID" => '$prop'.$prop->id."ID",
		);
		$val3Arr = Array(
			"VALUE"       => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_PARAM_'.$prop->id.'_VAL_'.$val3->id.'_VALUE")',
			"DEF"         => "N",
			"SORT"        => "300",
			"PROPERTY_ID" => '$prop'.$prop->id."ID",
		);

		$elArr1 = Array(
			"IBLOCK_ID"       => '$iblockID',
			"ACTIVE"          => "Y",
			"SORT"            => "500",
			"CODE"            => "",
			"NAME"            => 'Loc::getMessage("'.$this->module->lang_key.'_IBLOCK_TROLOLO_ELEMENT__NAME")',
			"PROPERTY_VALUES" => Array(
				"COLOR" => '$val'.$val1->id.'ID',
			),
		);

		$this->assertEquals($propArray, $gottenInstallationPropsFuncCodeArray[0]);
		$this->assertEquals($val1Arr, $gottenInstallationPropsValsFuncCodeArray[0]);
		$this->assertEquals($val2Arr, $gottenInstallationPropsValsFuncCodeArray[1]);
		$this->assertEquals($val3Arr, $gottenInstallationPropsValsFuncCodeArray[2]);
	}

	/** @test */
	function it_writes_creation_code_of_element_with_list_prop_val(){
		$ib = $this->createIblockOnForm($this->module, [
				'VERSION'                         => '2',
				'NAME'                            => 'Ololo',
				'CODE'                            => 'trololo',
				"SORT"                            => "555",
				"LIST_PAGE_URL"                   => "#SITE_DIR#/".$this->module->code."/index.php?ID=#IBLOCK_ID##hi",
				"SECTION_PAGE_URL"                => "#SITE_DIR#/".$this->module->code."/list.php?SECTION_ID=#SECTION_ID##hi",
				"DETAIL_PAGE_URL"                 => "#SITE_DIR#/".$this->module->code."/detail.php?ID=#ELEMENT_ID##hi",
				"properties[NAME][0]"             => "Цвет",
				"properties[CODE][0]"             => "COLOR",
				"properties[TYPE][0]"             => "L",
				"properties[VALUES][0][VALUE][0]" => "Зелёный",
				"properties[VALUES][0][VALUE][1]" => "Любви",
				"properties[VALUES][0][VALUE][2]" => "Синий",
				"properties[VALUES][0][SORT][0]"  => "100",
				"properties[VALUES][0][SORT][1]"  => "200",
				"properties[VALUES][0][SORT][2]"  => "300",
				"properties[VALUES][0][DEFAULT]"  => "0",
			]
		);
		$prop = BitrixIblocksProps::where('code', 'COLOR')->first();
		$val1 = BitrixIblocksPropsVals::where('value', 'Зелёный')->first();
		$val2 = BitrixIblocksPropsVals::where('value', 'Любви')->first();
		$val3 = BitrixIblocksPropsVals::where('value', 'Синий')->first();
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME'                 => 'Trololo',
			'CODE'                 => 'trololo',
			'props['.$prop->id.']' => $val2->id,
		]);

		$installFileLangArr = $this->getLangFileArray($this->module);
		$gottenInstallationElementsFuncCodeArray = $this->getIblockElementsCreationFuncCallParamsArray($this->module);

		$expectedInstallationElementsFuncCodeArray = [
			"IBLOCK_ID"       => '$iblockID',
			"ACTIVE"          => "Y",
			"SORT"            => "500",
			"CODE"            => "trololo",
			"NAME"            => 'Loc::getMessage("'.$ib->lang_key.'_ELEMENT_'.$element->id.'_NAME")',
			"PROPERTY_VALUES" => Array(
				'$prop'.$prop->id.'ID' => '$val'.$val2->id.'ID',
			)
		];

		$this->assertEquals($expectedInstallationElementsFuncCodeArray, $gottenInstallationElementsFuncCodeArray[0]);
	}
}

?>