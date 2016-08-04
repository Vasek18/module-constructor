<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Modules\Bitrix\Bitrix;

class CheckIfAdmin{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		$user = $request->user();
		$group = $user->group()->first();
		if (!$group || $group->code != 'admin'){ // если не админ
			return redirect('personal');
		}

		return $next($request);
	}
}
