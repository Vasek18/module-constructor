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

	function createOnForm($module, $params = []){
		$this->visit('/my-bitrix/'.$module->id.$this->path.'/create');
		$inputs = [];

		if (!isset($params['name'])){
			$inputs['COMPONENT_NAME'] = 'Test';
		}else{
			$inputs['COMPONENT_NAME'] = $params['name'];
		}
		if (!isset($params['code'])){
			$inputs['COMPONENT_CODE'] = 'ololo';
			$params['code'] = 'ololo';
		}else{
			$inputs['COMPONENT_CODE'] = $params['code'];
		}
		if (isset($params['sort'])){
			$inputs['COMPONENT_SORT'] = $params['sort'];
		}
		if (isset($params['desc'])){
			$inputs['COMPONENT_DESCRIPTION'] = $params['desc'];
		}
		if (isset($params['namespace'])){
			$inputs['COMPONENT_NAMESPACE'] = $params['namespace'];
		}

		$this->submitForm('create_component', $inputs);

		if (isset($params['code'])){
			return BitrixComponent::where('code', $params['code'])->where('module_id', $module->id)->first();
		}

		return true;
	}

	function removeComponent($module, $amp){
		$this->visit('/my-bitrix/'.$module->id.$this->path);
		$this->click('delete_amp_'.$amp->id);
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
		// $this->see('dummy');
	}
}

?>