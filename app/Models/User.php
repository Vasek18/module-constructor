<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Modules\Bitrix\Bitrix;

class User extends Model implements AuthenticatableContract,
	AuthorizableContract,
	CanResetPasswordContract{
	use Authenticatable, Authorizable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['first_name', 'last_name', 'company_name', 'site', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function canDownloadModule(){
		if ($this->payed_days){
			return true;
		}

		return false;
	}

	public function isBitrixModuleOwner(Bitrix $module){
		if ($this->id === $module->user_id){
			return true;
		}

		return false;
	}

	public function canSeePayedFiles(){
		return true;
	}

	public function bitrixes(){
		return $this->hasMany('App\Models\Modules\Bitrix\Bitrix');
	}
}
