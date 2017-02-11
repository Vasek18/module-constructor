<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProjectPulsePost extends Model{
	protected $table = 'project_pulse_posts';
	protected $fillable = ['name', 'description', 'highlight'];

	public function getCreatedAtAttribute($value){
		return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.Y');
	}
}