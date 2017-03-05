<?php

namespace App\Http\Controllers\Admin;

use App\Models\Modules\Bitrix\BitrixCoreEvents;
use App\Models\Modules\Bitrix\BitrixCoreModules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminClassPhpTemplatesController extends Controller{
	public function index(Request $request){
		$data = [
		];

		return view("admin.bitrix_class_php_templates.index", $data);
	}
}
