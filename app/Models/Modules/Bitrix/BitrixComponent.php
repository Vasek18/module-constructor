<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Helpers\vArrParse;
use Illuminate\Support\Facades\Storage;

// todo магические числа у шагов
class BitrixComponent extends Model{
	protected $table = 'bitrix_components';
	protected $fillable = ['module_id', 'name', 'sort', 'code', 'icon_path', 'desc', 'namespace'];
	public $timestamps = false;
	public $nonArbitraryFiles = [
		'/component.php',
		'/.description.php',
		'/.parameters.php'
	];

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
		$component_php = Storage::disk('modules_templates')->get('bitrix\install\components\component_name\component.php');

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
		// todo взглни на gatherListOfArbitraryFiles

		$module = $this->module()->first();
		$module_folder = $module->getFolder($full);

		return $module_folder.'\install\components\\'.$this->namespace.'\\'.$this->code;
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

		$paramsTexts = [];
		$helperFunctionsArr = [];

		$langFilePath = $this->getFolder().'\lang\ru\.parameters.php';

		foreach ($params as $param){
			if ($param->template_id){
				$template = BitrixComponentsTemplates::find($param->template_id);
			}
			//dd($param);
			if ($param->group_id){
				$parentCode = BitrixComponentsParamsGroups::find($param->group_id)->code;
			}

			$paramText = '"'.strtoupper($param->code).'"  =>  Array(
			"PARENT" => "'.$parentCode.'",
			"NAME" => GetMessage("'.$param->lang_key.'_NAME"),
			"TYPE" => "'.$param->type.'",'.PHP_EOL;

			if (!$param->template_id){
				$module->changeVarInLangFile($param->lang_key.'_NAME', $param->name, $langFilePath);
			}else{
				$module->changeVarInLangFile($param->lang_key.'_NAME', $param->name, $template->getFolder().'\lang\ru\.parameters.php');
			}
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
				if (strpos($param->default, 'GetMessage') === false){
					$param->default = "'".$param->default."'";
				}
				$paramText .= "\t\t\t"."'DEFAULT' => ".$param->default.','.PHP_EOL;
			}
			if ($param->cols){
				$paramText .= "\t\t\t".'"COLS" => "'.$param->cols.'",'.PHP_EOL;
			}

			if ($param->type == 'LIST'){
				if ($param->spec_vals == 'array'){
					$paramText .= "\t\t\t".'"VALUES" => Array(';
					if (count($param->vals)){
						$paramText .= PHP_EOL;
						foreach ($param->vals as $val){
							$paramText .= "\t\t\t\t".'"'.$val->key.'" => GetMessage("'.$val->lang_key.'_VALUE"),'.PHP_EOL;
							if (!$param->template_id){
								$module->changeVarInLangFile($val->lang_key.'_VALUE', $val->value, $langFilePath);
							}else{
								$module->changeVarInLangFile($val->lang_key.'_VALUE', $val->value, $template->getFolder().'\lang\ru\.parameters.php');
							}
						}
						$paramText .= "\t\t\t";
					}
					$paramText .= '),'.PHP_EOL;
				}else{
					$paramText .= "\t\t\t".'"VALUES" => '.$param->spec_vals_function_call.''.PHP_EOL;
					if ($param->spec_vals){
						$helperFunctionsArr[intval($param->template_id)][] = $param->getNeededHelperFunctionName();
					}
				}
			}

			$paramText .= "\t\t".'),'.PHP_EOL."\t\t";

			if (!$param->template_id){
				if (!isset($paramsTexts[0])){
					$paramsTexts[0] = $paramText;
				}else{
					$paramsTexts[0] .= $paramText;
				}
			}else{
				if (!isset($paramsTexts[$param->template_id])){
					$paramsTexts[$param->template_id] = $paramText;
				}else{
					$paramsTexts[$param->template_id] .= $paramText;
				}
			}
		}

		// dd($helperFunctionsArr);

		$search = Array('{GROUPS}', '{PARAMS}', '{FUNCTIONS}');
		foreach ($paramsTexts as $templateID => $paramsText){
			$replace = Array($groupsText, $paramsText, '');
			if (isset($helperFunctionsArr[$templateID])){
				$replace[2] = BitrixHelperFunctions::getPhpCodeFromListOfFuncsNames($module, $helperFunctionsArr[$templateID]);
			}

			if (!$templateID){
				Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\.parameters.php', $module->id, $search, $replace, $this->getFolder().'\.parameters.php');
				$module->changeVarInLangFile($module->lang_key.'_SELECT', trans('app.select'), $this->getFolder().'\lang\ru\.parameters.php');
			}else{
				$template = BitrixComponentsTemplates::find($templateID);
				Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\template_code\.parameters.php', $module->id, $search, $replace, $template->getFolder().'\.parameters.php');
				$module->changeVarInLangFile($module->lang_key.'_SELECT', trans('app.select'), $template->getFolder().'\lang\ru\.parameters.php');
			}
		}
		if (empty($paramsTexts)){
			$replace = Array($groupsText, '');
			Bitrix::changeVarsInModuleFileAndSave('bitrix\install\components\component_name\.parameters.php', $module->id, $search, $replace, $this->getFolder().'\.parameters.php');
		}

		return true;

	}

	public function parseDescriptionFile(){
		$vArrParse = new vArrParse;
		$info = $vArrParse->parseFromFile($this->getFolder(true).'/.description.php', 'arComponentDescription');
		$this->name = extractLangVal($info['NAME'], $this->getFolder(true).'/lang/ru/.description.php');
		$this->desc = extractLangVal($info['DESCRIPTION'], $this->getFolder(true).'/lang/ru/.description.php');
		if (isset($info['ICON'])){
			$this->icon_path = $info['ICON'];
		}
		if (isset($info['SORT'])){
			$this->sort = $info['SORT'];
		}
		$this->save();

		// создаём путь первого уровня
		if (isset($info['PATH'])){
			$pathItem = [
				'level'        => 1,
				'component_id' => $this->id
			];
			if (isset($info['PATH']['ID'])){
				$pathItem['code'] = $info['PATH']['ID'];
			}
			if (isset($info['PATH']['NAME'])){
				$pathItem['name'] = extractLangVal($info['PATH']['NAME'], $this->getFolder(true).'/lang/ru/.description.php');
			}
			if (isset($info['PATH']['SORT'])){
				$pathItem['sort'] = $info['PATH']['SORT'];
			}
			BitrixComponentsPathItem::updateOrCreate(
				[
					'level'        => 1,
					'component_id' => $this->id
				],
				$pathItem
			);

			// создаём путь второго уровня
			if (isset($info['PATH']["CHILD"])){
				$pathItem = [
					'level'        => 2,
					'component_id' => $this->id
				];
				if (isset($info['PATH']["CHILD"]['ID'])){
					$pathItem['code'] = $info['PATH']["CHILD"]['ID'];
				}
				if (isset($info['PATH']["CHILD"]['NAME'])){
					$pathItem['name'] = extractLangVal($info['PATH']["CHILD"]['NAME'], $this->getFolder(true).'/lang/ru/.description.php');
				}
				if (isset($info['PATH']["CHILD"]['SORT'])){
					$pathItem['sort'] = $info['PATH']["CHILD"]['SORT'];
				}
				BitrixComponentsPathItem::updateOrCreate(
					[
						'level'        => 2,
						'component_id' => $this->id
					],
					$pathItem
				);

				// создаём путь третьего уровня
				if (isset($info['PATH']["CHILD"]["CHILD"])){
					$pathItem = [
						'level'        => 3,
						'component_id' => $this->id
					];
					if (isset($info['PATH']["CHILD"]["CHILD"]['ID'])){
						$pathItem['code'] = $info['PATH']["CHILD"]["CHILD"]['ID'];
					}
					if (isset($info['PATH']["CHILD"]["CHILD"]['NAME'])){
						$pathItem['name'] = extractLangVal($info['PATH']["CHILD"]["CHILD"]['NAME'], $this->getFolder(true).'/lang/ru/.description.php');
					}
					if (isset($info['PATH']["CHILD"]["CHILD"]['SORT'])){
						$pathItem['sort'] = $info['PATH']["CHILD"]["CHILD"]['SORT'];
					}
					BitrixComponentsPathItem::updateOrCreate(
						[
							'level'        => 3,
							'component_id' => $this->id
						],
						$pathItem
					);
				}
			}
		}

		//dd($info);
	}

	public function parseParamsFile(){
		// todo создание групп свойств
		// todo подтягивать имена стандартных значений, если они не указаны (например CACHE_TIME)

		$vArrParse = new vArrParse;
		$info = $vArrParse->parseFromFile($this->getFolder(true).'/.parameters.php', 'arComponentParameters');
		foreach ($info['PARAMETERS'] as $code => $param){
			$newParamParams = [
				'code'         => $code,
				'component_id' => $this->id
			];
			if (isset($param["NAME"])){
				$newParamParams['name'] = extractLangVal($param["NAME"], $this->getFolder(true).'/lang/ru/.parameters.php');

			}else{
				$newParamParams['name'] = BitrixComponentsParams::getSystemPropName($code);
			}
			if (!$newParamParams["name"]){
				$newParamParams['name'] = "";
			}
			if (isset($param["TYPE"])){
				$newParamParams['type'] = $param["TYPE"];
			}
			if (isset($param["DEFAULT"])){
				if (!is_array($param["DEFAULT"])){ // todo как вообще сюда мог массив попасть? я же не исполняю файлы! (проверить можно на news)
					$newParamParams['default'] = $param["DEFAULT"];
				}
			}
			if (isset($param["PARENT"])){
				if (BitrixComponentsParamsGroups::where('CODE', $param["PARENT"])->count()){
					$newParamParams['group_id'] = BitrixComponentsParamsGroups::where('CODE', $param["PARENT"])->first()->id;
				}
			}
			if (isset($param["REFRESH"])){
				$newParamParams['refresh'] = $param["REFRESH"] == 'Y';
			}
			if (isset($param["MULTIPLE"])){
				$newParamParams['multiple'] = $param["MULTIPLE"] == 'Y';
			}
			if (isset($param["ADDITIONAL_VALUES"])){
				$newParamParams['additional_values'] = $param["ADDITIONAL_VALUES"] == 'Y';
			}
			$newParam = BitrixComponentsParams::updateOrCreate(
				[
					'code'         => $code,
					'component_id' => $this->id
				],
				$newParamParams
			);
			if (isset($param["VALUES"])){ // не думаю, что здесь нужна проверка на тип свойства, но всё же можно подумать об этом
				if (!is_array($param["VALUES"])){ // todo как вообще сюда мог массив попасть? я же не исполняю файлы! (проверить можно на news)
					if (ifStringIsValName($param["VALUES"])){
						$vals = $vArrParse->parseFromFile($this->getFolder(true).'/.parameters.php', $param["VALUES"]);
						// todo вариант, когда параметры вписаны в само значение в виде Array(...)
						if (count($vals)){
							$newParam->spec_vals = 'array';
							$newParam->save();
							foreach ($vals as $valKey => $valVal){
								$newVal = BitrixComponentsParamsVals::updateOrCreate(
									[
										'param_id' => $newParam->id,
										'key'      => $valKey
									],
									[
										'param_id' => $newParam->id,
										'key'      => $valKey,
										'value'    => extractLangVal($valVal, $this->getFolder(true).'/lang/ru/.parameters.php') // todo зачем мне каждый раз запускать парсер файла, мб лучше получить массив из ланга 1 раз
									]
								);
							}
						}
					}
				}
			}
		}
		//dd($info);
	}

	public function gatherListOfArbitraryFiles(){
		$dir = str_replace('\\', '/', $this->getFolder()); // todo к чему такие сложности
		$files = $this->module->disk()->allFiles($dir);

		foreach ($files as $file){
			$file = str_replace($dir, '', $file);

			if (in_array($file, $this->nonArbitraryFiles)){
				continue;
			}

			if (strpos($file, '/templates/') !== false){
				continue;
			}

			if (strpos($file, '/lang/') !== false){ // todo обрабатывать и ланги
				continue;
			}

			BitrixComponentsArbitraryFiles::addInBDExistingFile($file, $this);

			$langFiles = getLangFilesForThisFile($dir, $file);
			foreach ($langFiles as $langFile){
				BitrixComponentsArbitraryFiles::addInBDExistingFile($langFile, $this);
			}
		}
	}

	public function parseTemplates(){
		$dir = str_replace('\\', '/', $this->getFolder()); // todo к чему такие сложности
		$dirs = $this->module->disk()->directories($dir.'/templates');
		foreach ($dirs as $dir){
			$templatePathArr = explode('/', $dir);
			$templateCode = $templatePathArr[count($templatePathArr) - 1];

			$template = BitrixComponentsTemplates::updateOrCreate(
				[
					'component_id' => $this->id,
					'code'         => $templateCode
				],
				[
					'component_id' => $this->id,
					'code'         => $templateCode
				]
			);
			$template->parseParamsFile();
			$template->gatherListOfArbitraryFiles();
		}
	}

	public function getStepsAttribute($value){
		$steps = array_filter(explode(",", $value));

		return $steps;
	}

	public function getLangKeyAttribute(){
		return strtoupper($this->module()->first()->PARTNER_CODE."_".$this->code);
	}

	public function getComponentPhpAttribute(){
		$disk = $this->module()->first()->disk();
		$path = $this->getFolder().'\component.php';
		if ($disk->exists($path)){
			return $disk->get($path);
		}

		return false;
	}

	public function getClassPhpAttribute(){
		$disk = $this->module()->first()->disk();
		$path = $this->getFolder().'\class.php';
		if ($disk->exists($path)){
			return $disk->get($path);
		}

		return false;
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
