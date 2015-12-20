<?php

namespace App\Http\Controllers\Modules;

use Validator;
use App\Http\Controllers\Controller;

class BitrixController extends Controller{
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
}
