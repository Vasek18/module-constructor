<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FunctionalSuggestion;

class FunctionalSuggestionController extends Controller{

	public function index(Request $request){
		$suggestions = FunctionalSuggestion::orderBy('created_at', 'desc')->get();

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
			return back()->withErrors(['Такое предложение уже существует']);;
		}

		$userID = null;
		if ($this->user){
			$userID = $this->user->id;
		}

		FunctionalSuggestion::create([
			'creator_id'  => $userID,
			'name'        => $request->name,
			'description' => $request->description,
		]);

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

	public function destroy($id){
		//
	}
}
