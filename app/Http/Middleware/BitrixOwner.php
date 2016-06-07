<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Modules\Bitrix\Bitrix;

class BitrixOwner{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next){
		$user = $request->user();
		if ($user){ // если нет юзера, то мы не делаем проверки здесь, пусть этим другие middleware занимаются
			if ($request->segment(1) == 'my-bitrix'){ // на всякий случай проверка, что страницы Битрикса
				$module_id = $request->segment(2);
				if (is_numeric($module_id)){ // если мы на странице какого-то конкретного модуля
					$module = Bitrix::find($module_id);
					if ($module && !$user->isBitrixModuleOwner($module)){ // если юзер владеет модулем
						if ($request->ajax()){
							return response(['message' => 'Nea'], 403);
						}

						return redirect('personal'); // todo что-то более осмысленное | или нет, чтобы нельзя было понять существует ли модуль с таким айдишником?
					}
				}
			}
		}

		return $next($request);
	}
}
