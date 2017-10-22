<?php

namespace App\Models\Modules\Management;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ModulesCompetitorsUpdate extends Model{

    protected $table = 'modules_competitors_updates';

    protected $fillable = [
        'module_id',
        'version',
        'date',
        'description',
    ];

    public $timestamps = false;

    public static function getForCompetitors($competitors){
        $updates = [];

        foreach ($competitors as $competitor){
            // берём по 10 обновлений каждого конкурента
            $competitorUpdates = $competitor->updates()->take(10)->get();

            // в таком виде, чтобы сортировать по ключам
            foreach ($competitorUpdates as $competitorUpdate){
                $updates[$competitorUpdate->date] = $competitorUpdate;
            }
        }

        // сортировка по дате
        uksort($updates, function($a, $b){
            return Carbon::parse($a)->timestamp <= Carbon::parse($b)->timestamp;
        });

        return $updates;
    }

    public function getModuleNameAttribute(){
        return $this->competitor()->first()->name;
    }

    // связи с другими модулями
    public function competitor(){
        return $this->belongsTo('App\Models\Modules\Management\ModulesCompetitor', 'module_id', 'id');
    }
}
