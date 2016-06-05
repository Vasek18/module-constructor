<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class SetAppLanguage{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		app()->setLocale(Session::has('lang') ? Session::get('lang') : Config::get('app.locale'));

		return $next($request);
	}
}
