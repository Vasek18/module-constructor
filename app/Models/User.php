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
		if ($this->paid_days){
			return true;
		}

		return false;
	}

	public function canSeePaidFiles(){
		if ($this->paid_days){
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
		$days = $this->paid_days;
		if ($days){
			$days--;
		}
		$this->paid_days = $days;
		$this->save();
	}

	public function addRubles($rubles){
		$this->rubles = $rubles;
		$this->save();
	}

	public function convertRublesToDays(){
		$days = intval(intval($this->rubles) / intval(setting('day_price')));
		$this->paid_days = $days;
		$this->save();

		return $days;
	}

	public function getNameAttribute(){
		return $this->last_name.' '.$this->first_name;
	}

	public function bitrixes(){
		return $this->hasMany('App\Models\Modules\Bitrix\Bitrix');
	}

	public function modules(){
		return $this->hasMany('App\Models\Modules\Bitrix\Bitrix'); // пока только битрикс
	}

	public function group(){
		return $this->belongsTo('App\Models\UserGroups');
	}
}