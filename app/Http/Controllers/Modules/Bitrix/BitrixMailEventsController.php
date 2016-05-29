<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixMailEvents;
use App\Models\Modules\Bitrix\BitrixMailEventsVar;
use App\Models\Modules\Bitrix\BitrixMailEventsTemplate;
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
				'code'      => $request->MAIL_EVENT_CODE
			],
			[
				'module_id' => $module->id,
				'name'      => $request->MAIL_EVENT_NAME,
				'code'      => $request->MAIL_EVENT_CODE,
				'sort'      => $request->MAIL_EVENT_SORT
			]
		);

		foreach ($request->MAIL_EVENT_VARS_CODES as $i => $code){
			$mail_event_var = BitrixMailEventsVar::updateOrCreate(
				[
					'mail_event_id' => $mail_event->id,
					'code'          => $code
				],
				[
					'mail_event_id' => $mail_event->id,
					'name'          => $request->MAIL_EVENT_VARS_NAMES[$i],
					'code'          => $code
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
			'mail_event' => $mail_event
		];

		return view("bitrix.mail_events.detail", $data);
	}

	public function edit($id){
		//
	}

	public function update(Bitrix $module, BitrixMailEvents $mail_event, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		if ($request->code){
			$mail_event->code = $request->code;
			$mail_event->save();
		}

		if ($request->name){
			$mail_event->name = $request->name;
			$mail_event->save();
		}

		if ($request->sort){
			$mail_event->sort = $request->sort;
			$mail_event->save();
		}

		if (!$request->ajax()){
			return redirect(action('Modules\Bitrix\BitrixMailEventsController@show', [$module->id, $mail_event->id]));
		}
	}

	public function destroy(Bitrix $module, BitrixMailEvents $mail_event, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$mail_event->delete();

		return redirect(action('Modules\Bitrix\BitrixMailEventsController@index', [$module->id]));
	}

	public function create_template(Bitrix $module, BitrixMailEvents $mail_event, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$data = [
			'module'     => $module,
			'mail_event' => $mail_event,
			'template'   => null
		];

		return view("bitrix.mail_events.mail_template", $data);
	}

	public function store_template(Bitrix $module, BitrixMailEvents $mail_event, Request $request){

		$template = BitrixMailEventsTemplate::create(
			[
				'mail_event_id' => $mail_event->id,
				'name'          => $request->name,
				'from'          => $request->from,
				'to'            => $request->to,
				'copy'          => $request->copy,
				'hidden_copy'   => $request->hidden_copy,
				'reply_to'      => $request->reply_to,
				'in_reply_to'   => $request->in_reply_to,
				'body'          => $request->body
			]
		);

		return redirect(action('Modules\Bitrix\BitrixMailEventsController@show', [$module->id, $mail_event->id]));
	}

	public function show_template(Bitrix $module, BitrixMailEvents $mail_event, BitrixMailEventsTemplate $template, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}
		$data = [
			'module'     => $module,
			'mail_event' => $mail_event,
			'template'   => $template
		];

		return view("bitrix.mail_events.mail_template", $data);
	}

	public function update_template(Bitrix $module, BitrixMailEvents $mail_event, BitrixMailEventsTemplate $template, Request $request){

		//dd($template->id);

		$template->name = $request->name;
		$template->from = $request->from;
		$template->to = $request->to;
		$template->copy = $request->copy;
		$template->hidden_copy = $request->hidden_copy;
		$template->reply_to = $request->reply_to;
		$template->in_reply_to = $request->in_reply_to;
		$template->body = $request->body;

		$template->save();

		return redirect(action('Modules\Bitrix\BitrixMailEventsController@show', [$module->id, $mail_event->id]));
	}

	public function destroy_template(Bitrix $module, BitrixMailEvents $mail_event, BitrixMailEventsTemplate $template, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$template->delete();

		return back();
	}

	public function destroy_var(Bitrix $module, BitrixMailEvents $mail_event, BitrixMailEventsVar $var, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$var->delete();

		return back();
	}

	public function add_var(Bitrix $module, BitrixMailEvents $mail_event, Request $request){
		if (!$this->userCreatedModule($module->id)){
			return $this->unauthorized($request);
		}

		$mail_event_var = BitrixMailEventsVar::updateOrCreate(
			[
				'mail_event_id' => $mail_event->id,
				'code'          => $request->MAIL_EVENT_VARS_CODE
			],
			[
				'mail_event_id' => $mail_event->id,
				'name'          => $request->MAIL_EVENT_VARS_NAME,
				'code'          => $request->MAIL_EVENT_VARS_CODE
			]
		);

		return back();
	}
}