<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends \TestCase{

	use DatabaseTransactions;

	protected $adminUserGroup = 1;
	protected $defaultUserGroup = 2;

	/** @test */
	function unauthorized_cant_get_to_admin_page(){
		$this->visit('/oko');

		$this->seePageIs('/personal/auth');
	}

	/** @test */
	function common_user_cant_get_to_admin_page(){
		$this->signIn();

		$this->visit('/oko');

		$this->seePageIs('/personal');
	}

	/** @test */
	function admin_user_can_get_to_admin_page(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/oko');

		$this->seePageIs('/oko');
	}

}

?>