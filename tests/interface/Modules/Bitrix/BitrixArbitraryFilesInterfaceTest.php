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
		$this->module = $this->fillNewBitrixForm();
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

	function changeFile($module, $file, $inputs){
		$this->visit('/my-bitrix/'.$module->id.$this->path);
		if (isset($inputs['filename'])){
			$this->type($inputs['filename'], 'filename_'.$file->id);
		}
		if (isset($inputs['location'])){
			$this->select($inputs['location'], 'location_'.$file->id);
		}
		if (isset($inputs['path'])){
			$this->type($inputs['path'], 'path_'.$file->id);
		}
		if (isset($inputs['code'])){
			$this->type($inputs['code'], 'code_'.$file->id);
		}
		$this->press('save_'.$file->id);
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

	/** @test */
	function it_returns_changed_params_and_content_of_file(){
		$file = $this->uploadOnForm($this->module, [
			'path'     => '/lib/',
			'location' => 'in_module'
		]);

		$this->changeFile($this->module, $file, [
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