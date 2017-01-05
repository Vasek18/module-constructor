<?php

namespace App\Http\Controllers;

use App\Models\Modules\Bitrix\BitrixCoreEvents;
use App\Models\Modules\Bitrix\BitrixCoreModules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProjectHelpController extends Controller{

	// события Битрикса
	public function bitrixEvents(Request $request){
		$data = [
			'core_modules'    => BitrixCoreModules::approved()->get(),
			'existing_events' => BitrixCoreEvents::approved()->get()
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

		$event = BitrixCoreEvents::create([
				'module_id'   => $module->id,
				'code'        => $request->event,
				'params'      => $request->params,
				'description' => $request->description,
			]
		);

		// письмо мне
		Mail::send('emails.admin.new_bitrix_core_action', ['event' => $event, 'module' => $module], function ($m){
			$m->to(env('GOD_EMAIL'))->subject('Предложенно новое событие');
		});

		flash()->success(trans('project_help.bitrix_events_add_confirmation'));

		return back();
	}

	public function bitrixEventsMarkAsBad(BitrixCoreEvents $event, Request $request){
		$event->markAsBad();

		flash()->success(trans('project_help.bitrix_events_mark_bad_confirmation'));

		return back();
	}
}