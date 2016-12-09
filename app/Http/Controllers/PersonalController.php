<?php

namespace App\Http\Controllers;
use App\Models\User;
use Auth;

class PersonalController extends Controller{

	public function __construct(){
		parent::__construct();
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$user = User::find(Auth::id());

		$data = [
			'bitrix_modules' => $user->bitrixes()->orderBy('created_at', 'desc')->get(),
			'user' => $user
		];

		return view("personal.index", $data);
	}

	public function oplata(){
		return view("personal.oplata");
	}
}
