<?php

namespace App\Models\Metrics;

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
}