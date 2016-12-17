<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleSection;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Pays;
use App\Models\User;

class AdminController extends Controller{
	public function index(){
		$data = [
			'usersCount'   => User::count(),
			'modulesCount' => Bitrix::count(),
			'earnedRubles' => Pays::sum('amount'),
		];

		return view("admin.index", $data);
	}

	public function modules(){
		$data = [
			'bitrixes' => Bitrix::orderBy('user_id')->get(),
		];

		return view("admin.modules", $data);
	}

	public function modulesDetail(Bitrix $module){
		$data = [
			'module' => $module,
		];

		return view("admin.module_detail", $data);
	}

	public function articles(){
		$data = [
			'sections' => ArticleSection::orderBy('sort')->get(),
		];

		return view("admin.articles.index", $data);
	}
}
