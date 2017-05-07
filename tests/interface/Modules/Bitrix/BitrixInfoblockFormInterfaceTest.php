<?php

use App\Models\Modules\Bitrix\BitrixIblocksProps;
use App\Models\Modules\Bitrix\BitrixIblocksSections;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use App\Models\Modules\Bitrix\BitrixIblocksElements;

// todo чекбоксы
/** @group bitrix_interface */
class BitrixInfoblockFormInterfaceTest extends BitrixTestCase{

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

	/** @test */
	function author_can_get_to_this_page(){
		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib');

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib');

	}

	/** @test */
	function this_is_definitely_page_about_iblock(){
		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib');

		$this->see('Добавить инфоблок');
	}

	/** @test */
	function this_is_definitely_page_about_iblock_en(){
		$this->setLang('en');

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib');

		$this->see('Add infoblock');
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->logOut();

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib');

		$this->seePageIs(route('login'));
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib');

		$this->seePageIs('/personal');
	}

	/** @test */
	function it_returns_infoblock_tab_data_after_save(){
		$ib = $this->createIblockOnForm($this->module, [
			'NAME'               => 'Ololo',
			'CODE'               => 'trololo',
			"LIST_PAGE_URL"      => "ololo_list",
			"SECTION_PAGE_URL"   => "ololo/#SECTION_ID#",
			"DETAIL_PAGE_URL"    => "ololo/#ELEMENT_ID#",
			"CANONICAL_PAGE_URL" => "test_canon",
			"INDEX_SECTION"      => "Y",
			"INDEX_ELEMENT"      => "Y"
		]);

		$this->seeInField('NAME', 'Ololo');
		$this->seeInField('CODE', 'trololo');
		$this->seeInField("LIST_PAGE_URL", "ololo_list");
		$this->seeInField("SECTION_PAGE_URL", "ololo/#SECTION_ID#");
		$this->seeInField("DETAIL_PAGE_URL", "ololo/#ELEMENT_ID#");
		$this->seeInField("CANONICAL_PAGE_URL", "test_canon");
		$this->seeIsChecked("INDEX_SECTION");
		$this->seeIsChecked("INDEX_ELEMENT");
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id);
	}

	/** @test */
	function it_returns_seo_tab_data_after_save(){
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
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id);
	}

	/** @test */
	function it_returns_fields_tab_data_after_save(){
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
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id);
	}

	/** @test */
	function it_returns_string_prop_data(){
		$ib = $this->createIblockOnForm($this->module, [
				"properties[NAME][0]"                      => "Тест",
				"properties[CODE][0]"                      => "TEST",
				"properties[MULTIPLE][0]"                  => "Y",
				"properties[IS_REQUIRED][0]"               => "Y",
				"properties[dop_params][0][HINT]"          => "Подсказка",
				"properties[dop_params][0][DEFAULT_VALUE]" => "ololo",
			]
		);

		$this->seeInField("properties[NAME][0]", "Тест");
		$this->seeInField("properties[CODE][0]", "TEST");
		$this->seeIsChecked("properties[MULTIPLE][0]");
		$this->seeIsChecked("properties[IS_REQUIRED][0]");
		$this->seeIsChecked("properties[IS_REQUIRED][0]");
		$this->seeInField("properties[dop_params][0][HINT]", 'Подсказка');
		$this->seeInField("properties[dop_params][0][DEFAULT_VALUE]", 'ololo');
		$this->seeIsSelected("properties[TYPE][0]", 'S');

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id);
	}

	// /** @test */ // todo
	// function it_returns_google_map_prop_data(){
	// 	$this->signIn();
	// 	$this->module = $this->fillNewBitrixForm();
	//
	// 	$ib = $this->createIblockOnForm($this->module, [
	// 			"properties[NAME][0]" => "Тест",
	// 			"properties[CODE][0]" => "TEST",
	// 			"properties[TYPE][0]" => "S:map_google",
	// 		]
	// 	);
	//
	// 	
	//
	// 	$this->seeInField("properties[NAME][0]", "Тест");
	// 	$this->seeInField("properties[CODE][0]", "TEST");
	// 	$this->seeIsSelected("properties[TYPE][0]", 'S:map_google');
	//
	// 	$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id);
	// }

	/** @test */
	function it_returns_permissions_tab_data_after_save(){
		$ib = $this->createIblockOnForm($this->module, [
			"GROUP_ID" => "Array('2' => 'X')",
		]);

		$this->seeIsSelected("GROUP_ID", "Array('2' => 'X')");
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id);
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_code(){
		$ib = $this->createIblockOnForm($this->module, [
			'NAME' => 'Ololo',
			'CODE' => ''
		]);

		$this->see('Поле "Код" обязательно');
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_name(){
		$ib = $this->createIblockOnForm($this->module, [
			'NAME' => '',
			'CODE' => 'trololo'
		]);

		$this->see('Поле "Название" обязательно');
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_code_en(){
		$this->setLang('en');

		$ib = $this->createIblockOnForm($this->module, [
			'NAME' => 'Ololo',
			'CODE' => ''
		]);

		$this->see('The "Code" field is required');
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_an_error_when_there_is_no_name_en(){
		$this->setLang('en');

		$ib = $this->createIblockOnForm($this->module, [
			'NAME' => '',
			'CODE' => 'trololo'
		]);

		$this->see('The "Name" field is required');
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/');
	}

	/** @test */
	function it_returns_test_element_data(){
		$ib = $this->createIblockOnForm($this->module);
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
			'SORT' => '1487',
		]);

		$this->seeInField('NAME', 'Trololo');
		$this->seeInField('CODE', 'trololo');
		$this->seeInField('SORT', '1487');
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id.'/edit_element/'.$element->id);
	}

	/** @test */
	function it_substitutes_string_prop_default_value_on_test_element_creating_form(){
		$ib = $this->createIblockOnForm($this->module, [
			"properties[NAME][0]"                      => "Тест",
			"properties[CODE][0]"                      => "TEST",
			"properties[IS_REQUIRED][0]"               => "Y",
			"properties[dop_params][0][DEFAULT_VALUE]" => "ololo",
		]);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id.'/create_element');

		$this->seeInField('props['.$prop->id.']', 'ololo');
	}

	/** @test */
	function it_returns_data_of_test_element_with_string_prop_value(){
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

		$this->seeInField('NAME', 'Trololo');
		$this->seeInField('CODE', 'trololo');
		$this->seeInField('props['.$prop->id.']', 'test');
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id.'/edit_element/'.$element->id);
	}

	/** @test */
	function it_returns_data_of_test_element_with_google_map_prop_value(){
		$ib = $this->createIblockOnForm($this->module, [
			"properties[NAME][0]" => "Тест",
			"properties[CODE][0]" => "TEST",
			"properties[TYPE][0]" => "S:map_google",
		]);
		$prop = BitrixIblocksProps::where('code', 'TEST')->first();
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME'                    => 'Trololo',
			'CODE'                    => 'trololo',
			'props['.$prop->id.'][0]' => 'one',
			'props['.$prop->id.'][1]' => 'two',
		]);

		$this->seeInField('NAME', 'Trololo');
		$this->seeInField('CODE', 'trololo');
		$this->see('one');
		$this->see('two');
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id.'/edit_element/'.$element->id);
	}

	/** @test */
	function it_imports_main_iblock_params_from_xml(){
		$file = public_path().'/for_tests/test_iblock.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$this->seeInField('NAME', 'Тест');
		$this->seeInField('CODE', 'test');
		$this->seeInField('SORT', '500');
		$this->seeInField('LIST_PAGE_URL', '#SITE_DIR#/test/');
		$this->seeInField('SECTION_PAGE_URL', '#SITE_DIR#/test/#SECTION_CODE_PATH#/');
		$this->seeInField('DETAIL_PAGE_URL', '#SITE_DIR#/test/#SECTION_CODE_PATH#/#CODE#.html');
		$this->seeInField('CANONICAL_PAGE_URL', 'canon');
	}

	/** @test */
	function it_imports_iblock_properties_from_xml(){
		$this->signIn();
		$this->module = $this->fillNewBitrixForm();

		$file = public_path().'/for_tests/test_iblock.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$this->seeInField('properties[NAME][0]', 'Тестовое свойство');
		$this->seeInField('properties[CODE][0]', 'TESTOVOE_SVOISVTO');
		$this->seeInField('properties[SORT][0]', '400');
		$this->seeIsSelected('properties[TYPE][0]', 'S');
		$this->dontSeeIsChecked('properties[MULTIPLE][0]');
		$this->dontSeeIsChecked('properties[IS_REQUIRED][0]');
		$this->seeInField('properties[NAME][1]', 'Ещё свойство');
		$this->seeInField('properties[CODE][1]', 'ANOTHER_ONE');
		$this->seeInField('properties[SORT][1]', '500');
		$this->seeIsSelected('properties[TYPE][1]', 'E');
		$this->seeIsChecked('properties[MULTIPLE][1]');
		$this->seeIsChecked('properties[IS_REQUIRED][1]');
	}

	/** @test */
	function it_imports_iblock_properties_dop_params_from_xml(){
		$this->signIn();
		$this->module = $this->fillNewBitrixForm();

		$file = public_path().'/for_tests/test_iblock_one_section_w_element_and_element_at_root_and_empty_section_and_props_dop_params.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$this->seeInField('properties[NAME][0]', 'Строка с дефолтом');
		$this->seeInField('properties[CODE][0]', 'STROKA');
		$this->seeIsSelected('properties[TYPE][0]', 'S');
		$this->seeInField('properties[dop_params][0][DEFAULT_VALUE]', 'Test');

		$this->seeInField('properties[NAME][1]', 'Чекбокс');
		$this->seeInField('properties[CODE][1]', 'CHECKBOX');
		$this->seeIsSelected('properties[TYPE][1]', 'L');
		$this->seeIsSelected('properties[dop_params][1][LIST_TYPE]', 'C');

		$this->seeInField('properties[NAME][2]', 'Список');
		$this->seeInField('properties[CODE][2]', 'SPISOK');
		$this->seeIsSelected('properties[TYPE][2]', 'L');

		$this->seeInField('properties[NAME][3]', 'Множественная строка');
		$this->seeInField('properties[CODE][3]', 'STROKA_MULTIPLE');
		$this->seeIsSelected('properties[TYPE][3]', 'S');
		$this->seeIsChecked('properties[MULTIPLE][3]');
	}

	/** @test */
	function it_imports_checkbox_var_from_xml(){
		$this->signIn();
		$this->module = $this->fillNewBitrixForm();

		$file = public_path().'/for_tests/test_iblock_one_section_w_element_and_element_at_root_and_empty_section_and_props_dop_params.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$this->seeInField('properties[NAME][1]', 'Чекбокс');
		$this->seeInField('properties[CODE][1]', 'CHECKBOX');
		$this->seeIsSelected('properties[TYPE][1]', 'L');
		$this->seeIsSelected('properties[dop_params][1][LIST_TYPE]', 'C');
		$this->seeInField('properties[VALUES][1][VALUE][]', 'Y');
	}

	/** @test */
	function it_imports_iblock_elements_from_xml(){
		$file = public_path().'/for_tests/test_iblock.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$iblock = BitrixInfoblocks::where('code', "test")->first();
		$element1 = BitrixIblocksElements::where('name', "Тест")->where('iblock_id', $iblock->id)->first();
		$element2 = BitrixIblocksElements::where('name', "Ололо")->where('iblock_id', $iblock->id)->first();
		$prop = BitrixIblocksProps::where('code', 'TESTOVOE_SVOISVTO')->first();

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id.'/edit_element/'.$element1->id);
		$this->seeInField('NAME', 'Тест');
		$this->seeInField('CODE', '');
		$this->seeInField('SORT', '400');
		$this->seeInField('props['.$prop->id.']', 'Ололо');

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id.'/edit_element/'.$element2->id);
		$this->seeInField('NAME', 'Ололо');
		$this->seeInField('CODE', 'ololo');
		$this->seeInField('SORT', '500');
		$this->seeInField('props['.$prop->id.']', '');
	}

	/** @test
	 * тест на одну категорию есть в тесте файлов
	 */
	function it_imports_more_than_one_iblock_sections_from_xml(){
		$file = public_path().'/for_tests/test_iblock_one_section_w_element_and_element_at_root_and_empty_section_and_props_dop_params.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$iblock = BitrixInfoblocks::where('code', "ololo")->first();

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$iblock->id);
		$this->see('Тестовый раздел');
		$this->see('Пустой раздел');
	}

	/** @test */
	function it_dont_imports_iblock_elements_from_xml_if_it_shouldnt(){
		$file = public_path().'/for_tests/test_iblock.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->check('only_structure'); // не импортировать наполнение
		$this->press('import');

		$this->dontSee('edit_element');
	}

	/** @test */
	function it_returns_test_section_data(){
		$ib = $this->createIblockOnForm($this->module);
		$section = $this->createIblockSectionOnForm($this->module, $ib, [
			'NAME' => 'Trololo',
			'CODE' => 'trololo',
			'SORT' => '1487',
		]);

		$this->seeInField('NAME', 'Trololo');
		$this->seeInField('CODE', 'trololo');
		$this->seeInField('SORT', '1487');
		$this->seePageIs('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id.'/edit_section/'.$section->id);
	}

	/** @test */
	function not_author_cannot_get_to_page_of_anothers_iblock(){
		$ib = $this->createIblockOnForm($this->module, [
			'NAME'               => 'Ololo',
			'CODE'               => 'trololo',
			"LIST_PAGE_URL"      => "ololo_list",
			"SECTION_PAGE_URL"   => "ololo/#SECTION_ID#",
			"DETAIL_PAGE_URL"    => "ololo/#ELEMENT_ID#",
			"CANONICAL_PAGE_URL" => "test_canon",
			"INDEX_SECTION"      => "Y",
			"INDEX_ELEMENT"      => "Y"
		]);

		$this->signIn(factory(App\Models\User::class)->create());
		$module2 = $this->fillNewBitrixForm();

		$this->visit('/my-bitrix/'.$module2->id.'/data_storage/ib/'.$ib->id);

		$module2->deleteFolder();

		$this->seePageIs('/personal');
	}

	/** @test */
	function it_can_bind_element_to_section(){
		$ib = $this->createIblockOnForm($this->module);
		$element = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME' => 'Testelem',
			'CODE' => 'testelem',
			'SORT' => '1487',
		]);
		$section = $this->createIblockSectionOnForm($this->module, $ib, [
			'NAME' => 'Mysection',
			'CODE' => 'mysection',
			'SORT' => '1487',
		]);
		$element2 = $this->createIblockElementOnForm($this->module, $ib, [
			'NAME'       => 'Fooel',
			'CODE'       => 'fooel',
			'SORT'       => '1487',
			'SECTION_ID' => $section->id,
		]);

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id);
		$this->see('Testelem');
		$this->dontSee('Fooel');

		$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/ib/'.$ib->id.'/section/'.$section->id);
		$this->see('Fooel');
		$this->dontSee('Testelem');

		// $this->seeInField('NAME', 'Trololo');
		// $this->seeInField('CODE', 'trololo');
		// $this->seeInField('SORT', '1487');
	}
	// /** @test */
	// function it_can_remove_iblock(){
	// 	$this->signIn();
	// 	$this->module = $this->fillNewBitrixForm();
	//
	// 	$iblock = $this->createIblockOnForm($this->module);
	// 	$this->removeIblock($this->module, $iblock);
	// 	
	//
	// 	$this->visit('/my-bitrix/'.$this->module->id.'/data_storage/')->dontSee('bitrix');
	// }

	/** @test */
	function it_imports_iblock_that_have_only_name_from_xml(){
		$file = public_path().'/for_tests/test_iblock_with_only_name.xml';
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->attach($file, 'file');
		$this->press('import');

		$iblock = BitrixInfoblocks::first();

		$this->seeInField('NAME', $iblock->name);
	}
}

?>