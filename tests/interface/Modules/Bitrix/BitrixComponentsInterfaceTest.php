<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixComponent;

class BitrixComponentsInterfaceTest extends TestCase{

	use DatabaseTransactions;

	protected $path = '/components';
	private $module;

	function setUp(){
		parent::setUp();

		$this->signIn();
		$this->module = $this->createBitrixModule();
	}

	function tearDown(){
		parent::tearDown();
	}

	function createOnForm($module, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.$this->path.'/create');

		if (!isset($inputs['name'])){
			$inputs['name'] = 'ololo';
		}
		if (!isset($inputs['code'])){
			$inputs['code'] = 'trololo';
		}

		$this->submitForm('create_component', $inputs);

		if (isset($inputs['code'])){
			return BitrixComponent::where('code', $inputs['code'])->where('module_id', $module->id)->first();
		}

		return true;
	}

	function deleteComponentFromList($component){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);
		$this->click('delete_component_'.$component->id);
	}

	function deleteComponentFromDetail($component){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path.'/'.$component->id);
		$this->click('delete');
	}

	/** @test */
	function author_can_get_to_this_page(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path);

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_components(){
		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('Компоненты');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function this_is_definitely_page_about_components_en(){
		$this->setLang('en');

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->see('Components');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function unauthorized_cannot_get_to_this_page(){
		$this->logOut();

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal/auth');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function not_author_cannot_get_to_this_page_of_anothers_module(){
		$this->signIn(factory(App\Models\User::class)->create());

		$this->visit('/my-bitrix/'.$this->module->id.$this->path);

		$this->seePageIs('/personal');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_returns_component_data_on_detail_page(){
		$component = $this->createOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '1487',
			'code'      => 'trololo',
			'desc'      => 'My cool component',
			'namespace' => 'dummy',
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/components/'.$component->id);
		$this->see('Heh');
		$this->see('1487');
		$this->see('trololo');
		$this->see('My cool component');
		$this->see('dummy');
	}

	/** @test */
	function it_makes_hello_world_component_instead_of_empty(){
		$component = $this->createOnForm($this->module, [
			'name' => 'Heh',
			'sort' => '1487',
			'code' => 'trololo',
			'desc' => 'My cool component',
		]);

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/components/'.$component->id);
		$this->see('Heh');
		$this->see('1487');
		$this->see('trololo');
		$this->see('My cool component');

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/visual_path');
		$this->seeInField('path_id_1', $this->module->PARTNER_CODE."_".$this->module->code."_components");
		$this->seeInField('path_name_1', $this->module->name);
		$this->seeInField('path_sort_1', '500');

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');
		$this->seeInField('component_php', '<? $this->IncludeComponentTemplate(); ?>');

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/templates');
		$this->see('.default (Дефолтный)');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_can_delete_component_from_detail(){
		$component = $this->createOnForm($this->module);

		$this->deleteComponentFromDetail($component);

		$this->deleteFolder($this->standartModuleCode);

		$this->seePageIs('/my-bitrix/'.$this->module->id.$this->path);

		// todo проверка на отсутствие компонента
	}

	/** @test */
	function it_can_store_visual_path_form(){
		$component = $this->createOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/visual_path');

		$this->submitForm('store_path', [
			'path_id_1'   => 'ololo1',
			'path_name_1' => 'ololo2',
			'path_sort_1' => '500',
			'path_id_2'   => 'trololo1',
			'path_name_2' => 'trololo2',
			'path_sort_2' => '1000',
			'path_id_3'   => 'foo1',
			'path_name_3' => 'foo2',
			'path_sort_3' => '1500',
		]);

		$this->seeInField('path_id_1', 'ololo1');
		$this->seeInField('path_name_1', 'ololo2');
		$this->seeInField('path_sort_1', '500');
		$this->seeInField('path_id_2', 'trololo1');
		$this->seeInField('path_name_2', 'trololo2');
		$this->seeInField('path_sort_2', '1000');
		$this->seeInField('path_id_3', 'foo1');
		$this->seeInField('path_name_3', 'foo2');
		$this->seeInField('path_sort_3', '1500');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_can_store_component_php(){
		$component = $this->createOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/component_php');

		$this->submitForm('save', [
			'component_php' => '<? echo "Hi"; ?>',
		]);

		$this->seeInField('component_php', '<? echo "Hi"; ?>');

		$this->deleteFolder($this->standartModuleCode);
	}
}

?>

