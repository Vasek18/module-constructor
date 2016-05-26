<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Modules\Bitrix\Bitrix;
use App\vArrParse;

class HomeController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
//		$vArrParse = new vArrParse;
//		dd($vArrParse->parseFromText('$arTypesEx = Array();
//$db_iblock_type = CIBlockType::GetList(Array("SORT"=>"ASC"));
//while($arRes = $db_iblock_type->Fetch())
//{
//	if($arIBType = CIBlockType::GetByIDLang($arRes["ID"], LANG))
//	{
//		$arTypesEx[$arRes["ID"]] = $arIBType["NAME"];
//	}
//}', '$arTypesEx'));
		$countModules = Bitrix::count();
		$modulesEnding = 'ей';
		if (substr($countModules, -1, 1) == '1'){
			$modulesEnding = 'ь';
		}
		if (in_array(substr($countModules, -1, 1), ['2', '3', '4'])){
			$modulesEnding = 'я';
		}
		$data = [
			'countModules' => $countModules,
			'modulesEnding' => $modulesEnding,
		];

		return view("index", $data);
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
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		//
	}
}
