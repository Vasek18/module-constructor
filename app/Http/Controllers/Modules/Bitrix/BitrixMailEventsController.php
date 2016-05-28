<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixMailEvents;
use App\Models\Modules\Bitrix\BitrixMailEventsVar;
use App\Http\Controllers\Traits\UserOwnModule;

class BitrixMailEventsController extends Controller{

	use UserOwnModule;

	public function index(Bitrix $module, Request $request){
		$mail_events = $module->mailEvents()->get();

		$data = [
			'module'      => $module,
			'mail_events' => $mail_events

		];

		return view("bitrix.mail_events.index", $data);
	}

	public function create(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$data = [
			'module' => $module,
		];

		return view("bitrix.mail_events.new", $data);
	}

	public function store(Bitrix $module, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$mail_event = BitrixMailEvents::updateOrCreate(
			[
				'module_id' => $module->id,
				'code'  => $request->MAIL_EVENT_CODE
			],
			[
				'module_id' => $module->id,
				'name'      => $request->MAIL_EVENT_NAME,
				'code'  => $request->MAIL_EVENT_CODE,
				'sort'  => $request->MAIL_EVENT_SORT
			]
		);

		foreach ($request->MAIL_EVENT_VARS_CODES as $i => $code){
			$mail_event_var = BitrixMailEventsVar::updateOrCreate(
				[
					'mail_event_id' => $mail_event->id,
					'code'  => $code
				],
				[
					'mail_event_id' => $mail_event->id,
					'name'      => $request->MAIL_EVENT_VARS_NAMES[$i],
					'code'  => $code
				]
			);
		}

		return redirect(action('Modules\Bitrix\BitrixMailEventsController@show', [$module->id, $mail_event->id]));
	}

	public function show(Bitrix $module, BitrixMailEvents $mail_event, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$data = [
			'module'     => $module,
			'mail_event'  => $mail_event
		];

		return view("bitrix.mail_events.detail", $data);
	}

	public function edit($id){
		//
	}

	public function update(Bitrix $module, Request $request){

	}

	public function destroy(Bitrix $module, Request $request){

	}
}
