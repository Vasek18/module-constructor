<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class BitrixFormsTest extends TestCase{

	use DatabaseTransactions;

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
			$params['MODULE_NAME'] = 'Ololo';
		}
		if (!isset($params['MODULE_DESCRIPTION'])){
			$params['MODULE_DESCRIPTION'] = 'Ololo trololo';
		}
		if (!isset($params['MODULE_CODE'])){
			$params['MODULE_CODE'] = 'ololo';
		}
		$this->type($params['PARTNER_NAME'], 'PARTNER_NAME');
		$this->type($params['PARTNER_URI'], 'PARTNER_URI');
		$this->type($params['PARTNER_CODE'], 'PARTNER_CODE');
		$this->type($params['MODULE_NAME'], 'MODULE_NAME');
		$this->type($params['MODULE_DESCRIPTION'], 'MODULE_DESCRIPTION');
		$this->type($params['MODULE_CODE'], 'MODULE_CODE');
		$this->type("0.0.1", 'MODULE_VERSION');
		$this->press('module_create');
	}

	/** @test */
	function smn_can_create_module(){
		$this->signIn();

		$this->visit('/construct/bitrix');
		$this->fillNewBitrixForm();

		if (Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->count()){
			$module = Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->first();
			Bitrix::deleteFolder($module);
		}

		$this->seeInDatabase('bitrixes', [
			'MODULE_CODE'  => "ololo",
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->visit('/construct/bitrix');
		$this->seePageIs('/personal/auth');
	}


	/** @test */
	function it_substitute_user_data(){
		$this->signIn();

		$this->visit('/construct/bitrix')
			->see($this->user->bitrix_company_name)
			->see($this->user->site)
			->see($this->user->bitrix_partner_code);

	}

	/** @test */
	function it_doesnt_create_module_without_partner_name(){
		$this->signIn();

		$this->visit('/construct/bitrix');
		$this->fillNewBitrixForm(['PARTNER_NAME' => '']);

		if (Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->count()){
			$module = Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->first();
			Bitrix::deleteFolder($module);
		}

		$this->dontSeeInDatabase('bitrixes', [
			'MODULE_CODE'  => "ololo",
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);

		$this->see('Поле p a r t n e r  n a m e обязательно.');
	}

	/** @test */
	function it_doesnt_create_module_without_partner_uri(){
		$this->signIn();

		$this->visit('/construct/bitrix');
		$this->fillNewBitrixForm(['PARTNER_URI' => '']);

		if (Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->count()){
			$module = Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->first();
			Bitrix::deleteFolder($module);
		}

		$this->dontSeeInDatabase('bitrixes', [
			'MODULE_CODE'  => "ololo",
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);

		$this->see('Поле p a r t n e r  u r i обязательно.');
	}

	/** @test */
	function it_doesnt_create_module_without_partner_code(){
		$this->signIn();

		$this->visit('/construct/bitrix');
		$this->fillNewBitrixForm(['PARTNER_CODE' => '']);

		if (Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->count()){
			$module = Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->first();
			Bitrix::deleteFolder($module);
		}

		$this->dontSeeInDatabase('bitrixes', [
			'MODULE_CODE'  => "ololo",
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);

		$this->see('Поле p a r t n e r  c o d e обязательно.');
	}

	/** @test */
	function it_doesnt_create_module_without_module_name(){
		$this->signIn();

		$this->visit('/construct/bitrix');
		$this->fillNewBitrixForm(['MODULE_NAME' => '']);

		if (Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->count()){
			$module = Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->first();
			Bitrix::deleteFolder($module);
		}

		$this->dontSeeInDatabase('bitrixes', [
			'MODULE_CODE'  => "ololo",
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);

		$this->see('Поле m o d u l e  n a m e обязательно.');
	}

	/** @test */
	function it_doesnt_create_module_without_module_code(){
		$this->signIn();

		$this->visit('/construct/bitrix');
		$this->fillNewBitrixForm(['MODULE_CODE' => '']);

		if (Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->count()){
			$module = Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->first();
			Bitrix::deleteFolder($module);
		}

		$this->dontSeeInDatabase('bitrixes', [
			'MODULE_CODE'  => "ololo",
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);

		$this->see('Поле m o d u l e  c o d e обязательно.');
	}

	///** @test */
	//function it_returns_an_error_when_a_pair_of_user_code_and_module_code_are_not_unique(){
	//
	//}
	//
	///** @test */
	//function it_trims_fields(){
	//
	//}
}

?>