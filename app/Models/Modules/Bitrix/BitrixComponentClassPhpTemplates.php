<?php

namespace App\Models\Modules\Bitrix;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BitrixComponentClassPhpTemplates extends Model{
	protected $table = 'bitrix_components_class_php_templates';
	protected $fillable = ['creator_id', 'name', 'template', 'show_everyone', 'need_edit'];

	public function scopeThatUserCanSee($query, User $user){
		return $query->where('creator_id', $user->id);
	}

	public function userCanUse(User $user){
		if ($this->creator_id == $user->id){
			return true;
		}

		return false;
	}
}