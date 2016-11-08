<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSettingsController extends Controller{
	public function set(Setting $setting, Request $request){
		$setting->update([
			'value' => $request->value
		]);

		return back();
	}
}
