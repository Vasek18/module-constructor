<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FunctionalSuggestion;

class FunctionalSuggestionController extends Controller{

	public function index(Request $request){
		$suggestions = FunctionalSuggestion::all();

		$data = [
			'suggestions' => $suggestions
		];

		return view("functional_suggestion.index", $data);
	}

	public function create(){
		//
	}

	public function store(Request $request){
		//
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
