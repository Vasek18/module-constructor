<?php

namespace App\Http\Controllers\Modules\Management;

use App\Http\Controllers\Controller;
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
            'issues' => $module->clientsIssues()->orderBy('appeals_count', 'desc')->get(),
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
        $module->clientsIssues()->create([
            'name'          => trim($request->name),
            'description'   => trim($request->description),
            'appeals_count' => 1,
            // проблема поднималась как минимум раз
        ]);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Modules\Management\ModulesClientsIssue $modulesClientsIssue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModulesClientsIssue $modulesClientsIssue){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modules\Management\ModulesClientsIssue $modulesClientsIssue
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModulesClientsIssue $modulesClientsIssue){
        //
    }

    // смена счётчика
    public function changeCounter(Bitrix $module, ModulesClientsIssue $issue, Request $request){
        $newCount = intval($issue->appeals_count);

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

        return back();
    }
}
