<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class AuthController extends Controller{
	protected $redirectTo = '/personal/'; // перенаправление в случае удачной регистрации
	protected $loginPath = '/personal/auth/'; // перенаправление в случае неудачной регистрации
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		parent::__construct();

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		return view("auth.auth");
	}

	public function index_reg(){
		return view("auth.register");
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data){
		return Validator::make($data, [
			'first_name' => 'required|max:255',
			'email'      => 'required|email|max:255|unique:users',
			'password'   => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return User
	 */
	protected function create(array $data){
		$daysTrial = setting('demo_days');

		$user = User::create([
			'first_name'   => $data['first_name'],
			'last_name'    => $data['last_name'],
			'site'         => $data['site'],
			'company_name' => $data['company_name'],
			'email'        => $data['email'],
			'password'     => bcrypt($data['password']),
			'group_id'     => User::$defaultGroup,
		]);

		$user->payed_days = $daysTrial;
		$user->save();

		flash()->success(trans('reg.you_ve_registered').'\n'.trans_choice('reg.trial_provided', $daysTrial, ['days' => $daysTrial]));

		return $user;
	}
}
