<?php

namespace App\Models\Modules\Management;

use App\Helpers\PhpCodeGeneration;
use App\Helpers\vFuncParse;
use Illuminate\Database\Eloquent\Model;

class ModulesClientsIssue extends Model{

    protected $table = 'modules_clients_issues';

    protected $fillable = [
        'module_id',
        'name',
        'description',
        'solution_description',
        'is_solved',
        'appeals_count',
    ];

    // связи с другими модулями
    public function module(){
        return $this->belongsTo('App\Models\Modules\Bitrix\Bitrix');
    }
}
