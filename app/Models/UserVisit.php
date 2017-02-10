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

class UserVisit extends Model{
	use Authenticatable, Authorizable, CanResetPassword;
	protected $table = 'user_visits';
	protected $fillable = ['user_id', 'login_at', 'logout_at', 'ip'];
	public $timestamps = false;

	public function user(){
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}