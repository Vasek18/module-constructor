<?php

use App\Models\Modules\Bitrix\BitrixComponentClassPhpTemplates;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/** @group admin */
class AdminBitrixClassPhpTemplatesTest extends TestCase{

	use DatabaseTransactions;

	protected $adminUserGroup = 1;
	protected $defaultUserGroup = 2;
	protected $path = '/oko/bitrix_class_php_templates';
	protected $classPhpTemplateFishName = 'ololo_template';

	public function createClassPhpTemplate($params = Array()){
		if (!isset($params["name"]) || !$params["name"]){
			$params["name"] = $this->classPhpTemplateFishName;
		}
		BitrixComponentClassPhpTemplates::create($params);
	}

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
	function it_shows_public_templates_on_specific_page(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->createClassPhpTemplate([
			'show_everyone' => true
		]);
		$this->createClassPhpTemplate([
			'name'          => 'ololo_private_template',
			'show_everyone' => false,
		]);

		$this->visit($this->path);

		$this->see($this->classPhpTemplateFishName);
		$this->dontSee('ololo_private_template');
	}

	/** @test */
	function it_shows_private_templates_on_specific_page(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->createClassPhpTemplate([
			'show_everyone' => true
		]);
		$this->createClassPhpTemplate([
			'name'          => 'ololo_private_template',
			'show_everyone' => false,
		]);

		$this->visit($this->path.'/private_ones');
		$this->dontSee($this->classPhpTemplateFishName);
		$this->see('ololo_private_template');
	}
}

?>