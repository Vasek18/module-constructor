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

	function removeFile($module, $amp){
		$this->visit('/my-bitrix/'.$module->id.$this->path);
		$this->click('delete_amp_'.$amp->id);
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

}

?>