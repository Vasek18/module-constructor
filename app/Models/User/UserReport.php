<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model{
	protected $table = 'user_reports';
	protected $fillable = ['user_id', 'user_email', 'name', 'description', 'priority_points', 'is_duplicate', 'status_id', 'type_id', 'page_id', 'page_link'];

	public function user(){
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}