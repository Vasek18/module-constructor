<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model{
	protected $table = 'user_reports';
	protected $fillable = ['user_id', 'user_email', 'name', 'description', 'priority_points', 'is_duplicate', 'status_id', 'type_id', 'page_id', 'page_link'];

	public function getBootstrapContextClass(){
		$class = 'default';

		if ($this->type){
			if ($this->type->code == 'error'){
				$class = 'danger';
			}
			if ($this->type->code == 'lack'){
				$class = 'warning';
			}
			if ($this->type->code == 'suggestion'){
				$class = 'primary';
			}
		}

		return $class;
	}

	public function user(){
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function type(){
		return $this->belongsTo('App\Models\User\UserReportType', 'type_id');
	}
}