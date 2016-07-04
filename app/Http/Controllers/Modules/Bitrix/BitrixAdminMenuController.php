<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Http\Controllers\Traits\UserOwnModule;
use App\Models\Modules\Bitrix\BitrixAdminMenuItems;

class BitrixAdminMenuController extends Controller{

	use UserOwnModule;

	public function index(Bitrix $module, Request $request){
		$admin_menu_pages = $module->adminMenuPages()->get();

		$data = [
			'module'           => $module,
			'admin_menu_pages' => $admin_menu_pages

		];

		return view("bitrix.admin_menu.index", $data);
	}

	public function create(Bitrix $module, Request $request){
		$data = [
			'module'           => $module,
			'parent_menu_vars' => BitrixAdminMenuItems::$parent_menu_vars
		];

		return view("bitrix.admin_menu.new", $data);
	}

	public function store(Bitrix $module, Request $request){
		$mail_event = BitrixAdminMenuItems::updateOrCreate(
			[
				'module_id' => $module->id,
				'name'      => $request->name,
				'code'      => $request->code,
			],
			[
				'module_id'   => $module->id,
				'name'        => $request->name,
				'code'        => $request->code,
				'parent_menu' => $request->parent_menu,
				'sort'        => $request->sort,
				'text'        => $request->text,
				'php_code'    => $request->php_code,
			]
		);

		return redirect(action('Modules\Bitrix\BitrixAdminMenuController@index', [$module->id]));
		// return redirect(action('Modules\Bitrix\BitrixMailEventsController@show', [$module->id, $mail_event->id]));
	}

	public function show(Bitrix $module, BitrixAdminMenuItems $admin_menu_page, Request $request){
	}

	public function edit($id){
		//
	}

	public function update(Bitrix $module, BitrixAdminMenuItems $admin_menu_page, Request $request){
	}

	public function destroy(Bitrix $module, BitrixAdminMenuItems $admin_menu_page, Request $request){
	}

}