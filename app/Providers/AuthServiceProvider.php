<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any application authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot(){
		$this->registerPolicies();

		Passport::routes();
		Passport::tokensExpireIn(Carbon::now()->addYears(20));//You can also use addDays(10)
		Passport::refreshTokensExpireIn(Carbon::now()->addYears(20));//You can also use addDays(10)
		Passport::pruneRevokedTokens(); //basic garbage collector
	}
}
