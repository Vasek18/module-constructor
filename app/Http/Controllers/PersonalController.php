<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
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
		$user = User::find(Auth::id());

		$data = [
			'bitrix_modules' => $user->bitrixes()->orderBy('created_at', 'desc')->get(),
			'user' => $user
		];

		return view("personal.index", $data);
	}
}
