<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectHelpController extends Controller{

	public function events(Request $request){

		$data = [
			'existing_events' => DB::table('bitrix_core_events')->get()
		];

		return view("project_help.bitrix.events", $data);
	}


}
