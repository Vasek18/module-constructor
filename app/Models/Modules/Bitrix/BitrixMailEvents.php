<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Helpers\vFuncParse;

class BitrixMailEvents extends Model{
	protected $table = 'bitrix_mail_events';
	protected $fillable = ['module_id', 'code', 'name', 'sort'];
	public $timestamps = false;

	public static function writeInFile($module){
		$path = $module->module_folder.'/install/index.php';
		$file = $module->disk()->get($path);

		$creationFunctionCodeTemplate = vFuncParse::parseFromFile($module->getFolder(true).'/install/index.php', 'createNecessaryMailEvents');
		$creationFunctionCode = static::generateCreationFunctionCode($module);

		$deletionFunctionCodeTemplate = vFuncParse::parseFromFile($module->getFolder(true).'/install/index.php', 'deleteNecessaryMailEvents');
		$deletionFunctionCode = static::generateDeletionFunctionCode($module);

		$search = [$creationFunctionCodeTemplate, $deletionFunctionCodeTemplate];
		$replace = [$creationFunctionCode, $deletionFunctionCode];
		$file = str_replace($search, $replace, $file);

		$module->disk()->put($path, $file);

		static::manageHelpersFunctions($module);

		static::writeInLangFile($module);

		return true;
	}

	public static function generateCreationFunctionCode($module){
		$code = 'function createNecessaryMailEvents(){'.PHP_EOL;
		if ($module->mailEvents()->count()){
			foreach ($module->mailEvents as $mailEvent){
				$code .= $mailEvent->generateCreationCode();
				foreach ($mailEvent->templates as $template){
					$code .= "\t\t".$template->generateCreationCode().PHP_EOL;
				}
			}

		}else{
			$code .= "\t"."\t".'return true;'.PHP_EOL;
		}
		$code .= "\t".'}';

		return $code;
	}

	public static function generateDeletionFunctionCode($module){
		$code = 'function deleteNecessaryMailEvents(){'.PHP_EOL;
		if ($module->mailEvents()->count()){
			foreach ($module->mailEvents as $mailEvent){
				$code .= "\t\t".$mailEvent->generateDeletionCode().PHP_EOL;
			}
		}else{
			$code .= "\t"."\t".'return true;'.PHP_EOL;
		}
		$code .= "\t".'}';

		return $code;
	}

	public static function writeInLangFile($module){
		foreach ($module->mailEvents as $mailEvent){
			$module->changeVarInLangFile($mailEvent->lang_key.'_NAME', $mailEvent->name, '/lang/ru/install/index.php');
			$module->changeVarInLangFile($mailEvent->lang_key.'_DESC', $mailEvent->description, '/lang/ru/install/index.php');
			foreach ($mailEvent->templates as $template){
				$module->changeVarInLangFile($template->lang_key.'_THEME', $template->theme, '/lang/ru/install/index.php');
				$module->changeVarInLangFile($template->lang_key.'_BODY', $template->body, '/lang/ru/install/index.php');
			}
		}
	}

	public function generateCreationCode(){
		$code = '$this->createMailEvent("'.$this->code.'", Loc::getMessage("'.$this->lang_key.'_NAME"), Loc::getMessage("'.$this->lang_key.'_DESC"), '.$this->sort.');'.PHP_EOL;

		return $code;
	}

	public function generateDeletionCode(){
		$code = '$this->deleteMailEvent("'.$this->code.'");';

		return $code;
	}

	public function deleteLangCode(){
		foreach ($this->templates as $template){
			$template->deleteLangCode();
		}
		$this->module->changeVarInLangFile($this->lang_key.'_NAME', "", '/lang/ru/install/index.php');
		$this->module->changeVarInLangFile($this->lang_key.'_DESC', "", '/lang/ru/install/index.php');
	}

	public static function manageHelpersFunctions($module){
		if ($module->mailEvents()->count()){
			$module->addAdditionalInstallHelpersFunctions(['createMailEvent', 'deleteMailEvent'], 'mail.php');
			$issetTemplate = false;
			foreach ($module->mailEvents as $mailEvent){
				if ($mailEvent->templates()->count()){
					$issetTemplate = true;
				}
			}

			if ($issetTemplate){
				$module->addAdditionalInstallHelpersFunctions(['createMailTemplate'], 'mail.php');
			}else{
				$module->removeAdditionalInstallHelpersFunctions(['createMailTemplate']);
			}

		}else{
			$module->removeAdditionalInstallHelpersFunctions(['createMailEvent', 'createMailTemplate', 'deleteMailEvent']);
		}
	}

	public function getLangKeyAttribute(){
		return $this->module->lang_key.strtoupper('_MAIL_EVENT_'.$this->code);
	}

	public function getDescriptionAttribute(){
		$descCode = '';
		foreach ($this->vars as $var){
			$descCode .= "#".$var->code."# - ".$var->name.PHP_EOL;
		}

		return $descCode;
	}

	public function module(){
		return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
	}

	public function vars(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixMailEventsVar', 'mail_event_id');
	}

	public function templates(){
		return $this->hasMany('App\Models\Modules\Bitrix\BitrixMailEventsTemplate', 'mail_event_id');
	}
}
