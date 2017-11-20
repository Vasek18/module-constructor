<?php

namespace App\Http\Controllers;

use App\Models\Metrics\MetricsEventsLog;
use App\Models\ProjectPulsePost;
use App\Models\Modules\Bitrix\Bitrix;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller{

    public function index(){
        if (Auth::check()){
            return redirect(action('PersonalController@index'));
        }

        $countModules  = Bitrix::count();
        $modulesEnding = 'ей';
        if (substr($countModules, -1, 1) == '1'){
            $modulesEnding = 'ь';
        }
        if (in_array(substr($countModules, -1, 1), [
            '2',
            '3',
            '4'
        ])){
            $modulesEnding = 'я';
        }
        $data = [
            'countModules'        => $countModules,
            'modulesEnding'       => $modulesEnding,
            'project_pulse_posts' => ProjectPulsePost::orderBy('created_at', 'desc')->orderBy('id', 'desc')->take(5)->get()
        ];

        // логируем действие
        MetricsEventsLog::log(
            'Открыта главная страница'
        );

        return view("index", $data);
    }
}
