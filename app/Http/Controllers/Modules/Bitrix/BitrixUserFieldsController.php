<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Http\Controllers\Traits\UserOwnModule;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Http\Request;

class BitrixUserFieldsController extends Controller{
	use UserOwnModule;

	public function create(Bitrix $module, Request $request){
		$data = [
			'module'    => $module,
			'user_field' => null,
		];

		return view("bitrix.data_storage.user_fields.add", $data);
	}
}