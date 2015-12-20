<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Bitrix extends Model{
	//

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bitrixes';

	// создание модуля
	public static function create(array $attributes = Array()){
		// запись в БД
		$bitrix = new Bitrix;

		$bitrix->name = $attributes["MODULE_NAME"];

		$bitrix->save();

		//DB::table($table)->insert(
		//	array('email' => 'john@example.com', 'votes' => 0)
		//);
	}
}
