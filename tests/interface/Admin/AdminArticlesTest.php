<?php

use App\Models\ArticleSection;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminArticlesTest extends TestCase{

	use DatabaseTransactions;

	protected $path = 'articles';

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
	function it_shows_all_categories(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$section1 = ArticleSection::create([
			'code' => 'test',
			'name' => 'Тестовая категория',
		]);

		$section2 = ArticleSection::create([
			'code' => 'ololo',
			'name' => 'Ещё категория',
		]);

		$this->visit('/oko/'.$this->path);

		$this->see('Тестовая категория');
		$this->see('Ещё категория');
	}
}