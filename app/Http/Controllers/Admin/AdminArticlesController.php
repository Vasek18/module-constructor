<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\ArticleFile;
use Illuminate\Http\UploadedFile;

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

		$this->saveFiles($article, $request);

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

		$this->saveFiles($article, $request);

		return redirect(action('Admin\AdminArticlesController@edit', [$article]));
	}

	public function saveFiles(Article $article, Request $request){
		$files = $request->file('file');

		foreach ($files as $file){
			if ($file){
				$this->saveFile($article, $file);
			}
		}
	}

	public function saveFile(Article $article, UploadedFile $file){
		$name = basename($file->getClientOriginalName());
		$extension = $file->getClientOriginalExtension();
		$newName = translit($name); // точка не исчезает
		$path = $article->filesFolder.DIRECTORY_SEPARATOR;

		// проверка на уникальность
		if (ArticleFile::where('path', $path.$newName)->count()){
			return ArticleFile::where('path', $path.$newName)->get();
		}

		// сохраняем файл
		$file->move(public_path().$path, $newName);

		// создаём запись в бд
		return ArticleFile::create([
			'article_id'    => $article->id,
			'path'          => $path.$newName,
			'title'         => '',
			'alt'           => '',
			'extension'     => $extension,
			'original_name' => $name,
		]);
	}

	public function destroy(Article $article){
		$article->delete();

		return back();
	}
}
