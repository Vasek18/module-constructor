<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller{
	public function index(){
		return view("admin.index");
	}

	public function users(){
		$data = [
			'usersCount' => User::count()
		];

		return view("admin.users", $data);
	}
}
