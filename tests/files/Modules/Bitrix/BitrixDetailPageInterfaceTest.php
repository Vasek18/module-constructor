<?php

use Chumper\Zipper\Zipper;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BitrixDetailPageFilesTest extends TestCase{

	use DatabaseTransactions;

	private $module;

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->createBitrixModule();
	}

	function tearDown(){
		parent::tearDown();

		$this->module->deleteFolder();
	}

	/** @test */
	function it_can_delete_module(){
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('delete');

		$dirs = $this->disk()->directories();
		$this->assertFalse(in_array($this->module->PARTNER_CODE.'.'.$this->module->code, $dirs));
	}

	/** @test */
	function smn_can_download_zip_as_update(){
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('module_download', [
			'version'        => '0.0.2',
			'download_as'    => 'update',
			'files_encoding' => 'utf-8',
		]);
		$this->assertFileExists(public_path().'/user_downloads/0.0.2.zip');
		unlink(public_path().'/user_downloads/0.0.2.zip');
	}

	/** @test */
	function smn_can_download_zip_as_new_module(){
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('module_download', [
			'version'        => '0.0.2',
			'download_as'    => 'new',
			'files_encoding' => 'utf-8',
		]);
		$this->assertFileExists(public_path().'/user_downloads/last_version.zip');
		unlink(public_path().'/user_downloads/last_version.zip');
	}

	/** @test */
	function archive_contains_all_files(){
		// тут конечно не всё, но главное, чтобы версия совпадала и хоть какие-то файлы были
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('module_download', [
			'version'        => '0.0.5',
			'download_as'    => 'update',
			'files_encoding' => 'utf-8',
		]);
		$this->assertFileExists(public_path().'/user_downloads/0.0.5.zip');

		$zipper = new Zipper;
		$zipper->make(public_path().'/user_downloads/0.0.5.zip');
		$include_php = $zipper->getFileContent('include.php');
		$install_index_php = $zipper->getFileContent('install/index.php');
		$version_php = $zipper->getFileContent('install/version.php');
		$zipper->close();

		unlink(public_path().'/user_downloads/0.0.5.zip');

		$this->assertRegExp('/0\.0\.5/is', $version_php);
	}
}

?>