<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class CheckIfAdmin{

	public function __construct(Guard $auth){
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){

		if ($this->auth->guest()){
			if ($request->ajax()){
				return response('Unauthorized.', 401);
			}else{
				return redirect()->guest(route('auth'));
			}
		}

		$user = $request->user();
		$group = $user->group()->first();
		if (!$group || $group->code != 'admin'){ // если не админ
			return redirect('personal');
		}

		return $next($request);
	}
}
