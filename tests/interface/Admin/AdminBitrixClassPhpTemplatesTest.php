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

		return BitrixComponentClassPhpTemplates::create($params);
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

	/** @test */
	function it_can_add_template(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit($this->path);

		$this->submitForm('add', [
			'name'     => 'new_template',
			'template' => 'echo "ololo";',
		]);

		$this->seePageIs($this->path);
		$this->see('new_template');
		$this->see('echo "ololo";');
	}

	/** @test */
	function it_can_delete_template(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$template = $this->createClassPhpTemplate([
			'show_everyone' => true,
			'name'          => 'new_template'
		]);

		// проверяем, что шаблон добавился
		$this->visit($this->path);
		$this->see('new_template');

		// удаляем шаблон
		$this->click('delete'.$template->id);
		// проверяем, что он удалился
		$this->seePageIs($this->path);
		$this->dontSee('new_template');
	}

	/** @test */
	function it_can_edit_template(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$template = $this->createClassPhpTemplate([
			'show_everyone' => true,
			'name'          => 'new_template',
			'template'      => 'echo "ololo";',
		]);
		// проверяем, что шаблон добавился, и тех значений, на которые мы хотим менять нет
		$this->visit($this->path);
		$this->see('new_template');
		$this->see('echo "ololo";');
		$this->dontSee('edited_template');
		$this->dontSee('echo "trololo";');

		// идём на редактирование
		$this->click('edit'.$template->id);
		// редактируем
		$this->submitForm('update', [
			'name'     => 'edited_template',
			'template' => 'echo "trololo";',
		]);
		// проверяем, что он данные изменились и мы на индексной
		$this->seePageIs($this->path);
		$this->dontSee('new_template');
		$this->dontSee('echo "ololo";');
		$this->See('edited_template');
		$this->See('echo "trololo";');
	}
}

?>