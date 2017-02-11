<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\UserVisit;

class LogSuccessfulLogin{
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
	 * @param  Login $event
	 * @return void
	 */
	public function handle(Login $event){
		if ($event->user){
			if ($event->user->id){
				UserVisit::create([
					'user_id'  => $event->user->id,
					'login_at' => Carbon::now(),
					'ip'       => \Request::ip(),
				]);
			}
		}
	}
}
