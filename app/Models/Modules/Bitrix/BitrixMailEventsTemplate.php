<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixMailEventsTemplate extends Model{
	protected $table = 'bitrix_mail_events_templates';
	protected $fillable = [
		'mail_event_id',
		'name',
		'from',
		'to',
		'copy',
		'hidden_copy',
		'reply_to',
		'in_reply_to',
		'theme',
		'body'
	];
	public $timestamps = false;

	public function generateCreationCode(){
		$code = '$this->createMailTemplate(Array(
			'."\t".'"EVENT_NAME" => "'.$this->mailEvent->code.'",
			'."\t".'"EMAIL_FROM" => "'.$this->from.'",
			'."\t".'"EMAIL_TO"   => "'.$this->to.'",
			'."\t".'"BCC"        => "'.$this->hidden_copy.'",
			'."\t".'"SUBJECT"    => Loc::getMessage("'.$this->lang_key.'_THEME"),
			'."\t".'"BODY_TYPE"  => "html",
			'."\t".'"MESSAGE"    => Loc::getMessage("'.$this->lang_key.'_BODY")
		));'.PHP_EOL;

		return $code;
	}

	public function deleteLangCode(){
		$this->mailEvent->module->changeVarInLangFile($this->lang_key.'_THEME', "", '/lang/'.$this->mailEvent->module->default_lang.'/install/index.php');
		$this->mailEvent->module->changeVarInLangFile($this->lang_key.'_BODY', "", '/lang/'.$this->mailEvent->module->default_lang.'/install/index.php');
	}

	public function getLangKeyAttribute(){
		return $this->mailEvent->lang_key.strtoupper('_TEMPLATE_'.$this->id); // todo нужно не айди, а что-то другое, это как минимум не безопасно
	}

	public function mailEvent(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixMailEvents');
	}

}
