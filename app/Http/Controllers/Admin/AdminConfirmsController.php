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

	// todo написать тест
	public function clearModulesFormDuplicates(Request $request){
		$modules = BitrixCoreModules::get();
		foreach ($modules as $module){
			if (!BitrixCoreModules::where('id', $module->id)->count()){
				continue;
			}
			$duplicates = BitrixCoreModules::where('code', $module->code)->where('id', '!=', $module->id)->get();
			foreach ($duplicates as $duplicate){
				// сначала удаляем события
				$duplicate->events()->delete();

				// а затем и сам модуль
				$duplicate->delete();
			}
		}

		return back();
	}

	// todo
	public function clearEventsFormDuplicates(Request $request){

		return back();
	}
}
