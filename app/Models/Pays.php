<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model{
	protected $table = 'pays';
	protected $fillable = ['user_id', 'amount'];
}