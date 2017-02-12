<?php

use App\Models\ProjectPulsePost;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group admin */
class AdminProjectPulseTest extends TestCase{

	use DatabaseTransactions;

	protected $adminUserGroup = 1;
	protected $defaultUserGroup = 2;

	protected $path = '/oko/project_pulse';

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
	function admin_can_create_project_pulse_post(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit($this->path);

		$this->submitForm('save', [
			'name'        => 'Большая новость',
			'description' => 'Это очень важная новость',
		]);

		$this->visit('project_pulse');
		$this->see('Большая новость');
		$this->see('Это очень важная новость');
	}

	/** @test */
	function admin_can_delete_project_pulse_post_on_public_page(){
		$post = ProjectPulsePost::create([
			'name'        => 'Большая новость',
			'description' => 'Это очень важная новость',
		]);

		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		// видим на странице пост
		$this->visit('project_pulse');
		$this->see('Большая новость');
		$this->see('Это очень важная новость');

		// удаляем пост
		$this->click('delete'.$post->id);
		$this->dontSee('Большая новость');
		$this->dontSee('Это очень важная новость');
	}

	/** @test */
	function not_admin_cannot_delete_project_pulse_post(){
		$post = ProjectPulsePost::create([
			'name'        => 'Большая новость',
			'description' => 'Это очень важная новость',
		]);

		// видим на странице пост
		$this->visit('project_pulse');
		$this->see('Большая новость');
		$this->see('Это очень важная новость');

		// но не видим кнопки
		$this->dontSee('delete'.$post->id);

		// пробуем удалить напрямую // todo
		$this->call('GET', '/project_pulse/'.$post->id.'/delete');
		$this->assertResponseStatus(404);

		// но пост всё равно есть
		$this->visit('project_pulse');
		$this->see('Большая новость');
		$this->see('Это очень важная новость');
	}
}

?>