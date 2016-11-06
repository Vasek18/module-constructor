<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model{
	protected $table = 'articles';
	protected $fillable = ['section_id', 'code', 'name', 'preview_text', 'detail_text', 'picture',];

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

	public function getLinkAttribute(){
		if ($this->section_id){
			return action('ArticleController@show', [$this->section->code, $this->code]);
		}
	}

	public function section(){
		return $this->belongsTo('App\Models\ArticleSection');
	}
}