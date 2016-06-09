<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BitrixAdminOptionsVals extends Model{
	protected $table = 'bitrix_modules_options_vals_for_select';
	protected $fillable = ['option_id', 'key', 'value'];
	public $timestamps = false;

	public function getLangKeyAttribute(){
		return $this->option->lang_key.'_'.strtoupper($this->key).'_TITLE';
	}

	// связи с другими моделями
	public function option(){
		return $this->belongsTo('App\Models\Modules\Bitrix\BitrixAdminOptions');
	}
}
