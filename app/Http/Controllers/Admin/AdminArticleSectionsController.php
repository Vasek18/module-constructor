<?php

namespace App\Http\Controllers\Admin;

use App\Models\ArticleSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class AdminArticleSectionsController extends Controller{
	public function index(){
		//
	}

	public function create(){
		return view("admin.articles.section_edit");
	}

	public function store(Request $request){
		$section = ArticleSection::create($request->all());

		return redirect(action('Admin\AdminArticleSectionsController@edit', [$section]));
	}

	public function show(ArticleSection $section){

		// запоминаем в сессии, что мы были на категории (на странице создания понадобится)
		session()->flash('article_section', [
			'id' => $section->id
		]);

		return view("admin.articles.section", [
			'section'  => $section,
			'articles' => $section->articles()->orderBy('sort')->get(),
		]);
	}

	public function edit(ArticleSection $section){
		return view("admin.articles.section_edit", ['section' => $section]);
	}

	public function update(Request $request, ArticleSection $section){
		$section->update($request->all());

		return redirect(action('Admin\AdminArticleSectionsController@edit', [$section]));

	}

	public function destroy(ArticleSection $section){
		$section->delete();

		return back();
	}
}
