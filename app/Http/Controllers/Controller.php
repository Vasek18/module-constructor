<?php

namespace App\Http\Controllers;

use App\Models\ArticleSection;
use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Article;

abstract class Controller extends BaseController{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $user;

	public function __construct(){

		$this->user = Auth::user();

		view()->share('signedIn', Auth::check());
		view()->share('user', $this->user);
		if (Article::useCasesArticles()){
			view()->share('use_cases_articles', Article::useCasesArticles()->active()->orderBy('sort')); // статьи о примерах использования
		}
		if ($sectionAbout = ArticleSection::where('code', 'about')->first()){
			view()->share('about_service_articles', Article::parentSection($sectionAbout)->active()->orderBy('sort')); // статьи о сервисе
		}
	}
}