<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Helpers\vArrParse;

class BitrixComponentsFilesTest extends TestCase{

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
	function it_creates_standard_component(){
		$component = $this->createOnForm($this->module, [
			'name' => 'Heh',
			'sort' => '334',
			'code' => 'ololo.trololo',
			'desc' => 'HelloWorld',
		]);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$description_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.description.php'), 'MESS');
		$description_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.description.php'), '$arComponentDescription');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertTrue(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'No component folder');
		$this->assertEquals('Heh', $description_lang_arr[$component->lang_key."_COMPONENT_NAME"]);
		$this->assertEquals('HelloWorld', $description_lang_arr[$component->lang_key."_COMPONENT_DESCRIPTION"]);
		$this->assertEquals('334', $description_arr["SORT"]);
	}

	/** @test */
	function it_creates_component_in_another_namespace(){
		$component = $this->createOnForm($this->module, [
			'name'      => 'Heh',
			'sort'      => '334',
			'code'      => 'ololo.trololo',
			'namespace' => 'vregions',
		]);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$description_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.description.php'), 'MESS');
		$description_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.description.php'), '$arComponentDescription');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertTrue(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'No component folder');
		$this->assertEquals('Heh', $description_lang_arr[$component->lang_key."_COMPONENT_NAME"]);
		$this->assertEquals('334', $description_arr["SORT"]);
	}

	/** @test */
	function it_makes_hello_world_component_instead_of_empty(){
		$component = $this->createOnForm($this->module, [
			'name' => 'Heh',
			'code' => 'ololo.trololo',
		]);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$description_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.description.php'), 'MESS');
		$description_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.description.php'), '$arComponentDescription');
		$component_php = $this->disk()->get($component->getFolder().'/component.php');
		$default_template_php = $this->disk()->get($component->getFolder().'/templates/.default/template.php');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertTrue(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'No component folder');
		$this->assertEquals('Heh', $description_lang_arr[$component->lang_key."_COMPONENT_NAME"]);
		$this->assertEquals('500', $description_arr["SORT"]);
		$this->assertEquals(array(
			"ID"   => $this->module->PARTNER_CODE."_".$this->module->code."_components",
			"SORT" => '500',
			"NAME" => 'GetMessage("'.$component->lang_key.'_COMPONENTS_FOLDER_NAME")',
		), $description_arr["PATH"]);
		$this->assertEquals('<? $this->IncludeComponentTemplate(); ?>', $component_php);
		$this->assertEquals('Hello World', $default_template_php);
	}

	/** @test */
	function it_can_delete_component(){
		$component = $this->createOnForm($this->module);

		$this->deleteComponentFromList($component);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$this->assertFalse(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'There is component folder');

		$this->deleteFolder($this->standartModuleCode);
	}

	/** @test */
	function it_can_delete_component_from_detail(){
		$component = $this->createOnForm($this->module);

		$this->deleteComponentFromDetail($component);

		$dirs = $this->disk()->directories($this->module->module_folder.'/install/components/'.$component->namespace);
		$this->assertFalse(in_array($this->module->module_folder.'/install/components/'.$component->namespace.'/'.$component->code, $dirs), 'There is component folder');

		$this->deleteFolder($this->standartModuleCode);
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

		$description_lang_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/lang/ru/.description.php'), 'MESS');
		$description_arr = vArrParse::parseFromText($this->disk()->get($component->getFolder().'/.description.php'), '$arComponentDescription');

		$this->deleteFolder($this->standartModuleCode);

		$this->assertEquals(array(
			"NAME"        => 'GetMessage("'.$component->lang_key.'_COMPONENT_NAME")',
			"DESCRIPTION" => 'GetMessage("'.$component->lang_key.'_COMPONENT_DESCRIPTION")',
			"ICON"        => "/images/regions.gif",
			"SORT"        => '500',
			"PATH"        => array(
				"ID"    => "ololo1",
				"SORT"  => '500',
				"NAME"  => 'GetMessage("'.$component->lang_key.'_COMPONENTS_FOLDER_NAME")',
				"CHILD" => array(
					"ID"    => "trololo1",
					"NAME"  => 'GetMessage("'.$component->lang_key.'_COMPONENTS_SUBFOLDER_NAME")',
					"SORT"  => '1000',
					"CHILD" => array(
						"ID"   => "foo1",
						"NAME" => 'GetMessage("'.$component->lang_key.'_COMPONENTS_SUBSUBFOLDER_NAME")',
						"SORT" => '1500',
					),
				),
			),
		), $description_arr);

		$this->assertEquals('ololo2', $description_lang_arr[''.$component->lang_key.'_COMPONENTS_FOLDER_NAME']);
		$this->assertEquals('trololo2', $description_lang_arr[''.$component->lang_key.'_COMPONENTS_SUBFOLDER_NAME']);
		$this->assertEquals('foo2', $description_lang_arr[''.$component->lang_key.'_COMPONENTS_SUBSUBFOLDER_NAME']);
	}
}

?>