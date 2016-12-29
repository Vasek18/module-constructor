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

	public function destroy(Article $article, ArticleFile $file){
		$file->deleteFile();
		$file->delete();

		return back();
	}
}
