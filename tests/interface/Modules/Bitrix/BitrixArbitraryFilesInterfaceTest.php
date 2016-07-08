<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixArbitraryFiles;

class BitrixArbitraryFilesInterfaceTest extends TestCase{

	use DatabaseTransactions;

	protected $path = '/arbitrary_files';
	private $file;
	private $module;

	function setUp(){
		parent::setUp();

		$this->file = public_path().'/ololo.php';
		file_put_contents($this->file, 'ololo');

		$this->signIn();
		$this->module = $this->createBitrixModule();
	}

	function tearDown(){
		parent::tearDown();

		unlink($this->file);
	}

	function uploadOnForm($module, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.$this->path);

		if (!isset($inputs['path'])){
			$inputs['path'] = '/';
		}
		if (!isset($inputs['file'])){
			$inputs['file'] = $this->file;
		}
		if (!isset($inputs['location'])){
			$inputs['location'] = 'in_module';
		}

		$this->type($inputs['path'], 'path');
		$this->select($inputs['location'], 'location');
		$this->attach($inputs['file'], 'file');
		$this->press('upload');

		if (isset($inputs['file'])){
			return BitrixArbitraryFiles::where('filename', basename($inputs['file']))->where('module_id', $module->id)->first();
		}

		return true;
	}

	function removeFile($module, $amp){
		$this->visit('/my-bitrix/'.$module->id.$this->path);
		$this->click('delete_amp_'.$amp->id);
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

		$this->seePageIs('/personal/auth');

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
		$file = $this->uploadOnForm($this->module, [
			'path'     => 'test',
			'location' => 'on_site'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('/test/ololo.php');
	}

	/** @test */
	function it_substitute_slash_if_there_is_no_path(){
		$file = $this->uploadOnForm($this->module, [
			'path'     => '',
			'location' => 'on_site'
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('/ololo.php');
	}
}

?>