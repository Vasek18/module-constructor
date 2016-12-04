<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSettingsController extends Controller{
	public function index(){
		$data = [
			'settings' => Setting::all()
		];

		return view("admin.settings", $data);
	}

	public function store(Request $request){
		Setting::create([
			'name'  => $request->name,
			'code'  => $request->code,
			'value' => $request->value,
		]);

		return back();
	}

	public function set(Setting $setting, Request $request){
		$setting->update([
			'value' => $request->value
		]);

		return back();
	}
}
