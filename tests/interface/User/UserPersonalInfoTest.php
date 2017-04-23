<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group user */
class UserPersonalInfoTest extends \TestCase{

	use DatabaseTransactions;

	/** @test */
	function user_can_change_its_main_info(){
		$this->signIn();

		$this->visit('/personal/info');

		$this->submitForm('edit', [
			'name'         => 'Алёна',
			'surname'      => 'Тестова',
			'company_name' => 'SchikButik',
			'partner_code' => 'schikschik',
		]);

		$this->seeInField('name', 'Алёна');
		$this->seeInField('surname', 'Тестова');
		$this->seeInField('company_name', 'SchikButik');
		$this->seeInField('partner_code', 'schikschik');
	}

	/** @test */
	function user_cannot_change_its_email(){
		$this->signIn();
		$this->visit('/personal/info');

		$email = $this->user->email;

		$this->submitForm('edit', [
			'email' => 'ololo@trololo.ru',
		]);

		$this->seeInField('email', $email);
	}

	/** @test */
	function user_cannot_change_its_data_to_empty_fields(){
		$this->signIn();
		$this->visit('/personal/info');

		$first_name = $this->user->first_name;
		$last_name = $this->user->last_name;
		$bitrix_company_name = $this->user->bitrix_company_name;
		$bitrix_partner_code = $this->user->bitrix_partner_code;

		$this->submitForm('edit', [
			'name'         => '',
			'surname'      => '',
			'company_name' => '',
			'partner_code' => '',
		]);

		$this->seeInField('name', $first_name);
		$this->seeInField('surname', $last_name);
		$this->seeInField('company_name', $bitrix_company_name);
		$this->seeInField('partner_code', $bitrix_partner_code);
	}
}

?>