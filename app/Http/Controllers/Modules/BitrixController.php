<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BitrixController extends Controller{
	protected $rootFolder = '/construct/bitrix/'; // корневая папка модуля

	/*
	|--------------------------------------------------------------------------
	| Контролер для создания модулей на Битриксе
	|--------------------------------------------------------------------------
	|
	|
	*/

	/**
	 * Конструктор
	 *
	 * @return void
	 */
	public function __construct(){

	}

	/**
	 * Главная страница
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		return view("bitrix.new");
	}

	/**
	 * Создание модуля
	 *
	 * @return
	 */
	public function create(Request $request){
		dd($request->all());
		// todo вынести в модуль
		//DB::table('bitrixes')->insert(
		//	array('email' => 'john@example.com', 'votes' => 0)
		//);

		return redirect($this->rootFolder);
	}
}
