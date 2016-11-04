<?php

use Chumper\Zipper\Zipper;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BitrixDetailPageFilesTest extends BitrixTestCase{

	use DatabaseTransactions;

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
	function it_can_delete_module(){
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('delete');

		$dirs = $this->disk()->directories();
		$this->assertFalse(in_array($this->module->PARTNER_CODE.'.'.$this->module->code, $dirs));
	}

	/** @test */
	function smn_can_download_zip_as_update(){
		$this->payDays(1);
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
		$this->payDays(1);
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('module_download', [
			'version'        => '0.0.2',
			'download_as'    => 'fresh',
			'files_encoding' => 'utf-8',
		]);
		$this->assertFileExists(public_path().'/user_downloads/.last_version.zip');
		unlink(public_path().'/user_downloads/.last_version.zip');
	}

	/** @test */
	function archive_contains_all_files_at_update(){
		$this->payDays(1);
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('module_download', [
			'version'        => '0.0.5',
			'download_as'    => 'update',
			'files_encoding' => 'utf-8',
		]);
		$this->assertFileExists(public_path().'/user_downloads/0.0.5.zip');

		// тут конечно не всё, но главное, чтобы версия совпадала и хоть какие-то файлы были
		$zipper = new Zipper;
		$zipper->make(public_path().'/user_downloads/0.0.5.zip');
		$include_php = $zipper->getFileContent('0.0.5\include.php');
		$install_index_php = $zipper->getFileContent('0.0.5\install\index.php');
		$updater_php = $zipper->getFileContent('0.0.5\updater.php');
		$description_en = $zipper->getFileContent('0.0.5\description.en');
		$version_php = $zipper->getFileContent('0.0.5\install\version.php');
		$zipper->close();

		unlink(public_path().'/user_downloads/0.0.5.zip');

		$this->assertRegExp('/0\.0\.5/is', $version_php);
	}

	/** @test */
	function archive_contains_all_files_at_fresh_download(){
		$this->payDays(1);
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('module_download', [
			'version'        => '0.0.1',
			'download_as'    => 'fresh',
			'files_encoding' => 'utf-8',
		]);
		$this->assertFileExists(public_path().'/user_downloads/.last_version.zip');

		// тут конечно не всё, но главное, чтобы версия совпадала и хоть какие-то файлы были
		$zipper = new Zipper;
		$zipper->make(public_path().'/user_downloads/.last_version.zip');
		$include_php = $zipper->getFileContent('.last_version\include.php');
		$install_index_php = $zipper->getFileContent('.last_version\install\index.php');
		$version_php = $zipper->getFileContent('.last_version\install\version.php');
		$zipper->close();

		unlink(public_path().'/user_downloads/.last_version.zip');

		$this->assertRegExp('/0\.0\.1/is', $version_php); // todo здесь всегд 0.0.1 будет?
	}

	/** @test */
	function archive_contains_folder_starting_with_dot(){
		$this->payDays(1);
		$component = $this->createComponentOnForm($this->module, [
			'name' => 'Heh',
			'sort' => '334',
			'code' => 'ololo',
			'desc' => 'HelloWorld',
		]);
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('module_download', [
			'version'        => '0.0.1',
			'download_as'    => 'fresh',
			'files_encoding' => 'utf-8',
		]);
		$this->assertFileExists(public_path().'/user_downloads/.last_version.zip');

		// проверка, что файл в принципе есть
		$zipper = new Zipper;
		$zipper->make(public_path().'/user_downloads/.last_version.zip');
		$template_php = $zipper->getFileContent('.last_version\install\components\\'.$this->module->full_id.'\ololo\templates\.default\template.php');
		$zipper->close();

		unlink(public_path().'/user_downloads/.last_version.zip');
	}

	/** @test */
	function smn_can_download_zip_as_folder_for_test(){
		$this->payDays(1);
		$this->visit('/my-bitrix/'.$this->module->id);
		$this->submitForm('module_download', [
			'version'        => '0.0.1',
			'download_as'    => 'for_test',
			'files_encoding' => 'utf-8',
		]);
		$this->assertFileExists(public_path().'/user_downloads/'.$this->module->module_folder.'.zip');
		unlink(public_path().'/user_downloads/'.$this->module->module_folder.'.zip');
	}
}

?>