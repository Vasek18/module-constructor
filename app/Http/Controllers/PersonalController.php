<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
			'user'           => $user
		];

		return view("personal.index", $data);
	}

	public function oplata(){
		if (!setting('day_price')){
			abort(404);
		}

		return view("personal.oplata");
	}

	public function help_project(){
		return view("personal.help_project");
	}

	public function donate(){
		return view("personal.donate");
	}

	public function info(){
		return view("personal.info");
	}

	public function infoEdit(Request $request){
		if (!$this->user){
			return back();
		}

		$updateArr = [];

		if ($request->name){
			$updateArr['first_name'] = $request->name;
		}
		if ($request->surname){
			$updateArr['last_name'] = $request->surname;
		}
		if ($request->company_name){
			$updateArr['bitrix_company_name'] = $request->company_name;
		}
		if ($request->partner_code){
			$updateArr['bitrix_partner_code'] = $request->partner_code;
		}

		if (!empty($updateArr)){
			$this->user->update($updateArr);
		}

		return back();
	}

	public function getToken(){
		$this->user->tokens()->delete(); // удаляем старые токены
		$this->user->createToken($this->user->id.' Access Token')->accessToken; // создаём новый токен
		return back();
	}
}