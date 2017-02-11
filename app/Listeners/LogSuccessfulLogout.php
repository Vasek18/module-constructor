<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\UserVisit;

class LogSuccessfulLogout{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct(){
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  Logout $event
	 * @return void
	 */
	public function handle(Logout $event){
		if ($event->user){
			if ($event->user->id){
				// берём визит этого пользователя с самым поздним логином
				$lastLogin = UserVisit::where('user_id', $event->user->id)->orderBy('login_at', 'desc')->first();
				if ($lastLogin){
					// если он не закрыт
					if (!$lastLogin->logout_at){
						$lastLogin->update([
							'logout_at' => Carbon::now()
						]);
					}
				}
			}
		}
	}
}
