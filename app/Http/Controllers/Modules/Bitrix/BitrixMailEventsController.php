<?php

namespace App\Http\Controllers\Modules\Bitrix;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Bitrix\BitrixMailEvents;
use App\Http\Controllers\Traits\UserOwnModule;

class BitrixMailEventsController extends Controller{

	use UserOwnModule;

	public function index(Bitrix $module, Request $request){
		$mail_events = $module->mailEvents()->get();

		$data = [
			'module' => $module,
			'mail_events'  => $mail_events

		];

		return view("bitrix.mail_events.index", $data);
	}

	public function create(){
		//
	}

	public function store(Bitrix $module, Request $request){
	}

	public function show($id){
		//
	}

	public function edit($id){
		//
	}

	public function update(Bitrix $module, Request $request){

	}

	public function destroy(Bitrix $module, Request $request){

	}
}
