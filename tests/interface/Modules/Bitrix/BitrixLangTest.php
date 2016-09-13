<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class BitrixLangInterfaceTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/lang';
	public $file;

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		$this->module->deleteFolder();
	}

	/** @test */
	function author_can_get_to_this_page(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path);
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->logOut();

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal/auth');
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal');
	}

	/** @test */
	function it_returns_list_of_module_files(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		// станлартные файлы
		$this->see('/include.php');
		$this->see('/install/index.php');
		$this->see('/install/step.php');
		$this->see('/install/unstep.php');
		$this->see('/install/version.php');
	}

	/** @test */
	function it_can_find_untranslated_text_in_tag_when_there_is_lang_file(){
	}

	/** @test */
	function it_can_find_untranslated_text_in_tag_when_there_is_no_lang_file(){
	}

	/** @test */
	function it_can_extract_untranslated_text_in_tag_when_there_is_lang_file(){
	}

	/** @test */
	function it_can_extract_untranslated_text_in_tag_when_there_is_no_lang_file(){
	}

	/** @test */
	function it_can_find_php_comment(){
	}

	/** @test */
	function it_can_transliterate_php_comment(){
	}

	/** @test */
	function it_can_change_lang_value(){
	}

	/** @test */
	function it_can_find_unused_lang(){
	}

	/** @test */
	function it_can_delete_unused_lang(){
	}
}