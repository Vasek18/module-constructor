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
use Illuminate\Notifications\Notifiable;
use App\Notifications\MyOwnResetPassword as ResetPasswordNotification;
use Laravel\Passport\HasApiTokens;


class User extends Model implements AuthenticatableContract,
	AuthorizableContract,
	CanResetPasswordContract{

	use Authenticatable, Authorizable, CanResetPassword, Notifiable, HasApiTokens;
	protected $table = 'users';
	protected $fillable = ['first_name', 'last_name', 'company_name', 'site', 'email', 'password', 'bitrix_company_name', 'bitrix_partner_code'];
	protected $hidden = ['password', 'remember_token'];
	public static $adminGroup = 1;
	public static $defaultGroup = 2;

	public function sendPasswordResetNotification($token){
		$this->notify(new ResetPasswordNotification($token));
	}

	public function isAdmin(){
		if ($this->group_id == static::$adminGroup){
			return true;
		}

		return false;
	}

	public function canDownloadModule(){
		if (!setting('day_price')){ // если бесплатно
			return true; // то все платные
		}
		if ($this->paid_days){
			return true;
		}

		return false;
	}

	public function canSeePaidFiles(){
		if (!setting('day_price')){ // если бесплатно
			return true; // то все платные
		}
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
		$this->rubles = intval($this->rubles) + intval($rubles);
		$this->save();
	}

	public function convertRublesToDays(){
		$day_price = intval(setting('day_price'));
		if (!$day_price){
			return 0;
		}
		$rubles = intval($this->rubles);
		$days = intval($rubles / $day_price);

		$this->paid_days = intval($this->paid_days) + $days;
		$this->rubles = intval($this->rubles - $days * $day_price); // не забываем снять деньги
		$this->save();

		return $days;
	}

	public function getLastLogin(){
		return $this->visits()->last()->first();
	}
	
	public function getNameAttribute(){
		return $this->last_name.' '.$this->first_name;
	}

	public function bitrixes(){
		return $this->hasMany('App\Models\Modules\Bitrix\Bitrix');
	}

	public function visits(){
		return $this->hasMany('App\Models\UserVisit');
	}

	public function modules(){
		return $this->hasMany('App\Models\Modules\Bitrix\Bitrix'); // пока только битрикс
	}

	public function group(){
		return $this->belongsTo('App\Models\UserGroups');
	}
}