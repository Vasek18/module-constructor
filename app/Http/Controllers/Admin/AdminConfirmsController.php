<?php

namespace App\Http\Controllers\Admin;

use App\Models\Modules\Bitrix\BitrixCoreEvents;
use App\Models\Modules\Bitrix\BitrixCoreModules;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminConfirmsController extends Controller{
	public function index(Request $request){
		$data = [
			'unapproved_modules' => BitrixCoreModules::unapproved()->get(),
			'unapproved_events'  => BitrixCoreEvents::unapproved()->get(),
			'marked_events'      => BitrixCoreEvents::marked()->get(),
		];

		return view("admin.confirms.index", $data);
	}

	public function approveModule(BitrixCoreModules $module, Request $request){
		$module->approve();

		return back();
	}

	public function deleteModule(BitrixCoreModules $module, Request $request){
		$module->delete();

		return back();
	}
	public function approveEvent(BitrixCoreEvents $event, Request $request){
		$event->approve();

		return back();
	}

	public function deleteEvent(BitrixCoreEvents $event, Request $request){
		$event->delete();

		return back();
	}
}
