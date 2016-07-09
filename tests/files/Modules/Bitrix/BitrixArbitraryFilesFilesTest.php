<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixArbitraryFiles;

class BitrixArbitraryFilesFilesTest extends TestCase{

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
		$this->click('delete_af_'.$amp->id);
	}

	/** @test */
	function it_uploads_file(){
		$file = $this->uploadOnForm($this->module, [
			'location' => 'on_site'
		]);

		$this->assertFileExists($this->module->getFolder().'/install/files/ololo.php');
		$this->assertStringEqualsFile($this->module->getFolder().'/install/files/ololo.php', 'ololo');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_substitute_slash_if_there_is_no_path(){
		$file = $this->uploadOnForm($this->module, [
			'path'     => '',
			'location' => 'on_site'
		]);

		$this->assertFileExists($this->module->getFolder().'/install/files/ololo.php');
		$this->assertStringEqualsFile($this->module->getFolder().'/install/files/ololo.php', 'ololo');

		$this->deleteFolder($this->standartModuleCode);

	}

	/** @test */
	function it_deletes_dots_in_path(){
		$file = $this->uploadOnForm($this->module, [
			'path'     => '/../',
			'location' => 'on_site'
		]);

		$this->assertFileNotExists($this->module->getFolder().'/install/ololo.php');
		$this->assertFileExists($this->module->getFolder().'/install/files/ololo.php');
		$this->assertStringEqualsFile($this->module->getFolder().'/install/files/ololo.php', 'ololo');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_can_save_file_that_will_be_not_installed_on_site_but_exist_in_module_folder(){
		$file = $this->uploadOnForm($this->module, [
			'path'     => '/lib/',
			'location' => 'in_module'
		]);

		$this->assertFileNotExists($this->module->getFolder().'/install/files/lib/ololo.php');
		$this->assertFileExists($this->module->getFolder().'/lib/ololo.php');
		$this->assertStringEqualsFile($this->module->getFolder().'/lib/ololo.php', 'ololo');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function you_can_change_params_and_content_of_file(){
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

		$this->assertFileExists($this->module->getFolder().'/install/files/testpath/vasya.php');
		$this->assertFileNotExists($this->module->getFolder().'/lib/ololo.php');
		$this->assertStringEqualsFile($this->module->getFolder().'/install/files/testpath/vasya.php', 'Vasya the creator');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function you_can_delete_file(){
		$file = $this->uploadOnForm($this->module, [
			'path'     => '/lib/',
			'location' => 'in_module'
		]);

		$this->removeFile($this->module, $file);

		$this->assertFileNotExists($this->module->getFolder().'/lib/ololo.php');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_rewrites_content_of_file_in_case_of_conflict(){
		$file = $this->uploadOnForm($this->module, [
			'path'     => '/lib/',
			'location' => 'in_module'
		]);

		$this->changeFile($this->module, $file, [
			'code' => 'Vasya the creator',
		]);

		$this->uploadOnForm($this->module, [
			'path'     => '/lib/',
			'location' => 'in_module'
		]);

		$this->assertFileExists($this->module->getFolder().'/lib/ololo.php');
		$this->assertStringEqualsFile($this->module->getFolder().'/lib/ololo.php', 'ololo');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_clears_empty_folders(){
		$file = $this->uploadOnForm($this->module, [
			'path'     => '/my_files/',
			'location' => 'in_module'
		]);

		$this->removeFile($this->module, $file);

		$this->assertFileNotExists($this->module->getFolder().'/my_files/ololo.php');
		$this->assertFalse(is_dir($this->module->getFolder().'/my_files/'));

		$this->deleteFolder($this->standartModuleCode);
	}
}

?>