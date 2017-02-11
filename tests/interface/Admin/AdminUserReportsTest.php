<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group admin */
class AdminUserReportsTest extends TestCase{

	use DatabaseTransactions;

	protected $adminUserGroup = 1;
	protected $defaultUserGroup = 2;

	protected $path = '/oko/user_reports';

	/** @test */
	function common_user_cant_get_to_admin_page(){
		$this->signIn();

		$this->visit($this->path);

		$this->seePageIs('/personal');
	}

	/** @test */
	function admin_user_can_get_to_admin_page(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit($this->path);

		$this->seePageIs($this->path);
	}

	/** @test */
	function unauthorized_can_send_bug_report(){
		$this->visit('/');
		$this->sendBugReport([
			'text' => 'Я нашёл баг ололо'
		]);

		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit($this->path);

		$this->see('Я нашёл баг ололо');
	}

	/** @test */
	function authorized_can_send_bug_report(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/');
		$this->sendBugReport([
			'text' => 'Я нашёл баг ололо'
		]);

		$this->visit($this->path);

		$this->see('Я нашёл баг ололо');
	}
}

?>