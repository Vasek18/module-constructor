<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUsersController extends Controller{
	public function index(){
		$data = [
			'usersCount' => User::count(),
			'users'      => User::all(),
		];

		return view("admin.users.index", $data);
	}

	public function show(User $user){
		$data = [
			'user'     => $user,
			'bitrixes' => $user->bitrixes,
		];

		return view("admin.users.detail", $data);
	}

	public function update(User $user, Request $request){
		if ($request->payed_days){
			$user->payed_days = $request->payed_days;
			$user->save();
		}

		return back();
	}
}
