<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GatherPayment extends Command{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'gather_payment';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Gather daily payment from paid users';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(){
		if (setting('day_price')){
			foreach (User::all() as $user){
				$user->payForDay();
			}
		}
	}
}