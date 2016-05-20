<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

// todo магические числа у шагов
class BitrixComponent extends Model{
	protected $table = 'bitrix_components';
	protected $fillable = ['name', 'sort', 'code', 'icon_path', 'desc'];
	public $timestamps = false;

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
				'code'         => $module->PARTNER_CODE."_".$module->code."_components",
				'name'         => $module->name,
				'sort'         => 500
			]
		);

		$this->saveDescriptionFileInFolder();
		$this->saveDescriptionLangFileInFolder();

		$this->saveStep(2);
	}

	public function createDefaultComponentPhp(){
		$component_php = '<? $this->IncludeComponentTemplate(); ?>';

		$this->module()->first()->disk()->put($this->getFolder().'\component.php', $component_php);

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

		$this->module()->first()->disk()->put($template->getFolder().'\template.php', $template_php);

		$this->saveStep(6);
	}

	public function saveInFolder(){ // todo я вообще его юзаю?
		$this->saveDescriptionFileInFolder();
		$this->saveDescriptionLangFileInFolder();
	}

	// todo третий уровень
	public function saveDescriptionFileInFolder(){
		$module = $this->module()->first();

		$path_items = $this->path_items()->get();

		$search = Array(
			'{COMPONENT_LANG_KEY}',
			'{COMPONENT_CODE}',
			'{COMPONENT_NAME}',
			'{COMPONENT_SORT}',
			'{MODULE_COMPONENTS_FOLDER_ID}',
			'{MODULE_COMPONENTS_FOLDER_SORT}',
			'{MODULE_COMPONENTS_FOLDER_NAME}',
		);

		$replace = Array(
			$this->lang_key,
			$this->code,
			$this->name,
			$this->sort,
			$path_items[0]->code,
			$path_items[0]->sort,
			$path_items[0]->name,
		);

		$file = '.description.php';
		if (isset($path_items[1])){
			$file = '.description2.php';
			$search[] = '{MODULE_COMPONENTS_SUBFOLDER_ID}';
			$search[] = '{MODULE_COMPONENTS_SUBFOLDER_SORT}';
			$search[] = '{MODULE_COMPONENTS_SUBFOLDER_NAME}';
			$replace[] = $path_items[1]->code;
			$replace[] = $path_items[1]->sort;
			$replace[] = $path_items[1]->name;
			if (isset($path_items[2])){
				$file = '.description3.php';
				$search[] = '{MODULE_COMPONENTS_SUBSUBFOLDER_ID}';
				$search[] = '{MODULE_COMPONENTS_SUBSUBFOLDER_SORT}';
				$search[] = '{MODULE_COMPONENTS_SUBSUBFOLDER_NAME}';
				$replace[] = $path_items[2]->code;
				$replace[] = $path_items[2]->sort;
				$replace[] = $path_items[2]->name;
			}
		}

		//dd($file);

		Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\\'.$file, $module->id, $search, $replace, $this->getFolder().'\.description.php');
	}

	public function saveDescriptionLangFileInFolder(){
		$module = $this->module()->first();

		$path_items = $this->path_items()->get();

		$search = Array(
			'{COMPONENT_LANG_KEY}',
			'{COMPONENT_CODE}',
			'{COMPONENT_NAME}',
			'{COMPONENT_DESCRIPTION}',
			'{MODULE_COMPONENTS_FOLDER_NAME}',
		);

		$replace = Array(
			$this->lang_key,
			$this->code,
			$this->name,
			$this->desc,
			$path_items[0]->name,
		);

		$file = '.description.php';
		if (isset($path_items[1])){
			$file = '.description2.php';
			$search[] = '{MODULE_COMPONENTS_SUBFOLDER_NAME}';
			$replace[] = $path_items[1]->name;
			if (isset($path_items[2])){
				$file = '.description3.php';
				$search[] = '{MODULE_COMPONENTS_SUBSUBFOLDER_NAME}';
				$replace[] = $path_items[2]->name;
			}
		}

		//dd($replace);

		Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\lang\ru\\'.$file, $module->id, $search, $replace, $this->getFolder().'\lang\ru\.description.php');
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

	public function getFolder($full = false){
		$module = $this->module()->first();
		$module_folder = $module->getFolder($full);

		return $module_folder.'\install\components\\'.$module->module_full_id.'\\'.$this->code;
	}

	public function createFolder(){
		$this->module()->first()->disk()->makeDirectory($this->getFolder());
	}

	public function deleteFolder(){
		$this->module()->first()->disk()->deleteDirectory($this->getFolder());
	}

	public function generateZip(){
		$archiveName = $this->code.".zip";

		//dd(glob($this->getFolder(true). '/{,.[a-zA-Z]}*', GLOB_BRACE));

		$zipper = new \Chumper\Zipper\Zipper;
		//$zipper->make($archiveName)->folder($this->code)->add(glob($this->getFolder(true). '/{,.}*', GLOB_BRACE))->close();
		$zipper->make($archiveName)->folder($this->code)->add($this->getFolder(true))->close();

		return $archiveName;
	}

	public function saveParamsInFile(){
		$module = $this->module()->first();
		$params = $this->params()->orderBy('sort', 'asc')->get();

		$groupsText = ''; // todo
		$groupsLangText = ''; // todo

		$paramsText = '';
		$paramsLangText = '';
		foreach ($params as $param){
			//dd($param);
			if ($param->group_id){
				$parentCode = BitrixComponentsParamsGroups::find($param->group_id)->code;
			}
			$langKeyAttr = $this->getLangKeyAttribute()."_PARAMS_".strtoupper($param->code);

			$paramText = '"'.strtoupper($param->code).'"  =>  Array(
			"PARENT" => "'.$parentCode.'",
			"NAME" => GetMessage("'.$langKeyAttr.'"),
			"TYPE" => "'.$param->type.'",'.PHP_EOL;
			if ($param->refresh){
				$paramText .= "\t\t\t".'"REFRESH" => "Y",'.PHP_EOL;
			}
			if ($param->multiple){
				$paramText .= "\t\t\t".'"MULTIPLE" => "Y",'.PHP_EOL;
			}
			if ($param->additional_values){
				$paramText .= "\t\t\t".'"ADDITIONAL_VALUES" => "Y",'.PHP_EOL;
			}
			if ($param->size){
				$paramText .= "\t\t\t".'"SIZE" => "'.$param->size.'",'.PHP_EOL;
			}
			if ($param->default){
				$paramText .= "\t\t\t".'"DEFAULT" => "'.$param->default.'",'.PHP_EOL;
			}
			if ($param->cols){
				$paramText .= "\t\t\t".'"COLS" => "'.$param->cols.'",'.PHP_EOL;
			}

			if ($param->type == 'LIST'){
				if ($param->spec_vals == 'array'){
					$paramText .= "\t\t\t".'"VALUES" => Array('.PHP_EOL;
					if (count($param->vals)){
						foreach ($param->vals as $val){
							$paramText .= "\t\t\t\t".'"'.$val->key.'" => "'.$val->value.'",'.PHP_EOL;
						}
					}
					$paramText .= "\t\t\t".'),'.PHP_EOL;
				}else{
					$paramText .= "\t\t\t".'"VALUES" => '.$param->spec_vals_function_call.''.PHP_EOL;
				}
			}

			$paramText .= "\t\t".'),'.PHP_EOL."\t\t";

			$paramsText .= $paramText;

			$paramsLangText .= '$MESS["'.$langKeyAttr.'"] = "'.$param->name.'";'.PHP_EOL;
		}

		$search = Array('{GROUPS}', '{PARAMS}');
		$replace = Array($groupsText, $paramsText);

		$searchLang = Array('{GROUPS_LANG}', '{PARAMS_LANG}');
		$replaceLang = Array($groupsLangText, $paramsLangText);

		Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\.parameters.php', $module->id, $search, $replace, $this->getFolder().'\.parameters.php');
		Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\lang\ru\.parameters.php', $module->id, $searchLang, $replaceLang, $this->getFolder().'\lang\ru\.parameters.php');

		return true;

	}

	public function parseDescriptionFile(){

	}

	public function parseParamsFile(){

	}

	public function gatherListOfArbitraryFiles(){

	}

	public function parseTemplates(){

	}

	public function getStepsAttribute($value){
		$steps = array_filter(explode(",", $value));

		return $steps;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->module()->first()->PARTNER_CODE."_".$this->code);
	}

	public function getComponentPhpAttribute(){
		$code = $this->module()->first()->disk()->get($this->getFolder().'\component.php');

		return $code;
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

	public function arbitraryFiles(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixComponentsArbitraryFiles', "component_id");
	}
}
