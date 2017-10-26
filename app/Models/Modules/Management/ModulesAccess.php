<?php

namespace App\Models\Modules\Management;

use Illuminate\Database\Eloquent\Model;

class ModulesAccess extends Model{

    protected $table = 'modules_accesses';

    protected $fillable = [
        'user_email',
        'module_id',
        'permission_code',
    ];

    public static $permissions = [
        [
            'code' => 'D',
            'name' => 'Разработка'
        ],
        [
            'code' => 'M',
            'name' => 'Менеджмент'
        ],
    ];

    public static function formatForPage($accesses){
        $array = [];
        foreach ($accesses as $access){
            $array[$access->user_email][] = $access->permission_code;
        }

        return $array;
    }

    // связи с другими модулями
    public function module(){
        return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
    }
}
