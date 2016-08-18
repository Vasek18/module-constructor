<?php

use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixAdminMenuItems;
use App\Models\Modules\Bitrix\BitrixAdminOptions;
use App\Models\Modules\Bitrix\BitrixArbitraryFiles;
use App\Models\Modules\Bitrix\BitrixComponent;
use App\Models\Modules\Bitrix\BitrixComponentsParams;
use App\Models\Modules\Bitrix\BitrixComponentsTemplates;
use App\Models\Modules\Bitrix\BitrixComponentsArbitraryFiles;
use App\Models\Modules\Bitrix\BitrixInfoblocks;
use App\Models\Modules\Bitrix\BitrixIblocksElements;
use App\Models\Modules\Bitrix\BitrixMailEvents;

class BitrixTestCase extends TestCase{
	public $module;

	protected function disk(){
		return Storage::disk('user_modules_bitrix');
	}

	protected $standartModuleName = 'Ololo';
	protected $standartModuleDescription = 'Ololo trololo';
	protected $standartModuleCode = 'ololo_from_test';
	protected $standartModuleVersion = '0.0.1';

	// главная форма Битрикса
	function fillNewBitrixForm($params = Array()){
		if (!isset($params['PARTNER_NAME'])){
			$params['PARTNER_NAME'] = $this->user->bitrix_company_name;
		}
		if (!isset($params['PARTNER_URI'])){
			$params['PARTNER_URI'] = $this->user->site;
		}
		if (!isset($params['PARTNER_CODE'])){
			$params['PARTNER_CODE'] = $this->user->bitrix_partner_code;
		}
		if (!isset($params['MODULE_NAME'])){
			$params['MODULE_NAME'] = $this->standartModuleName;
		}
		if (!isset($params['MODULE_DESCRIPTION'])){
			$params['MODULE_DESCRIPTION'] = $this->standartModuleDescription;
		}
		if (!isset($params['MODULE_CODE'])){
			$params['MODULE_CODE'] = $this->standartModuleCode;
		}
		if (!isset($params['MODULE_VERSION'])){
			$params['MODULE_VERSION'] = $this->standartModuleVersion;
		}

		$this->visit('/my-bitrix/create');

		$this->type($params['PARTNER_NAME'], 'PARTNER_NAME');
		$this->type($params['PARTNER_URI'], 'PARTNER_URI');
		$this->type($params['PARTNER_CODE'], 'PARTNER_CODE');
		$this->type($params['MODULE_NAME'], 'MODULE_NAME');
		$this->type($params['MODULE_DESCRIPTION'], 'MODULE_DESCRIPTION');
		$this->type($params['MODULE_CODE'], 'MODULE_CODE');
		$this->type($params['MODULE_VERSION'], 'MODULE_VERSION');
		$this->press('module_create');

		if ($params['PARTNER_CODE'] && $params['MODULE_CODE']){
			return Bitrix::where('PARTNER_CODE', $params['PARTNER_CODE'])->where('code', $params['MODULE_CODE'])->first();
		}
	}

	function deleteFolder($moduleCode){
		if (Bitrix::where('code', $moduleCode)->count()){
			$modules = Bitrix::where('code', $moduleCode)->get();
			foreach ($modules as $module){
				$module->deleteFolder();
			}
		}
	}

	function createAdminPageOnForm($module, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.'/admin_menu/create');

		if (!isset($inputs['name'])){
			$inputs['name'] = 'Ololo';
		}
		if (!isset($inputs['code'])){
			$inputs['code'] = 'trololo';
		}
		if (!isset($inputs["sort"])){
			$inputs['sort'] = "334";
		}
		if (!isset($inputs["text"])){
			$inputs['text'] = "item";
		}
		if (!isset($inputs["parent_menu"])){
			$inputs['parent_menu'] = 'global_menu_settings';
		}

		$this->submitForm('save', $inputs);

		if (isset($inputs['code'])){
			return BitrixAdminMenuItems::where('code', $inputs['code'])->where('module_id', $module->id)->first();
		}

		return true;
	}

	function removeAdminPage($module, $amp){
		$this->visit('/my-bitrix/'.$module->id.'/admin_menu/');
		$this->click('delete_amp_'.$amp->id);
	}

	function createAdminOptionOnForm($module, $rowNumber, $params){
		$this->visit('/my-bitrix/'.$module->id.'/admin_options');
		$inputs = [];
		if (isset($params['name'])){
			$inputs['option_name['.$rowNumber.']'] = $params['name'];
		}
		if (isset($params['code'])){
			$inputs['option_code['.$rowNumber.']'] = $params['code'];
		}
		if (isset($params['type'])){
			$inputs['option_type['.$rowNumber.']'] = $params['type'];
		}
		if (isset($params['width'])){
			$inputs['option_width['.$rowNumber.']'] = $params['width'];
		}
		if (isset($params['height'])){
			$inputs['option_height['.$rowNumber.']'] = $params['height'];
		}
		if (isset($params['vals_key0'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['option_'.($rowNumber).'_vals_key[0]'] = $params['vals_key0'];
		}
		if (isset($params['vals_value0'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['option_'.($rowNumber).'_vals_value[0]'] = $params['vals_value0'];
		}
		if (isset($params['vals_key1'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['option_'.($rowNumber).'_vals_key[1]'] = $params['vals_key1'];
		}
		if (isset($params['vals_value1'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = 'array';
			$inputs['option_'.($rowNumber).'_vals_value[1]'] = $params['vals_value1'];
		}
		if (isset($params['vals_type'])){
			$inputs['option_'.($rowNumber).'_vals_type'] = $params['vals_type'];
		}
		if (isset($params['iblock'])){
			$inputs['option_'.($rowNumber).'_spec_args[0]'] = $params['iblock'];
		}
		if (isset($params['default_value'])){
			$inputs['default_value['.$rowNumber.']'] = $params['default_value'];
		}
		if (isset($params['vals_default'])){
			$inputs['option_'.($rowNumber).'_vals_default'] = $params['vals_default'];
		}
		//dd($inputs);
		$this->submitForm('save', $inputs);

		if (isset($params['code'])){
			return BitrixAdminOptions::where('code', $params['code'])->first();
		}

		return true;
	}

	function deleteAdminOptionOnForm($module, $option){
		$this->visit('/my-bitrix/'.$module->id.'/admin_options');
		$this->click('delete_option_'.$option->id);
	}

	function uploadArbitraryFileOnForm($module, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.$this->path);

		if (!isset($inputs['path'])){
			$inputs['path'] = '/';
		}
		if (!isset($inputs['file'])){
			$inputs['file'] = $this->file;
		}
		if (!isset($inputs['location'])){
			$inputs['location'] = 'in_module';
		}

		$this->type($inputs['path'], 'path');
		$this->select($inputs['location'], 'location');
		$this->attach($inputs['file'], 'file');
		$this->press('upload');

		if (isset($inputs['file'])){
			return BitrixArbitraryFiles::where('filename', basename($inputs['file']))->where('module_id', $module->id)->first();
		}

		return true;
	}

	function changeArbitraryFile($module, $file, $inputs){
		$this->visit('/my-bitrix/'.$module->id.$this->path);
		if (isset($inputs['filename'])){
			$this->type($inputs['filename'], 'filename_'.$file->id);
		}
		if (isset($inputs['location'])){
			$this->select($inputs['location'], 'location_'.$file->id);
		}
		if (isset($inputs['path'])){
			$this->type($inputs['path'], 'path_'.$file->id);
		}
		if (isset($inputs['code'])){
			$this->type($inputs['code'], 'code_'.$file->id);
		}
		$this->press('save_'.$file->id);
	}

	function removeArbitraryFile($module, $amp){
		$this->visit('/my-bitrix/'.$module->id.$this->path);
		$this->click('delete_af_'.$amp->id);
	}

	function createComponentOnForm($module, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.'/components/create');

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

	function createComponentParamOnForm($module, $component, $rowNumber, $params){
		$this->visit('/my-bitrix/'.$module->id.'/components/'.$component->id.'/params');
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
		if (isset($params['sort'])){
			$inputs['param_sort['.$rowNumber.']'] = $params['sort'];
		}
		if (isset($params['default'])){
			$inputs['param_default['.$rowNumber.']'] = $params['default'];
		}
		if (isset($params['additional_values'])){
			$inputs['param_additional_values['.$rowNumber.']'] = $params['additional_values'];
		}
		if (isset($params['vals_key0'])){
			$inputs['param_'.($rowNumber).'_vals_key[0]'] = $params['vals_key0'];
		}
		if (isset($params['vals_value0'])){
			$inputs['param_'.($rowNumber).'_vals_value[0]'] = $params['vals_value0'];
		}
		if (isset($params['vals_key1'])){
			$inputs['param_'.($rowNumber).'_vals_key[1]'] = $params['vals_key1'];
		}
		if (isset($params['vals_value1'])){
			$inputs['param_'.($rowNumber).'_vals_value[1]'] = $params['vals_value1'];
		}
		if (isset($params['vals_type'])){
			$inputs['param_'.($rowNumber).'_vals_type'] = $params['vals_type'];
		}
		if (isset($params['spec_args'])){
			$inputs['param_'.($rowNumber).'_spec_args[0]'] = $params['spec_args'];
		}
		if (isset($params['iblock'])){
			$inputs['param_'.($rowNumber).'_spec_args[0]'] = $params['iblock'];
		}
		if (isset($params['template_id'])){
			$inputs['param_template_id['.$rowNumber.']'] = $params['template_id'];
		}
		//dd($inputs);
		$this->submitForm('save', $inputs);
		if (isset($params['code'])){
			return BitrixComponentsParams::where('component_id', $component->id)->where('code', $params['code'])->first();
		}

		return true;
	}

	function deleteComponentParamOnForm($module, $component, $param){
		$this->visit('/my-bitrix/'.$module->id.'/components/'.$component->id.'/params');
		$this->click('delete_param_'.$param->id);
	}

	function createTemplateOnForm($module, $component, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.'/components/'.$component->id.'/templates/create');

		$this->submitForm('save', $inputs);

		if (isset($inputs['code'])){
			return BitrixComponentsTemplates::where('code', $inputs['code'])->where('component_id', $component->id)->first();
		}

		return true;
	}

	function storeComponentArbitraryFileOnForm($module, $component, $path, $name, $content, $template = false){
		if ($template){
			$this->visit('/my-bitrix/'.$module->id.'/components/'.$component->id.'/templates/'.$template->id.'/files');
		}else{
			$this->visit('/my-bitrix/'.$module->id.'/components/'.$component->id.'/other_files');
		}

		$file = public_path().'/'.$name;
		file_put_contents($file, $content);

		$this->type($path, 'path');
		$this->attach($file, 'file');
		$this->press('upload');

		unlink($file);

		return BitrixComponentsArbitraryFiles::where('component_id', $component->id)->where('filename', $name)->where('path', $path)->first();
	}

	function createComponentTemplateOnForm($module, $component, $inputs = []){
		$this->visit('/my-bitrix/'.$module->id.'/components/'.$component->id.'/templates/create');

		$this->submitForm('save', $inputs);

		if (isset($inputs['code'])){
			return BitrixComponentsTemplates::where('code', $inputs['code'])->where('component_id', $component->id)->first();
		}

		return true;
	}

	function createIblockOnForm($module, $params = []){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib');
		$inputs = [];

		if (!isset($params['VERSION'])){
			$params['VERSION'] = '2';
		}
		if (!isset($params['NAME'])){
			$params['NAME'] = 'Ololo';
		}
		if (!isset($params['CODE'])){
			$params['CODE'] = 'trololo';
		}
		if (!isset($params['SORT'])){
			$params["SORT"] = "555";
		}
		if (!isset($params['LIST_PAGE_URL'])){
			$params["LIST_PAGE_URL"] = "#SITE_DIR#/".$module->code."/index.php?ID=#IBLOCK_ID##hi";
		}
		if (!isset($params['SECTION_PAGE_URL'])){
			$params["SECTION_PAGE_URL"] = "#SITE_DIR#/".$module->code."/list.php?SECTION_ID=#SECTION_ID##hi";
		}
		if (!isset($params['DETAIL_PAGE_URL'])){
			$params["DETAIL_PAGE_URL"] = "#SITE_DIR#/".$module->code."/detail.php?ID=#ELEMENT_ID##hi";
		}

		foreach ($params as $code => $val){
			$inputs[$code] = $val;
		}

		//dd($params);

		$this->submitForm('save', $inputs);

		if (isset($params['CODE'])){
			return BitrixInfoblocks::where('code', $params['CODE'])->where('module_id', $module->id)->first();
		}

		return true;
	}

	function changeIblockOnForm($module, $iblock, $params = []){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib/'.$iblock->id);
		$inputs = [];

		foreach ($params as $code => $val){
			$inputs[$code] = $val;
		}

		//dd($params);

		$this->submitForm('save', $inputs);

		return $iblock;
	}

	function createIblockElementOnForm($module, $iblock, $params = []){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/ib/'.$iblock->id.'/create_element');
		$this->submitForm('save', $params);

		if ($params["CODE"]){
			return $prop = BitrixIblocksElements::where('code', $params["CODE"])->where('iblock_id', $iblock->id)->first();
		}

		return false;
	}

	function removeIblock($module, $iblock){
		$this->visit('/my-bitrix/'.$module->id.'/data_storage/');
		$this->click('delete_iblock_'.$iblock->id);
	}

	function createMailEventOnForm($module, $params = []){
		$this->visit('/my-bitrix/'.$module->id.'/mail_events/create');

		$inputs = [];
		if (isset($params["name"])){
			$inputs["MAIL_EVENT_NAME"] = $params["name"];
		}
		if (isset($params["code"])){
			$inputs["MAIL_EVENT_CODE"] = $params["code"];
		}
		if (isset($params["sort"])){
			$inputs["MAIL_EVENT_SORT"] = $params["sort"];
		}
		if (isset($params["var0"])){
			$inputs["MAIL_EVENT_VARS_NAMES[0]"] = $params["var0"]["name"];
			$inputs["MAIL_EVENT_VARS_CODES[0]"] = $params["var0"]["code"];
		}

		$this->submitForm('create', $inputs);

		if (isset($params['code'])){
			return BitrixMailEvents::where('code', $params['code'])->where('module_id', $module->id)->first();
		}

		return true;
	}
}
