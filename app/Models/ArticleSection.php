<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleSection extends Model{
	protected $table = 'article_sections';
	protected $fillable = ['code', 'sort', 'name', 'preview_text', 'detail_text', 'picture', 'active', 'seo_title', 'seo_keywords', 'seo_description'];

	public function scopeActive($query){
		return $query->where('active', true);
	}

	public function getLinkAttribute(){
		return action('ArticleSectionController@show', [$this->code]);
	}

	public function articles(){
		return $this->hasMany('App\Models\Article', 'section_id');
	}
}