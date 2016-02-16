<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix;
use Auth;

class PersonalController extends Controller{

	public function __construct(){
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$user_id = Auth::id();
		// получаем все модули юзера
		$data = [
			'bitrix_modules' => Bitrix::where("user_id", $user_id)->orderBy('created_at', 'desc')->get()
		];

		return view("personal.index", $data);
	}
}
