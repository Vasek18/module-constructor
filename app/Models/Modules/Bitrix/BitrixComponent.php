<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

	public function saveInFolder(){
		$this->saveDescriptionFileInFolder();
		$this->saveDescriptionLangFileInFolder();
	}

	// todo второй уровень
	protected function saveDescriptionFileInFolder(){
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
		);

		$replace = Array(
			$this->lang_key,
			$this->code,
			$this->name,
			$this->sort,
			$path_items[0]->code,
			$path_items[0]->sort
		);

		//dd($replace);

		Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\.description.php', $module->id, $search, $replace, 'bitrix\install\components\\'.$this->name.'\.description.php');
	}

	protected function saveDescriptionLangFileInFolder(){
		$module = $this->module()->first();
		$module_folder = $module->module_folder;

		Bitrix::disk()->makeDirectory($module_folder."/install/components/".$this->code);

		$path_items = $this->path_items()->get();

		$search = Array(
			'{COMPONENT_LANG_KEY}',
			'{COMPONENT_CODE}',
			'{COMPONENT_NAME}',
			'{COMPONENT_SORT}',
			'{COMPONENT_DESCRIPTION}',
			'{MODULE_COMPONENTS_FOLDER_NAME}'
		);

		$replace = Array(
			$this->lang_key,
			$this->code,
			$this->name,
			$this->sort,
			$this->desc,
			$path_items[0]->name
		);

		//dd($replace);

		Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\lang\ru\.description.php', $module->id, $search, $replace, 'bitrix\install\components\\'.$this->name.'\lang\ru\.description.php');
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->module()->first()->PARTNER_CODE."_".$this->code);
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

	public function path_items(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixComponentPathItem', "component_id");
	}
}
