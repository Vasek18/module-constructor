<?php

namespace App\Http\Controllers\Modules\Bitrix;

use App\Http\Controllers\Traits\UserOwnModule;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixUserField;
use Illuminate\Http\Request;

class BitrixUserFieldsController extends Controller{
	use UserOwnModule;

	public function create(Bitrix $module, Request $request){
		$data = [
			'module'         => $module,
			'userFieldTypes' => BitrixUserField::$types,
			'user_field'     => null,
		];

		return view("bitrix.data_storage.user_fields.add", $data);
	}

	// todo проверка владения модулем
	public static function store(Bitrix $module, Request $request){
		BitrixUserField::create([
			'module_id'         => $module->id,
			'user_type_id'      => $request->user_type_id,
			'entity_id'         => $request->entity_id,
			'field_name'        => $request->field_name,
			'xml_id'            => $request->xml_id,
			'sort'              => $request->sort,
			'multiple'          => $request->multiple == 'Y',
			'mandatory'         => $request->mandatory == 'Y',
			'show_filter'       => $request->show_filter,
			'show_in_list'      => $request->show_in_list == 'Y',
			'edit_in_list'      => $request->edit_in_list == 'Y',
			'is_searchable'     => $request->is_searchable == 'Y',
			'settings'          => json_encode($request->settings),
			'edit_form_label'   => json_encode($request->edit_form_label),
			'list_column_label' => json_encode($request->list_column_label),
			'list_filter_label' => json_encode($request->list_filter_label),
			'error_message'     => json_encode($request->error_message),
			'help_message'      => json_encode($request->help_message),
		]);

		return back();
	}
}