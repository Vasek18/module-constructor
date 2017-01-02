<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunctionalSuggestion extends Model{
	protected $table = 'functional_suggestions';
	protected $fillable = ['name', 'description', 'creator_id', 'likes', 'user_ids'];
}