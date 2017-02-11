<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserReportType extends Model{
	protected $table = 'user_report_types';
	protected $fillable = ['code', 'name', 'description'];
}