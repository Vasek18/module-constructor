<?php

namespace App\Http\Controllers\Modules\Management;

use App\Http\Controllers\Controller;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Modules\Management\ModulesCompetitor;
use Illuminate\Http\Request;

class ModulesCompetitorsController extends Controller{

    /**
     *
     * @param Bitrix $module
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Bitrix $module, Request $request){
        $data = [
            'competitors' => $module->competitors()->orderBy('sort', 'asc')->get(),
            'module'      => $module,
        ];

        return view("modules_management.competitors.index", $data);
    }

    /**
     *
     * @param Bitrix $module
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function create(Bitrix $module, Request $request){
        $data = [
            'module' => $module,
        ];

        return view("modules_management.competitors.create", $data);
    }

    /**
     *
     * @param Bitrix $module
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function store(Bitrix $module, Request $request){
        $name    = trim($request->name);
        $comment = trim($request->comment);

        if (!$name){
            return back();
        }

        $module->competitors()->create([
            'name'    => $name,
            'comment' => $comment,
            'link'    => $request->link,
            'price'   => $request->price,
            'sort'    => $request->sort,
        ]);

        return redirect(action('Modules\Management\ModulesCompetitorsController@index', $module->id));
    }

    /**
     *
     * @param Bitrix $module
     * @param ModulesCompetitor $competitor
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Bitrix $module, ModulesCompetitor $competitor, Request $request){
        $data = [
            'module'     => $module,
            'competitor' => $competitor,
        ];

        return view("modules_management.competitors.edit", $data);
    }

    /**
     *
     * @param Bitrix $module
     * @param ModulesCompetitor $competitor
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function update(Bitrix $module, ModulesCompetitor $competitor, Request $request){
        $name    = trim($request->name);
        $comment = trim($request->comment);

        if (!$name){
            return back();
        }

        $competitor->update([
            'name'    => $name,
            'comment' => $comment,
            'link'    => $request->link,
            'price'   => $request->price,
            'sort'    => $request->sort,
        ]);

        return back();
    }

    /**
     *
     * @param Bitrix $module
     * @param ModulesCompetitor $competitor
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function delete(Bitrix $module, ModulesCompetitor $competitor, Request $request){
        $competitor->delete();

        return redirect(action('Modules\Management\ModulesCompetitorsController@index', $module->id));
    }
}