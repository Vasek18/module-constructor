<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class AdminArticlesController extends Controller{
	public function index(){
		//
	}

	public function create(){
		return view("admin.articles.article_edit", [
			'sections' => ArticleSection::all(),
		]);
	}

	public function store(Request $request){
		$article = Article::create($request->all());

		return redirect(action('Admin\AdminArticlesController@edit', [$article]));
	}

	public function show(Article $article){
		return view("admin.articles.article_edit", [
			'article' => $article,
		]);
	}

	public function edit(Article $article){
		return view("admin.articles.article_edit", [
			'article'  => $article,
			'sections' => ArticleSection::all(),
		]);
	}

	public function update(Request $request, Article $article){
		$article->update($request->all());

		return redirect(action('Admin\AdminArticlesController@edit', [$article]));

	}

	public function destroy($id){
		//
	}
}
