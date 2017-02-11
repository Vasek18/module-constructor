<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group bitrix_interface */
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

		if ($this->module){
			$this->module->deleteFolder();
		}
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

		$this->seePageIs(route('login'));
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
	function it_matches_files_with_problems(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? ololo(); ?><p>ололо</p>');
		$this->module->disk()->put($this->module->module_folder.'/lang/ru/ololo.php', '<? $MESS["TEST"] = "Test";?>');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$html = $this->response->getContent();
		$this->assertRegexp('/list-group-item-danger[^<]+?<[^>]+?>\/ololo.php/', $html);
	}

	/** @test */
	function smn_cannot_go_to_page_of_nonexistent_file(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
	}

	/** @test */
	function it_can_find_untranslated_text_in_tag_when_there_is_lang_file(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? ololo(); ?><p>ололо</p>');
		$this->module->disk()->put($this->module->module_folder.'/lang/ru/ololo.php', '<? $MESS["TEST"] = "Test";?>');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->see('<span class="bg-danger">ололо</span>');
		$this->seeInField('code_1', 'OLOLO');
	}

	/** @test */
	function it_can_find_untranslated_text_in_tag_when_there_is_no_lang_file(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? ololo(); ?><p>ололо</p>');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->see('<span class="bg-danger">ололо</span>');
		$this->seeInField('code_0', 'OLOLO');
	}

	/** @test */
	function it_can_extract_untranslated_text_in_tag_when_there_is_lang_file(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? ololo(); ?><p>ололо</p>');
		$this->module->disk()->put($this->module->module_folder.'/lang/ru/ololo.php', '<? $MESS["TEST"] = "Тест";?>');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->press('save_1');

		$this->see('&lt;p&gt;&lt;?=GetMessage("OLOLO");?&gt;&lt;/p&gt;');
		$this->see('<p class="form-control-static">OLOLO</p>');
	}

	/** @test */
	function it_can_extract_untranslated_text_in_tag_when_there_is_no_lang_file(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? ololo(); ?><p>ололо</p>');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->press('save_0');

		$this->see('&lt;p&gt;&lt;?=GetMessage("OLOLO");?&gt;&lt;/p&gt;');
		$this->see('<p class="form-control-static">OLOLO</p>');
	}

	/** @test */
	function it_can_extract_untranslated_text_in_function_call_param(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? ololo("тест"); ?>');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->press('save_0');

		$this->see('GetMessage("TEST")');
		$this->see('<p class="form-control-static">TEST</p>');
	}

	/** @test */
	function it_can_find_php_comment_in_cyrillic(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? // тест ');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->see('<span class="bg-danger">тест</span>');
		// $this->seeInField('code_0', 'TEST');
	}

	/** @test */
	function it_doesnt_think_that_php_comment_in_latin_is_a_problem(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? // i am not here ');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->dontSee('<span class="bg-danger">i am not here</span>');
	}

	/** @test */
	function it_can_transliterate_php_comment(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? // тест ололо ');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->press('translit_0');

		$this->see('<? // test ololo ');
	}

	/** @test */
	function it_can_change_lang_value(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? ololo(); ?><p><?=GetMessage("OLOLO");?></p>');
		$this->module->disk()->put($this->module->module_folder.'/lang/ru/ololo.php', '<? $MESS["OLOLO"] = "ololo";?>');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->type('trololo', 'phrase_0');
		$this->press('change_0');

		$this->see('&lt;p&gt;&lt;?=GetMessage("OLOLO");?&gt;&lt;/p&gt;');
		$this->see('<p class="form-control-static">OLOLO</p>');
		$this->seeInField('phrase_0', 'trololo');
	}

	/** @test */
	function it_can_find_unused_lang(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? ololo(); ?><p>ololo</p>');
		$this->module->disk()->put($this->module->module_folder.'/lang/ru/ololo.php', '<? $MESS["TEST"] = "Test";?>');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->see('<tr class="bg-danger">');
		$this->see('<p class="form-control-static">TEST</p>');
	}

	/** @test */
	function it_can_delete_unused_lang(){
		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? ololo(); ?><p>ololo</p>');
		$this->module->disk()->put($this->module->module_folder.'/lang/ru/ololo.php', '<? $MESS["TEST"] = "Test";?>');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');
		$this->press('delete_0');

		$this->dontSee('<tr class="bg-danger">');
		$this->dontSee('<p class="form-control-static">TEST</p>');
	}

	/** @test */
	function free_user_cannot_see_file_content(){
		$this->user->paid_days = 0;

		$this->module->disk()->put($this->module->module_folder.'/ololo.php', '<? ololo(); ?><p>ололо</p>');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/edit?file=%2Fololo.php');

		$this->dontSee('<span class="bg-danger">ололо</span>');
	}
}