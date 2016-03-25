<?php

use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class BitrixFormsTest extends TestCase{

	use DatabaseTransactions;

	/** @test */
	function smn_can_create_module(){
		$this->signIn();

		$this->visit('/construct/bitrix');
		$this->type($this->user->bitrix_company_name, 'PARTNER_NAME');
		$this->type($this->user->site, 'PARTNER_URI');
		$this->type($this->user->bitrix_partner_code, 'PARTNER_CODE');
		$this->type("Ololo", 'MODULE_NAME');
		$this->type("Ololo trololo", 'MODULE_DESCRIPTION');
		$this->type("ololo", 'MODULE_CODE');
		$this->type("0.0.1", 'MODULE_VERSION');
		$this->press('module_create');

		$this->seeInDatabase('bitrixes', [
			'MODULE_CODE'  => "ololo",
			'PARTNER_CODE' => $this->user->bitrix_partner_code
		]);

		//$module = Bitrix::where('MODULE_CODE', 'ololo')->where('PARTNER_CODE', $this->user->bitrix_partner_code)->get();
		//Bitrix::deleteFolder($module);
	}

	/** @test */
	function it_substitute_user_data(){
		$this->signIn();

		$this->visit('/construct/bitrix')
		->see($this->user->bitrix_company_name)
		->see($this->user->site)
		->see($this->user->bitrix_partner_code);

	}

	///** @test */
	//function it_doesnt_create_module_without_required_fields(){
	//
	//}
	//
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