<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group admin */
class AdminModulesTest extends TestCase{

	use DatabaseTransactions;

	protected $path = 'modules';

	protected $adminUserGroup = 1;
	protected $defaultUserGroup = 2;

	/** @test */
	function common_user_cant_get_to_admin_page(){
		$this->signIn();

		$this->visit('/oko/'.$this->path);

		$this->seePageIs('/personal');
	}

	/** @test */
	function admin_user_can_get_to_admin_page(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/oko/'.$this->path);

		$this->seePageIs('/oko/'.$this->path);
	}

	/** @test */
	function there_are_shown_modules_from_various_users(){
		$module = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();
		$module2 = factory(App\Models\Modules\Bitrix\Bitrix::class)->create();

		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/oko/'.$this->path);

		$this->see($module->name);
		$this->see($module2->name);
	}

}

?>