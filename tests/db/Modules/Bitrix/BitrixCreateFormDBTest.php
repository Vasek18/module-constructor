<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class BitrixCreateFormDBTest extends TestCase{

	use DatabaseTransactions;

	protected $standartModuleName = 'Ololo';
	protected $standartModuleDescription = 'Ololo trololo';
	protected $standartModuleCode = 'ololo_from_test';
	protected $standartModuleVersion = '0.0.1';

	function fillNewBitrixForm($params = Array()){
		if (!isset($params['PARTNER_NAME'])){
			$params['PARTNER_NAME'] = $this->user->bitrix_company_name;
		}
		if (!isset($params['PARTNER_URI'])){
			$params['PARTNER_URI'] = $this->user->site;
		}
		if (!isset($params['PARTNER_CODE'])){
			$params['PARTNER_CODE'] = $this->user->bitrix_partner_code;
		}
		if (!isset($params['MODULE_NAME'])){
			$params['MODULE_NAME'] = $this->standartModuleName;
		}
		if (!isset($params['MODULE_DESCRIPTION'])){
			$params['MODULE_DESCRIPTION'] = $this->standartModuleDescription;
		}
		if (!isset($params['MODULE_CODE'])){
			$params['MODULE_CODE'] = $this->standartModuleCode;
		}
		if (!isset($params['MODULE_VERSION'])){
			$params['MODULE_VERSION'] = $this->standartModuleVersion;
		}

		$this->visit('/my-bitrix/create');

		$this->type($params['PARTNER_NAME'], 'PARTNER_NAME');
		$this->type($params['PARTNER_URI'], 'PARTNER_URI');
		$this->type($params['PARTNER_CODE'], 'PARTNER_CODE');
		$this->type($params['MODULE_NAME'], 'MODULE_NAME');
		$this->type($params['MODULE_DESCRIPTION'], 'MODULE_DESCRIPTION');
		$this->type($params['MODULE_CODE'], 'MODULE_CODE');
		$this->type($params['MODULE_VERSION'], 'MODULE_VERSION');
		$this->press('module_create');
	}

	/** @test */
	function smn_can_create_module(){
		$this->signIn();

		$this->fillNewBitrixForm();

		$this->deleteFolder($this->standartModuleCode);

		$this->seeInDatabase('bitrixes', [
			'code'         => $this->standartModuleCode,
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);
	}

	/** @test */
	function it_writes_all_fields_right(){
		$this->signIn();

		$this->fillNewBitrixForm();

		$this->deleteFolder($this->standartModuleCode);

		$this->seeInDatabase('bitrixes', [
			'name'         => $this->standartModuleName,
			'code'         => $this->standartModuleCode,
			'description'  => $this->standartModuleDescription,
			'version'      => $this->standartModuleVersion,
			'user_id'      => $this->user->id,
			'PARTNER_CODE' => $this->user->bitrix_partner_code,
			'PARTNER_NAME' => $this->user->bitrix_company_name,
			'PARTNER_URI'  => $this->user->site,
		]);
	}

	/** @test */
	function it_completes_user_profile(){
		$user = factory(App\Models\User::class)->create(['bitrix_company_name' => null, 'bitrix_partner_code' => null, 'site' => null]);
		$this->signIn($user);

		$this->fillNewBitrixForm([
			'PARTNER_NAME' => 'Vasya',
			'PARTNER_CODE' => 'vs',
			'PARTNER_URI'  => 'http://ololotrololo.com'
		]);

		$creator = User::find($user->id);

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals("Vasya", $creator->bitrix_company_name);
		$this->assertEquals("vs", $creator->bitrix_partner_code);
		$this->assertEquals("http://ololotrololo.com", $creator->site);
	}

	/** @test */
	function it_doesnt_create_module_without_partner_name(){
		$this->signIn();

		$this->fillNewBitrixForm(['PARTNER_NAME' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->dontSeeInDatabase('bitrixes', [
			'code'         => $this->standartModuleCode,
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);
	}

	/** @test */
	function it_doesnt_create_module_without_partner_uri(){
		$this->signIn();

		$this->fillNewBitrixForm(['PARTNER_URI' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->dontSeeInDatabase('bitrixes', [
			'code'         => $this->standartModuleCode,
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);
	}

	/** @test */
	function it_doesnt_create_module_without_partner_code(){
		$this->signIn();

		$this->fillNewBitrixForm(['PARTNER_CODE' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->dontSeeInDatabase('bitrixes', [
			'code'         => $this->standartModuleCode,
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);
	}

	/** @test */
	function it_doesnt_create_module_without_module_name(){
		$this->signIn();

		$this->fillNewBitrixForm(['MODULE_NAME' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->dontSeeInDatabase('bitrixes', [
			'code'         => $this->standartModuleCode,
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);
	}

	/** @test */
	function it_doesnt_create_module_without_module_code(){
		$this->signIn();

		$this->fillNewBitrixForm(['MODULE_CODE' => '']);

		$this->deleteFolder('');

		$this->dontSeeInDatabase('bitrixes', [
			'code'         => "",
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);
	}

	/** @test */
	function it_doesnt_create_module_without_module_version(){
		$this->signIn();

		$this->fillNewBitrixForm(['MODULE_VERSION' => '']);

		$this->deleteFolder($this->standartModuleCode);

		$this->dontSeeInDatabase('bitrixes', [
			'code'         => $this->standartModuleCode,
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);
	}

	/** @test */
	function it_doesnt_create_module_when_a_pair_of_user_code_and_module_code_are_not_unique(){
		$this->signIn();

		$this->fillNewBitrixForm();
		$this->fillNewBitrixForm();

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals(1, DB::table('bitrixes')->where('code', $this->standartModuleCode)->where('PARTNER_CODE', $this->user->bitrix_partner_code)->count());
	}

	/** @test */
	function it_trims_fields(){
		$this->signIn();

		$this->fillNewBitrixForm([
			'MODULE_NAME'        => '  Test   ',
			'MODULE_DESCRIPTION' => '  Test   ',
			'MODULE_CODE'        => '  ololo_from_test   ',
			'PARTNER_NAME'       => '  Test   ',
			'PARTNER_URI'        => '  Test   ',
			'PARTNER_CODE'       => '  Test   ',
			'MODULE_VERSION'     => '  0.0.1   '
		]);

		$this->deleteFolder('ololo_from_test');

		$this->seeInDatabase('bitrixes', [
			'name'         => 'Test',
			'description'  => 'Test',
			'code'         => 'ololo_from_test',
			'PARTNER_NAME' => 'Test',
			'PARTNER_URI'  => 'Test',
			'PARTNER_CODE' => 'Test',
			'version'      => '0.0.1'
		]);
	}

	/** @test */
	function it_validates_version_field_from_nondigits(){
		$this->signIn();

		$this->fillNewBitrixForm([
			'MODULE_VERSION' => '  Test   '
		]);

		$this->deleteFolder('ololo_from_test');

		$this->seeInDatabase('bitrixes', [
			'code'         => $this->standartModuleCode,
			'PARTNER_CODE' => $this->user->bitrix_partner_code,
			'version'      => '0.0.1'
		]);
	}

	/** @test */
	function it_validates_version_field_from_all_zeros(){
		$this->signIn();

		$this->fillNewBitrixForm([
			'MODULE_VERSION' => '  0.0.0'
		]);

		$this->deleteFolder('ololo_from_test');

		$this->seeInDatabase('bitrixes', [
			'code'         => $this->standartModuleCode,
			'PARTNER_CODE' => $this->user->bitrix_partner_code,
			'version'      => '0.0.1'
		]);
	}
}

?>