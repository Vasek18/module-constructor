<?php

namespace App\Models\Modules;

use Illuminate\Database\Eloquent\Model;

class Sorting extends Model{

    protected $table = 'modules_sorting';
    protected $fillable = [
        'module_id',
        'user_id',
        'sort'
    ];
    public $timestamps = false;

    public function module(){
        return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
    }
}