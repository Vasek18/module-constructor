<?php

namespace App\Models\Metrics;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MetricsEventsLog extends Model{

    protected $table = 'metrics_events_log';

    protected $fillable = [
        'user_id',
        'event',
        'params'
    ];

    public static function log($event, $params = []){
        MetricsEventsLog::create([
            'event'   => $event,
            'user_id' => Auth::id(),
            'params'  => json_encode($params),
        ]);
    }

    public static function getPeriodsForCount(){
        return [
            [
                'code' => 'day',
                'name' => 'Сутки',
                'from' => Carbon::now()->subDay(),
                'to'   => Carbon::now(),
            ],
            [
                'code' => 'week',
                'name' => 'Неделя',
                'from' => Carbon::now()->subWeek(),
                'to'   => Carbon::now(),
            ],
            [
                'code' => 'alltime',
                'name' => 'Всё время',
                'from' => false,
                'to'   => Carbon::now(),
            ],
        ];
    }

    public static function getForStatisticPage(){
        $events = MetricsEventsLog::orderBy('created_at', 'desc')->get();

        $eventGroups = [];

        $periods = static::getPeriodsForCount();

        foreach ($events as $c => $event){
            if (!isset($eventGroups[$event->event])){
                $eventArr = [
                    'code'   => $c,
                    'events' => [$event]
                ];

                foreach ($periods as $period){
                    $eventArr['counters'][$period['code']] = [
                        'name'  => $period['name'],
                        'value' => 0,
                    ];
                }

                $eventGroups[$event->event] = $eventArr;
            } else{
                $eventGroups[$event->event]['events'][] = $event;
            }
        }

        // подсчитаем суммы
        foreach ($eventGroups as $c => &$eventGroup){
            foreach ($eventGroup['events'] as $event){
                foreach ($periods as $period){
                    if ($period['from'] <= $event['created_at']){
                        if ($period['to'] >= $event['created_at']){
                            $eventGroup['counters'][$period['code']]['value']++;
                        }
                    }
                }
            }
        }

        return $eventGroups;
    }

    public function getUserNameAttribute(){
        if ($this->user){
            return $this->user->name;
        }

        return null;
    }

    public function getParamsAttribute($value){
        return (array) json_decode($value);
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}