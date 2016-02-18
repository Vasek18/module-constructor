<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BitrixAdminOptions extends Model{
	protected $table = 'bitrix_modules_options';

	public static function store($fields){
		// если есть поле с таким же кодом, обновляем старое, а не создаём новое
		if (BitrixAdminOptions::where('module_id', $fields["module_id"])->where('code', $fields["code"])->count()){
			$id = BitrixAdminOptions::where('module_id', $fields["module_id"])->where('code', $fields["code"])->first()->id;
			$option = BitrixAdminOptions::find($id);
		}else{
			$option = new BitrixAdminOptions;
			$option->code = $fields['code'];
		}

		// запись в БД
		$option->module_id = $fields['module_id'];
		$option->name = $fields['name'];
		$option->type_id = $fields['type_id'];
		$option->height = $fields['height'];
		$option->width = $fields['width'];
		//dd($fields);

		if ($option->save()){
			return $option->id;
		}
	}

	// сохраняем настройки в папку модуля
	static public function saveOptionFile($module_id){
		if (BitrixAdminOptions::where('module_id', $module_id)->count()){
			$module = Bitrix::find($module_id);
			$LANG_KEY = strtoupper($module->PARTNER_CODE."_".$module->MODULE_CODE);

			$options = BitrixAdminOptions::where('module_id', $module_id)->get();
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

				$field_params_in_string = '';
				if ($option_type == "text"){
					// параметры text - ширина
					$field_params_in_string = ', '.$option->width;
				}
				if ($option_type == "textarea"){
					// параметры textarea - высота и ширина
					$field_params_in_string = ', '.$option->height.', '.$option->width;
				}
				if ($option_type == "select"){
					// параметры select - список опшионов
				}

				// код, название, значение по умолчанию, [тип поля, параметры]
				$string = PHP_EOL."array('".$option->code."', Loc::getMessage('".$LANG_KEY."_".strtoupper($option->code)."_TITLE'), '', array('".$option_type."'".$field_params_in_string.")),";
				//echo $string;

				$optionsString .= $string;

				$optionsLangString .= '$MESS["'.$LANG_KEY.'_'.strtoupper($option->code).'_TITLE"] = "'.$option->name.'";'.PHP_EOL;
			}

			Bitrix::changeVarsInModuleFileAndSave('bitrix/options.php', $module_id, Array("{OPTIONS}"), Array($optionsString));
			Bitrix::changeVarsInModuleFileAndSave('bitrix/lang/ru/options.php', $module_id, Array("{OPTIONS_LANG}"), Array($optionsLangString));
		}
	}

	// связи с другими моделями
	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix');
	}

	public function vals(){
		return $this->hasMany('App\Models\Modules\BitrixAdminOptionsVals', "option_id");
	}
}
