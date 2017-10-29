<?php

namespace App\Models\Metrics;

use Illuminate\Database\Eloquent\Model;

class MetricsEventsLog extends Model{
	protected $table = 'metrics_events_log';
	protected $fillable = ['user_id', 'name', 'params'];


}