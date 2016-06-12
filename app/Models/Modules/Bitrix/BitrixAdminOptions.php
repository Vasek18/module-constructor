<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Auth;

class BitrixAdminOptions extends Model{
	protected $table = 'bitrix_modules_options';
	protected $fillable = ['type', 'module_id', 'sort', 'code', 'name', 'height', 'width', 'spec_vals', 'spec_vals_args', 'default_value'];
	public $timestamps = false;

	public static function getDefaultType(){
		$stringType = DB::table('bitrix_modules_options_types')->where('FORM_TYPE', 'text')->first();
		if ($stringType && $stringType->FORM_TYPE){
			return $stringType->FORM_TYPE;
		}

		return 0;
	}

	public static function checkType($type){
		if (!$type){
			return BitrixAdminOptions::getDefaultType();
		}
		if (!DB::table('bitrix_modules_options_types')->where('FORM_TYPE', $type)->first()){
			return BitrixAdminOptions::getDefaultType();
		}

		return $type;
	}

	// сохраняем настройки в папку модуля
	static public function saveOptionFile(Bitrix $module){
		if ($module->options()->count()){

			$options = $module->options()->orderBy('sort', 'asc')->get();
			$optionsString = '';
			Bitrix::changeVarsInModuleFileAndSave('bitrix/lang/ru/options.php', $module->id); // todo нужно лишь для создания файла

			foreach ($options as $option){
				$field_params_string = $option->getParamsStringForFile($option->type);
				//dd($field_params_string);
				// код, название, значение по умолчанию, [тип поля, параметры]
				$string = PHP_EOL."\t\t\tarray('".$option->code."', Loc::getMessage('".$module->lang_key."_".strtoupper($option->code)."_TITLE'), '', array('".$option->type."'".$field_params_string.")),";
				//echo $string;

				$optionsString .= $string;

				$module->changeVarInLangFile($option->lang_key, $option->name, 'lang/ru/options.php');
				if ($option->type == 'selectbox' || $option->type == 'multiselectbox'){
					if ($option->vals->count()){
						foreach ($option->vals as $val){
							$module->changeVarInLangFile($val->lang_key, $val->value, 'lang/ru/options.php'); // todo, а это всегда надо?
						}
					}
				}
			}

			Bitrix::changeVarsInModuleFileAndSave('bitrix/options.php', $module->id, Array("{OPTIONS}"), Array($optionsString));
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
				//dd($this->spec_vals);
				if ($this->spec_vals == 'iblocks_list'){
					$params_string .= '$iblocks('.$this->spec_vals_args.')';
				}
				if ($this->spec_vals == 'iblock_items_list'){
					$params_string .= '$iblock_items('.$this->spec_vals_args.')';
				}
				if ($this->spec_vals == 'iblock_props_list'){
					$params_string .= '$iblock_props('.$this->spec_vals_args.')';
				}
			}
		}

		return $params_string;
	}

	public function getValsArrayStringForFile(){
		$vals = $this->vals()->get();

		$string = 'Array(';
		foreach ($vals as $val){
			$string .= "'".$val->key."' => Loc::getMessage('".$val->lang_key."'), ";
		}
		$string .= ')';

		return $string;
	}

	public function deleteProps(){
		BitrixAdminOptionsVals::where('option_id', $this->id)->delete();
	}

	public function getLangKeyAttribute(){
		return $this->module->lang_key.'_'.strtoupper($this->code).'_TITLE';
	}

	// связи с другими моделями
	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

	public function vals(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixAdminOptionsVals', "option_id");
	}
}
