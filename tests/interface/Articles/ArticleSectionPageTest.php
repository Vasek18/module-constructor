<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\ArticleSection;
use App\Models\Article;

/** @group articles */
class ArticleSectionPageTest extends TestCase{

	use DatabaseTransactions;

	protected $baseUrl = 'http://localhost'; // todo не знаю почему здесь так

	/** @test */
	function it_can_show_section_page(){
		$section = ArticleSection::create([
			'active' => true,
			'code'   => 'test',
			'name'   => 'Тестовая категория',
		]);
		$article = Article::create([
			'active'     => true,
			'section_id' => $section->id,
			'code'       => 'test',
			'name'       => 'Тестовая статья',
		]);

		$this->visit($section->link);
		$this->see('Тестовая категория');
		$this->see('Тестовая статья');
		$this->seePageIs('/test');
	}
	/** @test */
	function it_doesnt_show_inactive_section_page(){
		$section = ArticleSection::create([
			'code'   => 'test',
			'name'   => 'Тестовая категория',
		]);
		$article = Article::create([
			'active'     => true,
			'section_id' => $section->id,
			'code'       => 'test',
			'name'       => 'Тестовая статья',
		]);

		$this->call('GET', $section->link);
		$this->assertResponseStatus(404);
	}
}

?>