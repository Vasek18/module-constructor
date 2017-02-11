<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group admin */
class AdminUsersTest extends TestCase{

	use DatabaseTransactions;

	protected $adminUserGroup = 1;
	protected $defaultUserGroup = 2;

	/** @test */
	function common_user_cant_get_to_admin_page(){
		$this->signIn();

		$this->visit('/oko/users');

		$this->seePageIs('/personal');
	}

	/** @test */
	function admin_user_can_get_to_admin_page(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/oko/users');

		$this->seePageIs('/oko/users');
	}

	/** @test */
	function there_is_shown_users_count(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$usersCount = User::count();

		$this->visit('/oko/users');

		$this->see('<span class="userCount">'.$usersCount.'</span>');
	}

	/** @test */
	function there_is_shown_users_names_and_emails(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$users = User::all();

		$this->visit('/oko/users');

		foreach ($users as $user){ // их здесь всего два, так что по всем идём
			$this->see($user->first_name);
			$this->see($user->email);
		}
	}

	/** @test */
	function there_is_shown_user_info_and_modules_on_detail(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$user = User::first();
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create(['user_id' => $user->id]);

		$this->visit('/oko/users/'.$user->id);

		$this->see($user->first_name);
		$this->see($user->created_at);
		$this->see($module->name);
		$this->see($module->code);
	}

	/** @test */
	function admin_can_change_paid_days_for_users(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$user = User::first();
		$this->visit('/oko/users/'.$user->id);

		$this->submitForm('save', [
			'paid_days' => 14
		]);

		$this->seeInField('paid_days', 14);
	}

	/** @test */
	function admin_can_delete_user(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();
		$user = User::first();

		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/oko/modules');
		$this->see($module->name);

		$this->visit('/oko/users/'.$user->id);
		$this->click('deleteUser');

		$this->visit('/oko/modules');
		$this->dontSee($module->name);
	}
}

?>