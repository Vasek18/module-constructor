<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\ArticleSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\ArticleFile;
use Illuminate\Http\UploadedFile;

class AdminArticlesFilesController extends Controller{
	public function index(){
		//
	}

	public function create(){
	}

	public function store(Request $request){
	}

	public function show(Article $article){
	}

	public function edit(Article $article){
	}

	public function update(Request $request, Article $article){
	}

	public function upload(Article $article, Request $request){
		$this->saveFile($article, $request->file('file'));
	}

	public function saveFile(Article $article, UploadedFile $file){
		$name = basename($file->getClientOriginalName());
		$extension = $file->getClientOriginalExtension();
		$newName = translit($name); // точка не исчезает
		$path = $article->filesFolder.DIRECTORY_SEPARATOR;
		// dd($newName);

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

	public function destroy(Article $article, ArticleFile $file){
		if (file_exists(public_path().$file->path)){
			$file->deleteFile();
		}
		$file->delete();

		return back();
	}
}