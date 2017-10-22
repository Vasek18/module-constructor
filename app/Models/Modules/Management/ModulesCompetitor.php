<?php

namespace App\Models\Modules\Management;

use App\Helpers\PhpCodeGeneration;
use App\Helpers\vFuncParse;
use Illuminate\Database\Eloquent\Model;

class ModulesCompetitor extends Model{

    protected $table = 'modules_competitors';

    protected $fillable = [
        'module_id',
        'name',
        'link',
        'price',
        'sort',
        'picture_src',
        'comment',
    ];

    public $timestamps = false;

    // связи с другими модулями
    public function module(){
        return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
    }
}
