<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\ArticleSection;
use App\Models\Article;

class ArticleDetailPageTest extends TestCase{

	use DatabaseTransactions;

	protected $baseUrl = 'http://localhost'; // todo не знаю почему здесь так

	/** @test */
	function it_can_show_detail_page_of_article_that_has_parent_section(){
		$section = ArticleSection::create([
			'code' => 'test',
			'name' => 'Тестовая категория',
		]);
		$article = Article::create([
			'section_id' => $section->id,
			'code'       => 'test',
			'name'       => 'Тестовая статья',
		]);

		$this->visit($article->link);
		$this->see('Тестовая статья');
		$this->seePageIs('/test/test');
	}

}

?>