<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVisit extends Model{
	protected $table = 'user_visits';
	protected $fillable = ['user_id', 'login_at', 'logout_at', 'ip'];
	public $timestamps = false;

	public function scopeLast($query){
		return $query->orderBy('login_at', 'desc');
	}

	public function user(){
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}