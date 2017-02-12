<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectPulsePost;

class AdminProjectPulseController extends Controller{
	public function index(){
		$data = [];

		return view("admin.project_pulse.index", $data);
	}

	public function store(Request $request){
		ProjectPulsePost::create([
			'name'        => $request->name,
			'description' => $request->description,
			'highlight'   => $request->highlight == 'y',
		]);

		return back();
	}
}
