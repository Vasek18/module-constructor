<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleFile extends Model{
	protected $table = 'articles_files';
	protected $fillable = ['article_id', 'path', 'title', 'alt', 'extension', 'original_name'];
	public $timestamps = false;

	public $imgExts = ['jpg', 'jpeg', 'png'];

	public function deleteFile(){
		unlink(public_path().$this->path);
	}

	public function getTagAttribute(){
		if ($this->isImg()){
			$tag = '<img src="'.$this->path.'"/>';
		}
		else{
			$tag = '<a href="'.$this->path.'"/>';
		}

		return $tag;
	}
	public function isImg(){
		if (in_array($this->extension, $this->imgExts)){
			return true;
		}

		return false;
	}

	public function article(){
		return $this->belongsTo('App\Models\Article');
	}
}