<?php

namespace App\Models\Modules\Bitrix;

use App\Helpers\vZipArchive;
use App\Http\Utilities\Bitrix\BitrixHelperFunctions;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\vArrParse;
use Illuminate\Support\Facades\Storage;

// todo магические числа у шагов
class BitrixComponent extends Model{
	protected $table = 'bitrix_components';
	protected $fillable = ['module_id', 'name', 'sort', 'code', 'icon_path', 'desc', 'namespace'];
	public $timestamps = false;
	public $nonArbitraryFiles = [
		DIRECTORY_SEPARATOR.'component.php',
		DIRECTORY_SEPARATOR.'class.php',
		DIRECTORY_SEPARATOR.'.description.php',
		DIRECTORY_SEPARATOR.'.parameters.php'
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
		$component_php = Storage::disk('modules_templates')->get('bitrix'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'component_name'.DIRECTORY_SEPARATOR.'component.php');

		$this->module()->first()->disk()->put($this->getFolder().DIRECTORY_SEPARATOR.'component.php', $component_php);

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

		$this->module()->first()->disk()->put($template->getFolder().DIRECTORY_SEPARATOR.'template.php', $template_php);

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
			isset($path_items[0]) ? $path_items[0]->code : '',
			isset($path_items[0]) ? $path_items[0]->sort : '',
			isset($path_items[0]) ? $path_items[0]->name : '',
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

		Bitrix::changeVarsInModuleFileAndSave('bitrix'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'component_name'.DIRECTORY_SEPARATOR.$file, $module->id, $search, $replace, $this->getFolder().DIRECTORY_SEPARATOR.'.description.php');
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
			isset($path_items[0]) ? $path_items[0]->name : '',
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

		Bitrix::changeVarsInModuleFileAndSave('bitrix'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'component_name'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'ru'.DIRECTORY_SEPARATOR.$file, $module->id, $search, $replace, $this->getFolder().DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'ru'.DIRECTORY_SEPARATOR.'.description.php');
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

		return $module_folder.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.$this->namespace.DIRECTORY_SEPARATOR.$this->code;
	}

	public function createFolder(){
		$this->module()->first()->disk()->makeDirectory($this->getFolder());
	}

	public function deleteFolder(){
		$this->module()->first()->disk()->deleteDirectory($this->getFolder());
	}

	public function generateZip(){
		$archiveName = public_path().DIRECTORY_SEPARATOR.'user_downloads'.DIRECTORY_SEPARATOR.$this->code.".zip";

		vZipArchive::createZipArchiveFromFolder($archiveName, $this->getFolder(true), $this->code);

		return $archiveName;
	}

	public function saveParamsInFile(){
		$module = $this->module()->first();
		$params = $this->params()->orderBy('sort', 'asc')->get();

		$groupsText = ''; // todo
		$groupsLangText = ''; // todo

		$paramsTexts = [];
		$helperFunctionsArr = [];

		foreach ($params as $param){
			//dd($param);
			if ($param->group_id){
				$parentCode = BitrixComponentsParamsGroups::find($param->group_id)->code;
			}

			$paramText = '"'.strtoupper($param->code).'"  =>  Array(
			"PARENT" => "'.$parentCode.'",
			"NAME" => GetMessage("'.$param->lang_key.'_NAME"),
			"TYPE" => "'.$param->type.'",'.PHP_EOL;

			$module->changeVarInLangFile($param->lang_key.'_NAME', $param->name, $param->lang_file_path);
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
				$module->changeVarInLangFile($param->lang_key.'_DEFAULT', $param->default, $param->lang_file_path);
				if (strpos($param->default, 'GetMessage') === false){
					$param->default = 'GetMessage("'.$param->lang_key.'_DEFAULT")';
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
							$module->changeVarInLangFile($val->lang_key.'_VALUE', $val->value, $param->lang_file_path);
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
				$helperFunctions = BitrixHelperFunctions::getPhpCodeFromListOfFuncsNames($helperFunctionsArr[$templateID]);
				$replace[2] = str_replace(Array('{LANG_KEY}'), Array($module->lang_key), $helperFunctions);
			}

			if (!$templateID){
				Bitrix::changeVarsInModuleFileAndSave('bitrix'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'component_name'.DIRECTORY_SEPARATOR.'.parameters.php', $module->id, $search, $replace, $this->getFolder().DIRECTORY_SEPARATOR.'.parameters.php');
				$module->changeVarInLangFile($module->lang_key.'_SELECT', trans('app.select'), $this->getFolder().DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'ru'.DIRECTORY_SEPARATOR.'.parameters.php');
			}else{
				$template = BitrixComponentsTemplates::find($templateID);
				Bitrix::changeVarsInModuleFileAndSave('bitrix'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'component_name'.DIRECTORY_SEPARATOR.'template_code'.DIRECTORY_SEPARATOR.'.parameters.php', $module->id, $search, $replace, $template->getFolder().DIRECTORY_SEPARATOR.'.parameters.php');
				$module->changeVarInLangFile($module->lang_key.'_SELECT', trans('app.select'), $template->getFolder().DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'ru'.DIRECTORY_SEPARATOR.'.parameters.php');
			}
		}
		if (empty($paramsTexts)){
			$replace = Array($groupsText, '');
			Bitrix::changeVarsInModuleFileAndSave('bitrix'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'component_name'.DIRECTORY_SEPARATOR.'.parameters.php', $module->id, $search, $replace, $this->getFolder().DIRECTORY_SEPARATOR.'.parameters.php');
		}

		return true;

	}

	public function parseDescriptionFile(){
		$vArrParse = new vArrParse;
		$descriptionFile = $this->getFolder(true).DIRECTORY_SEPARATOR.'.description.php';
		if (!file_exists($descriptionFile)){ // что нам тут делать, если файла нет
			return false;
		}
		$info = $vArrParse->parseFromFile($descriptionFile, 'arComponentDescription');

		$descriptionLangFile = $this->getFolder(true).DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'ru'.DIRECTORY_SEPARATOR.'.description.php';
		if (file_exists($descriptionLangFile)){
			$this->name = extractLangVal($info['NAME'], $descriptionLangFile);
			$this->desc = extractLangVal($info['DESCRIPTION'], $descriptionLangFile);
		}

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
						$pathItem['name'] = extractLangVal($info['PATH']["CHILD"]["CHILD"]['NAME'], $this->getFolder(true).DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'ru'.DIRECTORY_SEPARATOR.'.description.php');
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
		$parametersFile = $this->getFolder(true).DIRECTORY_SEPARATOR.'.parameters.php';
		if (!file_exists($parametersFile)){ // что нам тут делать, если файла нет
			return false;
		}
		$info = $vArrParse->parseFromFile($parametersFile, 'arComponentParameters');
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
						$vals = $vArrParse->parseFromFile($this->getFolder(true).DIRECTORY_SEPARATOR.'.parameters.php', $param["VALUES"]);
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

			if (strpos($file, DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR) !== false){
				continue;
			}

			if (strpos($file, DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR) !== false){ // todo обрабатывать и ланги
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
		$dir = str_replace(Array('\\'), '/', $this->getFolder()).'/templates'; // тут почему-то нужен именно такой слеш
		$dirs = $this->module->disk()->directories($dir);
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

	public function getClassPhp($functionsCodes = []){
		$functionsCodes[] = 'for all';
		$class_php = Storage::disk('modules_templates')->get('bitrix'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'component_name'.DIRECTORY_SEPARATOR.'class.php');
		$class_functions_php = Storage::disk('modules_templates')->get('bitrix'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'component_name'.DIRECTORY_SEPARATOR.'class_functions.php');

		$functions = preg_split('/(\/\/.+)/im', $class_functions_php, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE); // без s чтобы в . не было переноса строк
		// dd($functions);

		$neededFunctions = [];
		foreach ($functions as $c => $function){
			if ($c % 2 == 0){ // в чётных список функций
				$need = false;
				foreach ($functionsCodes as $functionsCode){
					if (strpos($function, $functionsCode) !== false){
						$need = true;
						break;
					}
				}
			}else{ // в нечётных сами функции
				if ($need){
					$neededFunctions[] = $function;
				}
			}
		}

		$class_php = str_replace(['{COMPONENT_CLASS_PHP_CLASS}', '{FUNCTIONS}'], [$this->class_php_class, implode('', $neededFunctions)], $class_php);

		return $class_php;
	}

	public function getParametersLangFilePathAttribute(){
		$langId = $this->module->default_lang;

		return $this->getFolder().DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$langId.DIRECTORY_SEPARATOR.'.parameters.php';
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
		$path = $this->getFolder().DIRECTORY_SEPARATOR.'component.php';
		if ($disk->exists($path)){
			return $disk->get($path);
		}

		return false;
	}

	public function getClassPhpAttribute(){
		$disk = $this->module()->first()->disk();
		$path = $this->getFolder().DIRECTORY_SEPARATOR.'class.php';
		if ($disk->exists($path)){
			return $disk->get($path);
		}

		return false;
	}

	public function getClassPhpClassAttribute(){
		return 'C'.studly_case($this->module()->first()->PARTNER_CODE."_".str_replace('.', '_', $this->code)).'Component';
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
