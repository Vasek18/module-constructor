<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BitrixAdminOptionsVals extends Model{
	protected $table = 'bitrix_modules_options_vals_for_select';

	// связи с другими моделями
	public function option(){
		return $this->belongsTo('App\Models\Modules\BitrixAdminOptions');
	}
}
