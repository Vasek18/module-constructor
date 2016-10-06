<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use App\Models\Modules\Bitrix\BitrixIblocksElements;

// todo чекбоксы
class BitrixInfoblockFormInterfaceTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/data_storage';

	/** @test */
	function author_can_get_to_this_page(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_iblock(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->see('Добавить инфоблок');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_iblock_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->fillNewBitrixForm();

		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->see('Add infoblock');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$this->logOut();

		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->seePageIs('/personal/auth');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');

		$this->seePageIs('/personal');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_returns_infoblock_tab_data_after_save(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			'NAME'               => 'Ololo',
			'CODE'               => 'trololo',
			"LIST_PAGE_URL"      => "ololo_list",
			"SECTION_PAGE_URL"   => "ololo/#SECTION_ID#",
			"DETAIL_PAGE_URL"    => "ololo/#ELEMENT_ID#",
			"CANONICAL_PAGE_URL" => "test_canon",
			"INDEX_SECTION"      => "Y",
			"INDEX_ELEMENT"      => "Y"
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seeInField('NAME', 'Ololo');
		$this->seeInField('CODE', 'trololo');
		$this->seeInField("LIST_PAGE_URL", "ololo_list");
		$this->seeInField("SECTION_PAGE_URL", "ololo/#SECTION_ID#");
		$this->seeInField("DETAIL_PAGE_URL", "ololo/#ELEMENT_ID#");
		$this->seeInField("CANONICAL_PAGE_URL", "test_canon");
		$this->seeIsChecked("INDEX_SECTION");
		$this->seeIsChecked("INDEX_ELEMENT");
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/'.$ib->id);
	}

	/** @test */
	function it_returns_seo_tab_data_after_save(){
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
			"IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][SPACE]"             => "]",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"    => "test13",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"  => "test14",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"   => "test15",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][SPACE]"      => "[",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TRANSLIT]"   => "Y",
			"IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][LOWER]"      => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_ALT][TEMPLATE]"   => "test17",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_TITLE][TEMPLATE]" => "test18",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TEMPLATE]"  => "test19",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][SPACE]"     => "}",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TRANSLIT]"  => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][LOWER]"     => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_ALT][TEMPLATE]"    => "test21",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]"  => "test22",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TEMPLATE]"   => "test23",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][SPACE]"      => "{",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TRANSLIT]"   => "Y",
			"IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][LOWER]"      => "Y",
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_META_TITLE][TEMPLATE]", "test1");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_META_KEYWORDS][TEMPLATE]", "test2");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_META_DESCRIPTION][TEMPLATE]", "test3");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_PAGE_TITLE][TEMPLATE]", "test4");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_META_TITLE][TEMPLATE]", "test5");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_META_KEYWORDS][TEMPLATE]", "test6");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_META_DESCRIPTION][TEMPLATE]", "test7");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_PAGE_TITLE][TEMPLATE]", "test8");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_ALT][TEMPLATE]", "test9");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_TITLE][TEMPLATE]", "test10");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][TEMPLATE]", "test11");
		$this->seeIsChecked("IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][TRANSLIT]");
		$this->seeIsChecked("IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][LOWER]");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_PICTURE_FILE_NAME][SPACE]", "]");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_ALT][TEMPLATE]", "test13");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]", "test14");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TEMPLATE]", "test15");
		$this->seeInField("IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][SPACE]", "[");
		$this->seeIsChecked("IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][TRANSLIT]");
		$this->seeIsChecked("IPROPERTY_TEMPLATES[SECTION_DETAIL_PICTURE_FILE_NAME][LOWER]");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_ALT][TEMPLATE]", "test17");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_TITLE][TEMPLATE]", "test18");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TEMPLATE]", "test19");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][SPACE]", "}");
		$this->seeIsChecked("IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][TRANSLIT]");
		$this->seeIsChecked("IPROPERTY_TEMPLATES[ELEMENT_PREVIEW_PICTURE_FILE_NAME][LOWER]");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_ALT][TEMPLATE]", "test21");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_TITLE][TEMPLATE]", "test22");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TEMPLATE]", "test23");
		$this->seeInField("IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][SPACE]", "{");
		$this->seeIsChecked("IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][TRANSLIT]");
		$this->seeIsChecked("IPROPERTY_TEMPLATES[ELEMENT_DETAIL_PICTURE_FILE_NAME][LOWER]");
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/'.$ib->id);
	}

	/** @test */
	function it_returns_fields_tab_data_after_save(){
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

		$this->deleteFolder($this->standartModuleCode);

		$this->seeIsChecked("FIELDS[IBLOCK_SECTION][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[IBLOCK_SECTION][DEFAULT_VALUE][KEEP_IBLOCK_SECTION_ID]");
		$this->seeIsChecked("FIELDS[ACTIVE][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[ACTIVE_FROM][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[ACTIVE_TO][IS_REQUIRED]");
		$this->seeInField("FIELDS[ACTIVE_TO][DEFAULT_VALUE]", "test");
		$this->seeIsChecked("FIELDS[SORT][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[NAME][IS_REQUIRED]");
		$this->seeInField("FIELDS[NAME][DEFAULT_VALUE]", "test");
		$this->seeIsChecked("FIELDS[PREVIEW_PICTURE][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][FROM_DETAIL]");
		$this->seeIsChecked("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][DELETE_WITH_DETAIL]");
		$this->seeIsChecked("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][UPDATE_WITH_DETAIL]");
		$this->seeIsChecked("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][SCALE]");
		$this->seeInField("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WIDTH]", "test");
		$this->seeInField("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][HEIGHT]", "test");
		$this->seeIsChecked("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]");
		$this->seeIsChecked("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][METHOD]");
		$this->seeInField("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][COMPRESSION]", "test");
		$this->seeIsChecked("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]");
		$this->seeInField("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]", "test");
		$this->seeInField("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]", "test");
		$this->seeIsChecked("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]");
		$this->seeInField("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]", "test");
		$this->seeInField("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]", "test");
		$this->seeInField("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]", "test");
		$this->seeInField("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]", "test");
		$this->seeIsChecked("FIELDS[PREVIEW_TEXT_TYPE][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[PREVIEW_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]");
		$this->seeInField("FIELDS[PREVIEW_TEXT][DEFAULT_VALUE]", "test");
		$this->seeIsChecked("FIELDS[PREVIEW_TEXT][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[DETAIL_PICTURE][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][SCALE]");
		$this->seeInField("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WIDTH]", "test");
		$this->seeInField("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][HEIGHT]", "test");
		$this->seeIsChecked("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][IGNORE_ERRORS]");
		$this->seeIsChecked("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][METHOD]");
		$this->seeInField("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][COMPRESSION]", "test");
		$this->seeIsChecked("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_FILE]");
		$this->seeInField("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE]", "test");
		$this->seeInField("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_ALPHA]", "test");
		$this->seeIsChecked("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][USE_WATERMARK_TEXT]");
		$this->seeInField("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT]", "test");
		$this->seeInField("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_FONT]", "test");
		$this->seeInField("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_COLOR]", "test");
		$this->seeInField("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_SIZE]", "test");
		$this->seeIsChecked("FIELDS[DETAIL_TEXT_TYPE][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[DETAIL_TEXT_TYPE_ALLOW_CHANGE][DEFAULT_VALUE]");
		$this->seeInField("FIELDS[DETAIL_TEXT][DEFAULT_VALUE]", "test");
		$this->seeIsChecked("FIELDS[DETAIL_TEXT][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[XML_ID][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[CODE][IS_REQUIRED]");
		$this->seeIsChecked("FIELDS[CODE][DEFAULT_VALUE][UNIQUE]");
		$this->seeIsChecked("FIELDS[CODE][DEFAULT_VALUE][TRANSLITERATION]");
		$this->seeInField("FIELDS[CODE][DEFAULT_VALUE][TRANS_LEN]", "test");
		$this->seeInField("FIELDS[CODE][DEFAULT_VALUE][TRANS_SPACE]", "test");
		$this->seeInField("FIELDS[CODE][DEFAULT_VALUE][TRANS_OTHER]", "test");
		$this->seeIsChecked("FIELDS[CODE][DEFAULT_VALUE][TRANS_EAT]");
		$this->seeIsChecked("FIELDS[CODE][DEFAULT_VALUE][USE_GOOGLE]");
		$this->seeIsChecked("FIELDS[TAGS][IS_REQUIRED]");
		$this->seeIsSelected("FIELDS[ACTIVE_FROM][DEFAULT_VALUE]", "=today");
		$this->seeIsSelected("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]", "br");
		$this->seeIsSelected("FIELDS[PREVIEW_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]", "br");
		$this->seeIsSelected("FIELDS[PREVIEW_TEXT_TYPE][DEFAULT_VALUE]", "html");
		$this->seeIsSelected("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_FILE_POSITION]", "br");
		$this->seeIsSelected("FIELDS[DETAIL_PICTURE][DEFAULT_VALUE][WATERMARK_TEXT_POSITION]", "br");
		$this->seeIsSelected("FIELDS[DETAIL_TEXT_TYPE][DEFAULT_VALUE]", "html");
		$this->seeIsSelected("FIELDS[CODE][DEFAULT_VALUE][TRANS_CASE]", "U");
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/'.$ib->id);
	}

	/** @test */
	function it_returns_string_prop_data(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
				"properties[NAME][0]"        => "Тест",
				"properties[CODE][0]"        => "TEST",
				"properties[MULTIPLE][0]"    => "Y",
				"properties[IS_REQUIRED][0]" => "Y",
			]
		);

		$module->deleteFolder();

		$this->seeInField("properties[NAME][0]", "Тест");
		$this->seeInField("properties[CODE][0]", "TEST");
		$this->seeIsChecked("properties[MULTIPLE][0]");
		$this->seeIsChecked("properties[IS_REQUIRED][0]");
		// $this->seeIsSelected("properties[TYPE][0]", 'S');

		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/'.$ib->id);
	}

	// /** @test */ // todo
	// function it_returns_google_map_prop_data(){
	// 	$this->signIn();
	// 	$module = $this->fillNewBitrixForm();
	//
	// 	$ib = $this->createIblockOnForm($module, [
	// 			"properties[NAME][0]" => "Тест",
	// 			"properties[CODE][0]" => "TEST",
	// 			"properties[TYPE][0]" => "S:map_google",
	// 		]
	// 	);
	//
	// 	$module->deleteFolder();
	//
	// 	$this->seeInField("properties[NAME][0]", "Тест");
	// 	$this->seeInField("properties[CODE][0]", "TEST");
	// 	$this->seeIsSelected("properties[TYPE][0]", 'S:map_google');
	//
	// 	$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/'.$ib->id);
	// }

	/** @test */
	function it_returns_permissions_tab_data_after_save(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			"GROUP_ID" => "Array('2' => 'X')",
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seeIsSelected("GROUP_ID", "Array('2' => 'X')");
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/'.$ib->id);
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_code(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			'NAME' => 'Ololo',
			'CODE' => ''
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Поле "Код" обязательно');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_name(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			'NAME' => '',
			'CODE' => 'trololo'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Поле "Название" обязательно');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_code_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			'NAME' => 'Ololo',
			'CODE' => ''
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('The "Code" field is required');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_name_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			'NAME' => '',
			'CODE' => 'trololo'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('The "Name" field is required');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_test_element_data(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module);
		$element = $this->createIblockElementOnForm($module, $ib, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
			'SORT' => '1487',
		]);
		$module->deleteFolder();

		$this->seeInField('NAME', 'Trololo');
		$this->seeInField('CODE', 'trololo');
		$this->seeInField('SORT', '1487');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/'.$ib->id.'/show_element/'.$element->id);
	}

	/** @test */
	function it_returns_data_of_test_element_with_string_prop_value(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			"properties[NAME][0]"        => "Тест",
			"properties[CODE][0]"        => "TEST",
			"properties[IS_REQUIRED][0]" => "Y",
		]);
		$element = $this->createIblockElementOnForm($module, $ib, [
			'NAME'        => 'Trololo',
			'CODE'        => 'trololo',
			'props[TEST]' => 'test',
		]);
		$module->deleteFolder();

		$this->seeInField('NAME', 'Trololo');
		$this->seeInField('CODE', 'trololo');
		$this->seeInField('props[TEST]', 'test');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/'.$ib->id.'/show_element/'.$element->id);
	}

	/** @test */
	function it_returns_data_of_test_element_with_google_map_prop_value(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$ib = $this->createIblockOnForm($module, [
			"properties[NAME][0]" => "Тест",
			"properties[CODE][0]" => "TEST",
			"properties[TYPE][0]" => "S:map_google",
		]);
		$element = $this->createIblockElementOnForm($module, $ib, [
			'NAME'           => 'Trololo',
			'CODE'           => 'trololo',
			'props[TEST][0]' => 'one',
			'props[TEST][1]' => 'two',
		]);
		$module->deleteFolder();

		$this->seeInField('NAME', 'Trololo');
		$this->seeInField('CODE', 'trololo');
		$this->see('one');
		$this->see('two');
		$this->seePageIs('/my-bitrix/'.$module->id.'/data_storage/ib/'.$ib->id.'/show_element/'.$element->id);
	}

	/** @test */
	function it_imports_main_iblock_params_from_xml(){
		$this->signIn();
		$module = $this->fillNewBitrixForm();

		$file = public_path().'/for_tests/test_iblock.xml';
		$this->visit('/my-bitrix/'.$module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');
		$module->deleteFolder();

		$this->seeInField('NAME', 'Тест');
		$this->seeInField('CODE', 'test');
		$this->seeInField('SORT', '500');
		$this->seeInField('LIST_PAGE_URL', '#SITE_DIR#/test/');
		$this->seeInField('SECTION_PAGE_URL', '#SITE_DIR#/test/#SECTION_CODE_PATH#/');
		$this->seeInField('DETAIL_PAGE_URL', '#SITE_DIR#/test/#SECTION_CODE_PATH#/#CODE#.html');
		$this->seeInField('CANONICAL_PAGE_URL', 'canon');
	}

	// /** @test */
	// function it_can_remove_iblock(){
	// 	$this->signIn();
	// 	$module = $this->fillNewBitrixForm();
	//
	// 	$iblock = $this->createIblockOnForm($module);
	// 	$this->removeIblock($module, $iblock);
	// 	$module->deleteFolder();
	//
	// 	$this->visit('/my-bitrix/'.$module->id.'/data_storage/')->dontSee('bitrix');
	// }
}

?>