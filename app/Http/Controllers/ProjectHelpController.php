<?php

namespace App\Http\Controllers;

use App\Models\Modules\Bitrix\BitrixCoreEvents;
use App\Models\Modules\Bitrix\BitrixCoreModules;
use Illuminate\Http\Request;

class ProjectHelpController extends Controller{

	// события Битрикса
	public function bitrixEvents(Request $request){
		$data = [
			'core_modules'    => BitrixCoreModules::all(),
			'existing_events' => BitrixCoreEvents::all()
		];

		return view("project_help.bitrix.events", $data);
	}

	public function bitrixEventsAdd(Request $request){
		$this->validate($request, [
			'module' => 'required',
			'event'  => 'required',
		]);

		if (BitrixCoreModules::where('code', $request->module)->count()){
			$module = BitrixCoreModules::where('code', $request->module)->first();
		}else{ // слабое место
			$module = BitrixCoreModules::create([
				'code' => $request->module
			]);
		}

		BitrixCoreEvents::create([
				'module_id'   => $module->id,
				'code'        => $request->event,
				'params'      => $request->params,
				'description' => $request->description,
			]
		);

		return back();
	}

	public function bitrixEventsMarkAsBad(BitrixCoreEvents $event, Request $request){
		$event->markAsBad();

		return back();
	}
}