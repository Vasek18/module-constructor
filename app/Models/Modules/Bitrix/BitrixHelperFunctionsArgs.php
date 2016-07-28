<?php

namespace App\Models\Modules\Bitrix;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BitrixHelperFunctionsArgs extends Model{
	protected $table = 'bitrix_helper_functions';
	protected $fillable = ['function_id', 'name'];
	public $timestamps = false;
}