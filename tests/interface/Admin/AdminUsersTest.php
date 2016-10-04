<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminUsersTest extends TestCase{

	use DatabaseTransactions;

	protected $adminUserGroup = 1;
	protected $defaultUserGroup = 2;

	/** @test */
	function common_user_cant_get_to_admin_page(){
		$this->signIn();

		$this->visit('/admin/users');

		$this->seePageIs('/personal');
	}

	/** @test */
	function admin_user_can_get_to_admin_page(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/admin/users');

		$this->seePageIs('/admin');
	}

	/** @test */
	// function there_is_shown_users_count(){ todo
	// 	$usersCount = User::count();
	//
	// 	$this->signIn(null, [
	// 		'group_id' => $this->adminUserGroup
	// 	]);
	//
	// 	$this->visit('/admin/users');
	//
	// 	$this->assertNotFalse(strpos($this->response->getContent(), '<span class="userCount">'.$usersCount.'</span>'));
	// }

}

?>