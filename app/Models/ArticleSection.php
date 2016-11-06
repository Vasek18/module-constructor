<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleSection extends Model{
	protected $table = 'article_sections';
	protected $fillable = ['code', 'name', 'preview_text', 'detail_text', 'picture',];

	public function getLinkAttribute(){
		return action('ArticleSectionController@show', [$this->code]);
	}

	public function articles(){
		return $this->hasMany('App\Models\Article', 'section_id');
	}
}