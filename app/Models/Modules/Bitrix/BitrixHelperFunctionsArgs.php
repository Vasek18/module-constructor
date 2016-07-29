<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixHelperFunctionsArgs extends Model{
	protected $table = 'bitrix_helper_functions_args';
	protected $fillable = ['function_id', 'name'];
	public $timestamps = false;
}