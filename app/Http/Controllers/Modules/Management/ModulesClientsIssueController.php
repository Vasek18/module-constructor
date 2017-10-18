<?php

namespace App\Http\Controllers\Modules\Management;

use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Management\ModulesClientsIssue;
use Illuminate\Http\Request;

class ModulesClientsIssueController extends Controller{

    /**
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Bitrix $module, Request $request){
        $data = [
            'module' => $module
        ];

        return view("modules_management.clients_issues.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModulesClientsIssue $modulesClientsIssue
     * @return \Illuminate\Http\Response
     */
    public function show(ModulesClientsIssue $modulesClientsIssue){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModulesClientsIssue $modulesClientsIssue
     * @return \Illuminate\Http\Response
     */
    public function edit(ModulesClientsIssue $modulesClientsIssue){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ModulesClientsIssue $modulesClientsIssue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModulesClientsIssue $modulesClientsIssue){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ModulesClientsIssue $modulesClientsIssue
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModulesClientsIssue $modulesClientsIssue){
        //
    }
}
