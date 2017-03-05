<?php

namespace App\Http\Controllers;

use App\Models\Modules\Bitrix\BitrixComponentClassPhpTemplates;
use App\Models\Modules\Bitrix\BitrixCoreEvents;
use App\Models\Modules\Bitrix\BitrixCoreModules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProjectHelpController extends Controller{
	public function index(){
		$data = [];

		return view("project_help.index", $data);
	}

	// события Битрикса
	public function bitrixEvents(Request $request){
		$data = [
			'core_modules'    => BitrixCoreModules::approved()->get(),
			'existing_events' => BitrixCoreEvents::approved()->orderBy('module_id')->get()
		];

		return view("project_help.bitrix.events", $data);
	}

	public function bitrixEventsAdd(Request $request){
		$this->validate($request, [
			'module' => 'required',
			'event'  => 'required|unique:bitrix_core_events,code',
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

	public function bitrixClassPhpTemplatesAdd(Request $request){
		BitrixComponentClassPhpTemplates::create([
			'creator_id' => $this->user->id,
			'name'       => $request->name,
			'template'   => $request->template,
		]);

		return back();
	}

	public function bitrixClassPhpTemplatesDelete(BitrixComponentClassPhpTemplates $template, Request $request){
		if ($template->userCanUse($this->user) && !$template->isPublic()){
			$template->delete();
		}

		return back();
	}
}