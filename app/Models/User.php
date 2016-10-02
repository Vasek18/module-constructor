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
	protected $table = 'users';
	protected $fillable = ['first_name', 'last_name', 'company_name', 'site', 'email', 'password'];
	protected $hidden = ['password', 'remember_token'];
	public static $defaultGroup = 2;

	public function canDownloadModule(){
		if ($this->payed_days){
			return true;
		}

		return false;
	}

	public function canSeePayedFiles(){
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

	public function payForDay(){
		$days = $this->payed_days;
		if ($days){
			$days--;
		}
		$this->payed_days = $days;
		$this->save();
	}

	public function bitrixes(){
		return $this->hasMany('App\Models\Modules\Bitrix\Bitrix');
	}

	public function group(){
		return $this->belongsTo('App\Models\UserGroups');
	}
}