<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model{
	protected $table = 'articles';
	protected $fillable = ['section_id', 'sort', 'code', 'name', 'preview_text', 'detail_text', 'picture', 'active', 'seo_title', 'seo_keywords', 'seo_description'];

	public $parentFilesFolder = 'articles_files';

	public function scopeParentSection($query, ArticleSection $section){
		return $query->where('section_id', $section->id);
	}

	public static function useCasesArticles(){
		$section = ArticleSection::where('code', 'use_cases')->first();
		if ($section){
			return Article::where('section_id', $section->id);
		}else{
			return false;
		}
	}

	public function scopeActive($query){
		return $query->where('active', true);
	}

	public function getLinkAttribute(){
		if ($this->section_id){
			return action('ArticleController@show', [$this->section->code, $this->code]);
		}
	}

	public function getFilesFolderAttribute(){
		$parentFolder = DIRECTORY_SEPARATOR.$this->parentFilesFolder;
		$folder = $parentFolder.DIRECTORY_SEPARATOR.$this->id;

		// если нет папки, создаём её
		if (!is_dir(public_path().$parentFolder)){
			mkdir(public_path().$parentFolder);

			if (!is_dir(public_path().$folder)){
				mkdir(public_path().$folder);
			}
		}

		return $folder;
	}

	public function section(){
		return $this->belongsTo('App\Models\ArticleSection');
	}

	public function files(){
		return $this->hasMany('App\Models\ArticleFile', 'article_id');
	}
}