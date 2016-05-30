<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixMailEvents extends Model{
	protected $table = 'bitrix_mail_events';
	protected $fillable = ['module_id', 'code', 'name', 'sort'];
	public $timestamps = false;

	public function generateCreationCode(){
		$code = 'createMailEvent("'.$this->code.'", Loc::getMessage("'.$this->lang_key.'_NAME"), Loc::getMessage("'.$this->lang_key.'_DESC"), '.$this->sort.');';

		return $code;
	}

	public function generateDeletionCode(){
		$code = 'deleteMailEvent("'.$this->code.'");';

		return $code;
	}

	public function deleteLangCode(){
		$this->module->changeVarInLangFile($this->lang_key.'_NAME', "", '/lang/ru/install/index.php');
		$this->module->changeVarInLangFile($this->lang_key.'_DESC', "", '/lang/ru/install/index.php');
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
