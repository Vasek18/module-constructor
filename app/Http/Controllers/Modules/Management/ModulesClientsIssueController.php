<?php

namespace App\Http\Controllers\Modules\Management;

use App\Http\Controllers\Controller;
use App\Models\Metrics\MetricsEventsLog;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Management\ModulesClientsIssue;
use Illuminate\Http\Request;

class ModulesClientsIssueController extends Controller{

    /**
     *
     * @param Bitrix $module
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Bitrix $module, Request $request){
        $data = [
            'issues' => $module->clientsIssues()->orderBy('is_solved', 'asc')->orderBy('appeals_count', 'desc')->get(),
            'module' => $module,
        ];

        return view("modules_management.clients_issues.index", $data);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function create(){
        //
    }

    /**
     *
     * @param Bitrix $module
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Bitrix $module, Request $request){
        $name        = trim($request->name);
        $description = trim($request->description);

        if (!$name){
            return back();
        }

        $issueArr = [
            'name'          => $name,
            'description'   => $description,
            'appeals_count' => 1,
            // проблема поднималась как минимум раз
        ];
        $module->clientsIssues()->create($issueArr);

        // логируем действие
        MetricsEventsLog::log('Добавлена проблема модуля', $issueArr);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modules\Management\ModulesClientsIssue $modulesClientsIssue
     * @return \Illuminate\Http\Response
     */
    public function show(ModulesClientsIssue $modulesClientsIssue){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modules\Management\ModulesClientsIssue $modulesClientsIssue
     * @return \Illuminate\Http\Response
     */
    public function edit(ModulesClientsIssue $modulesClientsIssue){
        //
    }

    /**
     *
     * @param Bitrix $module
     * @param ModulesClientsIssue $issue
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function update(Bitrix $module, ModulesClientsIssue $issue, Request $request){
        if (!$this->moduleHasIssue($module, $issue)){
            return abort(404);
        }

        $description = trim($request->description);

        $issueArr = [
            'description' => $description,
        ];
        $issue->update($issueArr);

        // логируем действие
        MetricsEventsLog::log('Изменёна проблема модуля', $issueArr);

        return back();
    }

    /**
     *
     * @param Bitrix $module
     * @param ModulesClientsIssue $issue
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function destroy(Bitrix $module, ModulesClientsIssue $issue, Request $request){
        if (!$this->moduleHasIssue($module, $issue)){
            return abort(404);
        }

        // логируем действие
        MetricsEventsLog::log('Удалёна проблема модуля', $issue);

        $issue->delete();

        return back();
    }

    /**
     *
     * Cмена счётчика
     *
     * @param Bitrix $module
     * @param ModulesClientsIssue $issue
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function changeCounter(Bitrix $module, ModulesClientsIssue $issue, Request $request){
        if (!$this->moduleHasIssue($module, $issue)){
            return abort(404);
        }

        $oldCount = intval($issue->appeals_count);
        $newCount = $oldCount;

        if ($request->action == 'decrease'){
            $newCount--;
        }
        if ($request->action == 'increase'){
            $newCount++;
        }

        if ($newCount < 1){
            $newCount = 1;
        }

        $issue->update(['appeals_count' => $newCount]);

        // логируем действие
        MetricsEventsLog::log('Изменён счётчик проблемы модуля', [
            'oldCount' => $oldCount,
            'newCount' => $newCount,
            'issue'    => $issue,
        ]);

        return back();
    }

    /**
     *
     * Помечаем, что задача решена
     *
     * @param Bitrix $module
     * @param ModulesClientsIssue $issue
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function solved(Bitrix $module, ModulesClientsIssue $issue, Request $request){
        if (!$this->moduleHasIssue($module, $issue)){
            return abort(404);
        }

        $issue->update(['is_solved' => true]);

        // логируем действие
        MetricsEventsLog::log('Проблема модуля помечена решенной', $issue);

        return back();
    }

    /**
     * Помечаем, что задача всё-таки не решена
     *
     * @param Bitrix $module
     * @param ModulesClientsIssue $issue
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function notSolved(Bitrix $module, ModulesClientsIssue $issue, Request $request){
        if (!$this->moduleHasIssue($module, $issue)){
            return abort(404);
        }

        $issue->update(['is_solved' => false]);

        // логируем действие
        MetricsEventsLog::log('Проблема модуля помечена нерешенной', $issue);

        return back();
    }

    public function moduleHasIssue(Bitrix $module, ModulesClientsIssue $issue){
        return $module->id == $issue->module_id;
    }
}
