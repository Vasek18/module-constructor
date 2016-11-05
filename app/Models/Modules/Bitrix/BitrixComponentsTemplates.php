<?php

namespace App\Models\Modules\Bitrix;

use App\Http\Utilities\Bitrix\BitrixComponentsParamsTypes;
use Illuminate\Database\Eloquent\Model;
use Chumper\Zipper\Zipper;
use App\Helpers\vArrParse;

class BitrixComponentsTemplates extends Model{
	protected $table = 'bitrix_components_templates';
	protected $fillable = ['component_id', 'code', 'name'];
	public $timestamps = false;
	public $nonArbitraryFiles = [
		'/template.php',
		'/result_modifier.php',
		'/component_epilog.php',
		'/.parameters.php',
		'/script.js',
		'/style.css',
		'/lang/*/template.php',
		'/lang/*/result_modifier.php',
		'/lang/*/component_epilog.php',
		'/lang/*/.parameters.php',
		'/lang/*/script.js',
		'/lang/*/style.css',
	];

	public function extractUploadedZip($archive){
		$fileName = time().$archive->getClientOriginalName();
		$archivePath = public_path().'/user_upload/';
		$archive->move($archivePath, $fileName);

		$zipper = new Zipper;
		$zipper->make($archivePath.$fileName);
		if ($zipper->contains('template.php')){
			$this->createFolder();
			$zipper->extractTo($this->component->getFolder(true).'/templates/'.$this->code);
		}else{
			$zipper->extractTo($this->component->getFolder(true).'/templates/');
		}
		$zipper->close();

		unlink($archivePath.$fileName);
	}

	public function createFolder(){
		$this->component()->first()->module()->first()->disk()->makeDirectory($this->component->getFolder().'/templates/'.$this->code);
	}

	public function getFolder($full = false){
		$component_folder = $this->component()->first()->getFolder($full);

		return $component_folder.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$this->code;
	}

	public function disk(){
		return $this->component->module->disk();
	}

	public function parseParamsFile(){
		// todo создание групп свойств
		// todo подтягивать имена стандартных значений, если они не указаны (например CACHE_TIME)

		if (file_exists($this->getFolder(true).'/.parameters.php')){
			$vArrParse = new vArrParse;
			$params = $vArrParse->parseFromFile($this->getFolder(true).'/.parameters.php', 'arTemplateParameters');
			foreach ($params as $code => $param){
				// if ($code == 'POPUP_QUESTION_TITLE'){
				// 	dd($param);
				// }
				$newParamParams = [
					'code'         => $code,
					'component_id' => $this->component->id,
					'template_id'  => $this->id,
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
					if (!isset(BitrixComponentsParamsTypes::$types[$param["TYPE"]])){
						$param["TYPE"] = 'STRING';
					}
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
				// if ($code == 'POPUP_QUESTION_TITLE'){
				// 	dd($newParamParams);
				// }
				$newParam = BitrixComponentsParams::updateOrCreate([
					'code'         => $code,
					'component_id' => $this->component->id,
					'template_id'  => $this->id,
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
	}

	public function gatherListOfArbitraryFiles(){
		$dir = str_replace('\\', '/', $this->getFolder()); // todo к чему такие сложности
		$files = $this->disk()->allFiles($dir);

		foreach ($files as $file){
			$file = str_replace($dir, '', $file);
			$file = preg_replace('/\/lang\/[a-z]+/is', '/lang/*', $file);
			// if (strpos($file, 'lang') !== false){
			// 	dd($file);
			// }

			if (in_array($file, $this->nonArbitraryFiles)){
				continue;
			}

			// dd($file);

			BitrixComponentsArbitraryFiles::addInBDExistingFile($file, $this->component, $this);
		}
	}

	public function getParametersLangFilePathAttribute(){
		$langId = $this->component->module->default_lang;
		return $this->getFolder().DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.$langId.DIRECTORY_SEPARATOR.'.parameters.php';
	}

	public function getTemplatePhpAttribute(){
		$code = "";
		$path = $this->getFolder().DIRECTORY_SEPARATOR.'template.php';
		if ($this->disk()->exists($path)){
			$code = $this->disk()->get($path);
		}

		return $code;
	}

	public function getStyleCssAttribute(){
		$code = "";
		$path = $this->getFolder().DIRECTORY_SEPARATOR.'style.css';
		if ($this->disk()->exists($path)){
			$code = $this->disk()->get($path);
		}

		return $code;
	}

	public function getScriptJsAttribute(){
		$code = "";
		$path = $this->getFolder().DIRECTORY_SEPARATOR.'script.js';
		if ($this->disk()->exists($path)){
			$code = $this->disk()->get($path);
		}

		return $code;
	}

	public function getResultModifierPhpAttribute(){
		$code = "";
		$path = $this->getFolder().DIRECTORY_SEPARATOR.'result_modifier.php';
		if ($this->disk()->exists($path)){
			$code = $this->disk()->get($path);
		}

		return $code;
	}

	public function getComponentEpilogPhpAttribute(){
		$code = "";
		$path = $this->getFolder().DIRECTORY_SEPARATOR.'component_epilog.php';
		if ($this->disk()->exists($path)){
			$code = $this->disk()->get($path);
		}

		return $code;
	}

	public function component(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixComponent');
	}

	public function params(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixComponentsParams', "template_id");
	}

	public function arbitraryFiles(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixComponentsArbitraryFiles', "template_id");
	}
}
