<?php

namespace App\Console\Commands;

use App\Models\Metrics\MetricsEventsLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearEventsLog extends Command{

    protected $signature = 'clear_events_log';

    protected $description = 'Удаляем устаревшие события из лога, для экономии памяти';

    public function handle(){
        MetricsEventsLog::where('created_at', '<=', Carbon::now()->subMonth())->delete();
    }
}