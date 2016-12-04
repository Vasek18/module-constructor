<?php

use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminSettingsTest extends TestCase{

	use DatabaseTransactions;

	protected $path = 'settings';

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
	function it_shows_all_settings(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/oko/'.$this->path);

		// эти настройки создаются прямо в миграции
		$this->see('demo_days');
		$this->see('day_price');
	}

	/** @test */
	function it_can_set_setting_value(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/oko/'.$this->path);

		$this->assertEquals(2, setting('demo_days'));

		$this->submitForm('save_demo_days', [
			'value' => '5',
		]);

		$this->assertEquals(5, setting('demo_days'));
	}

	/** @test */
	function it_can_create_setting(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/oko/'.$this->path);

		$this->submitForm('create', [
			'name'  => 'Тест',
			'code'  => 'test',
			'value' => '1487',
		]);

		$this->see('Тест');
		$this->see('1487');
	}

}