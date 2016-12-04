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
		if ($request->paid_days){
			$user->paid_days = $request->paid_days;
			$user->save();
		}

		return back();
	}

	public function destroy(User $user, Request $request){
		foreach ($user->modules as $module){
			$module->deleteFolder();
			$module->delete();
		}

		$user->delete();

		return redirect(action('Admin\AdminUsersController@index'));
	}
}
