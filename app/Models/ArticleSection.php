<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleSection extends Model{
	protected $table = 'article_sections';
	protected $fillable = ['code', 'name', 'preview_text', 'detail_text', 'picture',];

}