<?php

namespace App\Http\Controllers\Admin;

use App\Models\Modules\Bitrix\BitrixComponentClassPhpTemplates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminClassPhpTemplatesController extends Controller{
	public function index(Request $request){
		$data = [
			'public_templates' => BitrixComponentClassPhpTemplates::publicTemplates()->get(),
		];

		return view("admin.bitrix_class_php_templates.index", $data);
	}

	public function private_ones(Request $request){
		$data = [
			'private_templates' => BitrixComponentClassPhpTemplates::privateTemplates()->get(),
		];

		return view("admin.bitrix_class_php_templates.private_ones", $data);
	}

	public function add(Request $request){
		BitrixComponentClassPhpTemplates::create([
			'name'          => $request->name,
			'code'          => $request->code,
			'template'      => $request->template,
			'show_everyone' => true,
		]);

		return back();
	}

	public function delete(Request $request, BitrixComponentClassPhpTemplates $template){
		$template->delete();

		return back();
	}

	public function edit(Request $request, BitrixComponentClassPhpTemplates $template){
		$data = [
			'template' => $template,
		];

		return view("admin.bitrix_class_php_templates.edit", $data);
	}

	public function update(Request $request, BitrixComponentClassPhpTemplates $template){
		$template->update([
			'name'     => $request->name,
			'code'     => $request->code,
			'template' => $request->template,
		]);

		return redirect(action('Admin\AdminClassPhpTemplatesController@index'));
	}
}
