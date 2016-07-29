<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixHelperFunctions extends Model{
	protected $table = 'bitrix_helper_functions';
	protected $fillable = ['is_closure', 'name', 'body'];
	public $timestamps = false;

	public static function getPhpCodeFromListOfFuncsNames($module, $list = []){
		$answer = '';
		$list = array_unique($list);
		foreach ($list as $name){
			if (!$name){
				continue;
			}
			$function = BitrixHelperFunctions::where('name', $name)->first();
			$answer .= $function->php_code.';'.PHP_EOL.PHP_EOL;
		}

		$answer = str_replace(Array('{LANG_KEY}'), Array($module->lang_key), $answer);

		return $answer;
	}

	public function getPhpCodeAttribute(){
		$args = '';
		foreach ($this->args as $arg){
			$args .= '$'.$arg->name;
		}

		return $code = '$'.$this->name.' = function('.$args.'){'.$this->body.'}';
	}

	public function args(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixHelperFunctionsArgs', 'function_id');
	}

}