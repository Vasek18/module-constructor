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
}
