<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleFile extends Model{
	protected $table = 'articles_files';
	protected $fillable = ['article_id', 'path', 'title', 'alt', 'extension', 'original_name'];
	public $timestamps = false;

	public function getTagAttribute(){
		$tag = '<img src='.$this->path.'/>';

		return $tag;
	}

	public function article(){
		return $this->belongsTo('App\Models\Article');
	}
}