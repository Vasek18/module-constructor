<?php

namespace App\Models\Modules\Bitrix;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BitrixComponentClassPhpTemplates extends Model{
	protected $table = 'bitrix_components_class_php_templates';
	protected $fillable = ['creator_id', 'name', 'template', 'show_everyone', 'need_edit'];

	public function scopeThatUserCanSee($query, User $user){
		if ($user->id){
			return $query->where('creator_id', $user->id);
		}else{
			return $query;
		}
	}

	public function scopePublicTemplates($query){
		return $query->where('show_everyone', true);
	}

	public function scopePrivateTemplates($query){
		return $query->where('show_everyone', false);
	}

	public function userCanUse(User $user){
		// todo нельзя удалять утверждённые шаблоны
		if ($user->id){
			if ($this->creator_id === $user->id){
				return true;
			}
		}

		return false;
	}

	public function isPublic(){
		if ($this->show_everyone){
			return true;
		}

		return false;
	}
}