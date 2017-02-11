<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/
	use RegistersUsers;
	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/personal/'; // перенаправление в случае удачной регистрации

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->middleware('guest');
	}

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showRegistrationForm(){
		if (setting('disallow_auth')){
			abort(404);
		}

		return view('auth.register');
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
			'password'   => 'required|min:6|confirmed',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 * @return User
	 */
	protected function create(array $data){
		if (setting('disallow_auth')){
			abort(404);
		}

		$daysTrial = setting('demo_days');

		$user = User::create([
			'first_name'   => $data['first_name'],
			'last_name'    => $data['last_name'],
			'site'         => isset($data['site']) ? $data['site'] : '',
			'company_name' => isset($data['company_name']) ? $data['company_name'] : '',
			'email'        => $data['email'],
			'password'     => bcrypt($data['password']),
			'group_id'     => User::$defaultGroup,
		]);

		$user->paid_days = $daysTrial;
		$user->save();

		// письмо мне
		Mail::send('emails.admin.new_user', ['user' => $user], function ($m){
			$m->to(env('GOD_EMAIL'))->subject('Зарегался новый пользователь');
		});

		flash()->success(trans('reg.you_ve_registered').'\n'.(setting('day_price') ? trans_choice('reg.trial_provided', $daysTrial, ['days' => $daysTrial]) : ''));

		return $user;
	}
}