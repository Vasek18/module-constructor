<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleSection;
use App\Models\Metrics\MetricsEventsLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminMetricsEventsLogController extends Controller{

    public function index(){
        $data = [
            'events' => MetricsEventsLog::getForStatisticPage()
        ];

        return view("admin.metrics.events.index", $data);
    }

}
