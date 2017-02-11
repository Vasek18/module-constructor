<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProjectPulsePost;

class ProjectPulsePostController extends Controller{

	public function index(Request $request){
		$data = [
			'posts' => ProjectPulsePost::orderBy('created_at', 'desc')->orderBy('id', 'desc')->get()
		];

		return view("project_pulse.index", $data);
	}
}