<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

/** @group admin */
class AdminConfirmsTest extends TestCase{

	use DatabaseTransactions;

	protected $adminUserGroup = 1;
	protected $defaultUserGroup = 2;
	protected $path = '/oko/confirms';

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
	function admin_user_can_approve_module(){
		$module = $this->create_unapproved_module();

		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit($this->path);

		$this->click('approve_module'.$module->id);

		$count = DB::table('bitrix_core_modules')->where([
			'code'     => 'testModule',
			'approved' => true,
		])->count();

		$this->assertEquals(1, $count);
	}

	/** @test */
	function admin_user_can_delete_module(){
		$module = $this->create_unapproved_module();

		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit($this->path);

		$this->click('delete_module'.$module->id);

		$count = DB::table('bitrix_core_modules')->where([
			'code' => 'testModule',
		])->count();

		$this->assertEquals(0, $count);
	}

	/** @test */
	function admin_user_can_approve_event(){
		$event = $this->create_unapproved_event();

		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit($this->path);

		$this->click('approve_event'.$event->id);

		$count = DB::table('bitrix_core_events')->where([
			'code'     => 'OnProlog',
			'approved' => true,
		])->count();

		$this->assertEquals(1, $count);
	}

	/** @test */
	function admin_user_can_approve_marked_event(){
		$event = $this->create_marked_event();

		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit($this->path);

		$this->click('approve_event'.$event->id);

		$count = DB::table('bitrix_core_events')->where([
			'code'   => 'OnProlog',
			'is_bad' => false,
		])->count();

		$this->assertEquals(1, $count);
	}

	/** @test */
	function admin_user_can_delete_event(){
		$event = $this->create_unapproved_event();

		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit($this->path);

		$this->click('delete_event'.$event->id);

		$count = DB::table('bitrix_core_events')->where([
			'code' => 'OnProlog',
		])->count();

		$this->assertEquals(0, $count);
	}

}

?>