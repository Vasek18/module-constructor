<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class BitrixAdminOptions extends Model{
	protected $table = 'bitrix_modules_options';
	protected $fillable = ['type_id', 'module_id', 'sort', 'code', 'name', 'height', 'width', 'spec_vals', 'spec_vals_args', 'default_value'];
	public $timestamps = false;

	public static function getDefaultTypeId(){
		$stringType = DB::table('bitrix_modules_options_types')->where('FORM_TYPE', 'text')->first();
		if ($stringType && $stringType->id){
			return $stringType->id;
		}

		return 0;
	}

	public static function checkTypeId($type_id){
		if (!$type_id){
			return BitrixAdminOptions::getDefaultTypeId();
		}
		if (!DB::table('bitrix_modules_options_types')->where('id', $type_id)->first()){
			return BitrixAdminOptions::getDefaultTypeId();
		}

		return $type_id;
	}

	// сохраняем настройки в папку модуля
	static public function saveOptionFile($module_id){
		if (BitrixAdminOptions::where('module_id', $module_id)->count()){
			$module = Bitrix::find($module_id);

			$options = $module->options()->orderBy('sort', 'asc')->get();
			$optionsString = '';
			$optionsLangString = '';

			// получаем типы полей
			$dboptionsTypes = DB::table('bitrix_modules_options_types')->get(); // приводим к типу, где ключом выступает id, чтобы получать инфу по идентификатору типа // todo скорее всего есть способ легче всё это получать
			$optionsTypes = [];
			foreach ($dboptionsTypes as $option){
				$optionsTypes[$option->id] = $option;
			}

			foreach ($options as $option){
				$option_type = $optionsTypes[$option->type_id]->FORM_TYPE;

				$field_params_string = $option->getParamsStringForFile($option_type);

				// код, название, значение по умолчанию, [тип поля, параметры]
				$string = PHP_EOL."\t\t\tarray('".$option->code."', Loc::getMessage('".$module->lang_key."_".strtoupper($option->code)."_TITLE'), '', array('".$option_type."'".$field_params_string.")),";
				//echo $string;

				$optionsString .= $string;

				$optionsLangString .= '$MESS["'.$module->lang_key.'_'.strtoupper($option->code).'_TITLE"] = "'.$option->name.'";'.PHP_EOL;
			}

			Bitrix::changeVarsInModuleFileAndSave('bitrix/options.php', $module_id, Array("{OPTIONS}"), Array($optionsString));
			Bitrix::changeVarsInModuleFileAndSave('bitrix/lang/ru/options.php', $module_id, Array("{OPTIONS_LANG}"), Array($optionsLangString));
		}
	}

	public function getParamsStringForFile($option_type){
		$params_string = ', ';
		if ($option_type == "text"){
			// параметры text - ширина
			$params_string .= $this->width;
		}
		if ($option_type == "textarea"){
			// параметры textarea - высота и ширина
			$params_string .= $this->height.', '.$this->width;
		}
		if ($option_type == "checkbox"){
			$params_string .= '"'.$this->spec_vals_args.'"';
		}
		if ($option_type == "selectbox" || $option_type == "multiselectbox"){
			if (!$this->spec_vals || $this->spec_vals == 'array'){
				$params_string .= $this->getValsArrayStringForFile();
			}else{
				$params_string .= str_replace('()', '('.$this->spec_vals_args.')', $this->spec_vals);
			}
		}

		return $params_string;
	}

	public function getValsArrayStringForFile(){
		$vals = $this->vals()->get();

		$string = 'Array(';
		foreach ($vals as $val){
			$string .= "'".$val->key."' => '".$val->value."', ";
		}
		$string .= ')';

		return $string;
	}

	// связи с другими моделями
	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix');
	}

	public function vals(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixAdminOptionsVals', "option_id");
	}
}
