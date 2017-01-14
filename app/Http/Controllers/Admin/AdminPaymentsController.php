<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pays;
use App\Http\Controllers\Controller;

class AdminPaymentsController extends Controller{
	public function index(){
		$data = [
			'pays' => Pays::orderBy('created_at', 'desc')->get()
		];

		return view("admin.payments.index", $data);
	}
}