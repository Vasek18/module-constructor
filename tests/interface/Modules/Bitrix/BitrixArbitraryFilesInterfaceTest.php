<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixArbitraryFiles;

/** @group bitrix_interface */
class BitrixArbitraryFilesInterfaceTest extends BitrixTestCase{

	use DatabaseTransactions;

	protected $path = '/arbitrary_files';
	public $file;

	function setUp(){
		parent::setUp();

		$this->file = public_path().'/ololo.php';
		file_put_contents($this->file, 'ololo');

		$this->signIn();
		$this->module = $this->fillNewBitrixForm();
	}

	function tearDown(){
		parent::tearDown();

		unlink($this->file);
	}

	/** @test */
	function author_can_get_to_this_page(){

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path);

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_arbitrary_files(){

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('Произвольные файлы');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_arbitrary_files_en(){
		$this->setLang('en');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('Arbitrary files');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){

		$this->logOut();

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs(route('login'));

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_returns_file_in_list(){
		$file = $this->uploadArbitraryFileOnForm($this->module, [
			'path'     => 'test',
			'location' => 'on_site'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('/test/ololo.php');
	}

	/** @test */
	function it_substitute_slash_if_there_is_no_path(){
		$file = $this->uploadArbitraryFileOnForm($this->module, [
			'path'     => '',
			'location' => 'on_site'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('/ololo.php');
	}

	/** @test */
	function it_returns_changed_params_and_content_of_file(){
		$file = $this->uploadArbitraryFileOnForm($this->module, [
			'path'     => '/lib/',
			'location' => 'in_module'
		]);

		$this->changeArbitraryFile($this->module, $file, [
			'filename' => 'vasya.php',
			'code'     => 'Vasya the creator',
			'path'     => 'testpath',
			'location' => 'on_site',
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seeInField('filename_'.$file->id, 'vasya.php');
		$this->seeInField('path_'.$file->id, '/testpath/');
		$this->seeIsSelected('location_'.$file->id, 'on_site');
		$this->seeInField('code_'.$file->id, 'Vasya the creator');
	}
}

?>