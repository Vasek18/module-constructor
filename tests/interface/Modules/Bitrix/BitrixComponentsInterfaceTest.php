<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Models\Modules\Bitrix\BitrixComponentsParams;
use App\Models\Modules\Bitrix\BitrixComponentsTemplates;

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

	function createComponentParamOnForm($component, $rowNumber, $params){
		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/params');
		$inputs = [];
		if (isset($params['name'])){
			$inputs['param_name['.$rowNumber.']'] = $params['name'];
		}
		if (isset($params['code'])){
			$inputs['param_code['.$rowNumber.']'] = $params['code'];
		}
		if (isset($params['type'])){
			$inputs['param_type['.$rowNumber.']'] = $params['type'];
		}
		if (isset($params['refresh'])){
			$inputs['param_refresh['.$rowNumber.']'] = $params['refresh'];
		}
		if (isset($params['multiple'])){
			$inputs['param_multiple['.$rowNumber.']'] = $params['multiple'];
		}
		if (isset($params['cols'])){
			$inputs['param_cols['.$rowNumber.']'] = $params['cols'];
		}
		if (isset($params['size'])){
			$inputs['param_size['.$rowNumber.']'] = $params['size'];
		}
		if (isset($params['default'])){
			$inputs['param_default['.$rowNumber.']'] = $params['default'];
		}
		if (isset($params['additional_values'])){
			$inputs['param_additional_values['.$rowNumber.']'] = $params['additional_values'];
		}
		if (isset($params['vals_key0'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['param_'.($rowNumber).'_vals_key[0]'] = $params['vals_key0'];
		}
		if (isset($params['vals_value0'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['param_'.($rowNumber).'_vals_value[0]'] = $params['vals_value0'];
		}
		if (isset($params['vals_key1'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['param_'.($rowNumber).'_vals_key[1]'] = $params['vals_key1'];
		}
		if (isset($params['vals_value1'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['param_'.($rowNumber).'_vals_value[1]'] = $params['vals_value1'];
		}
		if (isset($params['vals_type'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = $params['vals_type'];
		}
		if (isset($params['iblock'])){
			$inputs['param_'.($rowNumber).'_spec_args[0]'] = $params['iblock'];
		}
		//dd($inputs);
		$this->submitForm('save', $inputs);

		if (isset($params['code'])){
			return BitrixComponentsParams::where('component_id', $component->id)->where('code', $params['code'])->first();
		}

		return true;
	}

	function createTemplateOnForm($module, $component, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.'/components/'.$component->id.'/templates/create');

		$this->submitForm('save', $inputs);

		if (isset($inputs['code'])){
			return BitrixComponentsTemplates::where('code', $inputs['code'])->where('component_id', $component->id)->first();
		}

		return true;
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

		$this->deleteFolder($this->standartModuleCode);

		$this->seeInField('component_php', '<? echo "Hi"; ?>');

	}

	/** @test */
	function it_can_store_arbitrary_file(){
		$component = $this->createOnForm($this->module);

		$this->visit('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/other_files');

		$file = public_path().'/ololo.php';
		file_put_contents($file, '<? echo "Hi"; ?>');

		$this->deleteFolder($this->standartModuleCode);

		$this->type('/ololo/', 'path');
		$this->attach($file, 'file');
		$this->press('upload');

		$this->see('/ololo/ololo.php');
	}

	/** @test */
	function it_can_find_name_of_noname_system_param(){
		$component = $this->createOnForm($this->module);

		$this->createComponentParamOnForm($component, 0, [
			'name' => '',
			'code' => 'CACHE_TIME',
			'type' => 'STRING',
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->see('Время кеширования (сек.)');
	}

	/** @test */
	function it_can_store_template(){
		$component = $this->createOnForm($this->module);
		$template = $this->createTemplateOnForm($this->module, $component, [
			'name'                 => 'Test',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/templates/'.$template->id);
		$this->seeInField('name', 'Test');
		$this->seeInField('template_php', '<? echo "HW"; ?>');
		$this->seeInField('style_css', '123');
		$this->seeInField('script_js', '234');
		$this->seeInField('result_modifier_php', '345');
		$this->seeInField('component_epilog_php', '<? ?>');
	}

	/** @test */
	function it_can_update_template(){
		$component = $this->createOnForm($this->module);
		$template = $this->createTemplateOnForm($this->module, $component, [
			'name'                 => 'Test2',
			'code'                 => 'ololo',
			'template_php'         => '<? echo "ololo"; ?>',
			'style_css'            => '.ololo{color: #fff;}',
			'script_js'            => 'console.log("ololo")',
			'result_modifier_php'  => '',
			'component_epilog_php' => '',
		]);

		$this->submitForm('save', [
			'name'                 => 'Test',
			'template_php'         => '<? echo "HW"; ?>',
			'style_css'            => '123',
			'script_js'            => '234',
			'result_modifier_php'  => '345',
			'component_epilog_php' => '<? ?>',
		]);

		$this->deleteFolder($this->standartModuleCode);

		$this->seePageIs('/my-bitrix/'.$this->module->id.'/components/'.$component->id.'/templates/'.$template->id);
		$this->seeInField('name', 'Test');
		$this->seeInField('template_php', '<? echo "HW"; ?>');
		$this->seeInField('style_css', '123');
		$this->seeInField('script_js', '234');
		$this->seeInField('result_modifier_php', '345');
		$this->seeInField('component_epilog_php', '<? ?>');
	}
}

?>

