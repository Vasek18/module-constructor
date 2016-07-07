<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class BitrixArbitraryFilesInterfaceTest extends TestCase{

	use DatabaseTransactions;

	protected $path = '/arbitrary_files';
	private $file;

	function setUp(){
		parent::setUp();

		// file_put_contents(public_path().'/ololo.php', 'ololo');

		// $this->file = new \Illuminate\Http\UploadedFile(
		// 	public_path().'/ololo.php',
		// 	'ololo.php'
		// );
	}

	function tearDown(){
		parent::tearDown();

		// unlink(public_path().'/ololo.php');
	}

	function uploadOnForm($module, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.$this->path);

		if (!isset($inputs['path'])){
			$inputs['path'] = '/';
		}
		// if (!isset($inputs['file'])){
		// 	$inputs['file'] = $this->file;
		// }
		if (!isset($inputs['location'])){
			$inputs['location'] = 'in_module';
		}

		$this->submitForm('upload', $inputs);
		//
		// if (isset($inputs['code'])){
		// 	return BitrixAdminMenuItems::where('code', $inputs['code'])->where('module_id', $module->id)->first();
		// }

		return true;
	}

	function removeFile($module, $amp){
		$this->visit('/my-bitrix/'.$module->id.$this->path);
		$this->click('delete_amp_'.$amp->id);
	}

	/** @test */
	function author_can_get_to_this_page(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->visit('/my-bitrix/'.$module->id.$this->path);

		$this->seePageIs('/my-bitrix/'.$module->id.$this->path);

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_arbitrary_files(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->visit('/my-bitrix/'.$module->id.$this->path);

		$this->see('Произвольные файлы');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_arbitrary_files_en(){
		$this->signIn();
		$this->setLang('en');
		$module = $this->createBitrixModule();

		$this->visit('/my-bitrix/'.$module->id.$this->path);

		$this->see('Arbitrary files');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->logOut();

		$this->visit('/my-bitrix/'.$module->id.$this->path);

		$this->seePageIs('/personal/auth');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn();
		$module = $this->createBitrixModule();

		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$module->id.$this->path);

		$this->seePageIs('/personal');

		$this->deleteFolder($this->standartModuleCode);
	}

	// /** @test */
	// function it_uploads_file(){
	// 	$this->signIn();
	// 	$module = $this->createBitrixModule();
	//
	// 	$this->uploadOnForm($module);
	// }

}

?>