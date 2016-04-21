<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// todo магические числа у шагов
class BitrixComponent extends Model{
	protected $table = 'bitrix_components';
	protected $fillable = ['name', 'sort', 'code', 'icon_path', 'desc'];


	// создание компонента
	public static function store($module, Request $request){
		$component = new BitrixComponent;
		// запись в БД
		$component->module_id = $module->id;
		$component->name = $request->COMPONENT_NAME;
		$component->desc = $request->COMPONENT_DESCRIPTION;
		$component->code = $request->COMPONENT_CODE;
		$component->sort = $request->COMPONENT_SORT;
		$component->save();

		if ($component->save()){
			return $component;
		}
	}

	public function createDefaultPath(){
		$module = $this->module()->first();
		BitrixComponentsPathItem::create(
			[
				'component_id' => $this->id,
				'level'        => 1,
				'code'         => $module->PARTNER_CODE."_".$module->MODULE_CODE."_components",
				'name'         => $module->MODULE_NAME,
				'sort'         => 500
			]
		);

		$this->saveStep(2);
	}

	public function createDefaultComponentPhp(){
		$component_php = '<? $this->IncludeComponentTemplate(); ?>';
		$this->component_php = $component_php;
		$this->save();

		Storage::disk('user_modules')->put($this->getFolder().'\component.php', $component_php);

		$this->saveStep(4);
	}

	public function createDefaultTemplate(){
		$template = BitrixComponentsTemplates::create(
			[
				'component_id' => $this->id,
				'code'         => '.default',
				'name'         => 'Дефолтный'
			]
		);

		$template_php = 'Hello World';

		Storage::disk('user_modules')->put($template->getFolder().'\template.php', $template_php);

		$this->saveStep(6);
	}

	public function saveInFolder(){
		$this->saveDescriptionFileInFolder();
		$this->saveDescriptionLangFileInFolder();
	}

	// todo третий уровень
	public function saveDescriptionFileInFolder(){
		$module = $this->module()->first();
		$module_folder = $module->module_folder;

		Bitrix::disk()->makeDirectory($module_folder."/install/components/".$this->code);

		$path_items = $this->path_items()->get();

		$search = Array(
			'{COMPONENT_LANG_KEY}',
			'{COMPONENT_CODE}',
			'{COMPONENT_NAME}',
			'{COMPONENT_SORT}',
			'{MODULE_COMPONENTS_FOLDER_ID}',
			'{MODULE_COMPONENTS_FOLDER_SORT}',
			'{MODULE_COMPONENTS_FOLDER_NAME}',
			'{MODULE_COMPONENTS_SUBFOLDER_ID}',
			'{MODULE_COMPONENTS_SUBFOLDER_SORT}',
			'{MODULE_COMPONENTS_SUBFOLDER_NAME}',
		);

		$replace = Array(
			$this->lang_key,
			$this->code,
			$this->name,
			$this->sort,
			$path_items[0]->code,
			$path_items[0]->sort,
			$path_items[0]->name,
			$path_items[1]->code,
			$path_items[1]->sort,
			$path_items[1]->name,
		);

		//dd($replace);

		Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\.description.php', $module->id, $search, $replace, 'bitrix\install\components\\'.$this->name.'\.description.php');
	}

	public function saveDescriptionLangFileInFolder(){
		$module = $this->module()->first();
		$module_folder = $module->module_folder;

		Bitrix::disk()->makeDirectory($module_folder."/install/components/".$this->code);

		$path_items = $this->path_items()->get();

		$search = Array(
			'{COMPONENT_LANG_KEY}',
			'{COMPONENT_CODE}',
			'{COMPONENT_NAME}',
			'{COMPONENT_DESCRIPTION}',
			'{MODULE_COMPONENTS_FOLDER_NAME}',
			'{MODULE_COMPONENTS_SUBFOLDER_NAME}'
		);

		$replace = Array(
			$this->lang_key,
			$this->code,
			$this->name,
			$this->desc,
			$path_items[0]->name,
			$path_items[1]->name
		);

		//dd($replace);

		Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\lang\ru\.description.php', $module->id, $search, $replace, 'bitrix\install\components\\'.$this->name.'\lang\ru\.description.php');
	}

	public function saveStep($step){
		$steps = $this->steps;

		$steps[] = $step;
		$steps = array_unique($steps);

		$this->steps = implode(",", $steps);
		$this->save();

		return $steps;
	}

	public function deleteStep($step){
		$steps = $this->steps;

		foreach ($steps as $c => $curstep){
			if ($curstep == $step){
				unset($steps[$c]);
			}
		}

		$this->steps = implode(",", $steps);
		$this->save();

		return $steps;
	}

	public function getSteps(){
		return array_filter(explode(",", $this->steps));
	}

	public function getFolder(){
		$module_folder = Bitrix::getFolder($this->module()->first(), false);

		return $module_folder.'\install\components\\'.$this->code;
	}

	public function getStepsAttribute($value){
		$steps = array_filter(explode(",", $value));

		return $steps;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->module()->first()->PARTNER_CODE."_".$this->code);
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

	public function path_items(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixComponentsPathItem', "component_id");
	}

	public function params(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixComponentsParams', "component_id");
	}

	public function templates(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixComponentsTemplates', "component_id");
	}
}
