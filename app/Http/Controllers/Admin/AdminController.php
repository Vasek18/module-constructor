<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleSection;
use App\Models\Modules\Bitrix\Bitrix;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller{
	public function index(){
		return view("admin.index");
	}

	public function users(){
		$data = [
			'usersCount' => User::count(),
			'users'      => User::all(),
		];

		return view("admin.users", $data);
	}

	public function usersDetail(User $user){
		$data = [
			'user'     => $user,
			'bitrixes' => $user->bitrixes,
		];

		return view("admin.user_detail", $data);
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

	public function settings(){
		$data = [
			'settings' => Setting::all()
		];

		return view("admin.settings", $data);
	}

	public function articles(){
		$data = [
			'sections' => ArticleSection::orderBy('sort')->get(),
		];

		return view("admin.articles.index", $data);
	}
}
