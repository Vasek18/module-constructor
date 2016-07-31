<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;

class SetAppLanguage{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		if (!Session::has('lang')){
			$segments = preg_split('/[\.\/]/is', $request->root());
			$lang = $segments[2];
			if ($lang == 'en'){
				app()->setLocale('en');
			}else{
				app()->setLocale('ru');
			}
		}else{
			app()->setLocale(Session::get('lang'));
		}

		// app()->setLocale(Session::has('lang') ? Session::get('lang') : Config::get('app.locale'));

		return $next($request);
	}
}
