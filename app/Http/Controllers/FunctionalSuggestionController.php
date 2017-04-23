<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FunctionalSuggestion;
use Illuminate\Support\Facades\Mail;

class FunctionalSuggestionController extends Controller{

	public function index(Request $request){
		$suggestions = FunctionalSuggestion::orderBy('votes', 'desc')->orderBy('created_at', 'desc')->get();

		$data = [
			'suggestions' => $suggestions
		];

		return view("functional_suggestion.index", $data);
	}

	public function create(){
		//
	}

	public function store(Request $request){
		if (FunctionalSuggestion::where('name', $request->name)->count()){
			return back()->withErrors([trans('functional_suggestion.such_suggestion_is_already_exists')]);;
		}

		$userID = null;
		if ($this->user){
			$userID = $this->user->id;
		}

		FunctionalSuggestion::create([
			'creator_id'  => $userID,
			'name'        => $request->name,
			'description' => $request->description,
			'votes'       => $userID ? 1 : 0,
			'user_ids'    => $userID ? json_encode([$userID]) : '',
		]);

		$mail = Mail::send('emails.new_functional_suggestion', ['name' => $request->name, 'description' => $request->description], function ($m){
			$m->to(env('GOD_EMAIL'))->subject('Предложение по функционалу');
		});

		return back();
	}

	public function show($section_code, $article_code){

	}

	public function edit($id){
		//
	}

	public function update(Request $request, $id){
		//
	}

	// голосовать
	public function upvote(FunctionalSuggestion $suggestion, Request $request){
		if ($this->user){
			$suggestion->upvote($this->user->id);
		}

		return back();
	}

	public function destroy(FunctionalSuggestion $suggestion, Request $request){
		if ($this->user && $this->user->isAdmin()){
			$suggestion->delete();
		}

		return back();
	}

}
