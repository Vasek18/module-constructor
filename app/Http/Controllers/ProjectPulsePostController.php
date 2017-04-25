<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProjectPulsePost;

class ProjectPulsePostController extends Controller{

	public function index(Request $request){
		$data = [
			'posts' => ProjectPulsePost::orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(10)
		];

		return view("project_pulse.index", $data);
	}

	public function destroy(ProjectPulsePost $post, Request $request){
		if (!$this->user || !$this->user->isAdmin()){
			return abort(404);
		}
		$post->delete();

		return back();
	}
}