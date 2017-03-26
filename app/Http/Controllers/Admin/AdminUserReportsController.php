<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User\UserReport;

class AdminUserReportsController extends Controller{
	public function index(){
		$data = [
			'reports' => UserReport::orderBy('created_at', 'desc')->get()
		];

		return view("admin.user_reports.index", $data);
	}

	public function destroy(UserReport $report){
		$report->delete();

		return back();
	}
}
