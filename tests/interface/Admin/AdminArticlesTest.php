<?php

use App\Models\Article;
use App\Models\ArticleSection;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminArticlesTest extends TestCase{

	use DatabaseTransactions;

	protected $path = 'articles';

	protected $adminUserGroup = 1;
	protected $defaultUserGroup = 2;

	/** @test */
	function common_user_cant_get_to_admin_page(){
		$this->signIn();

		$this->visit('/oko/'.$this->path);

		$this->seePageIs('/personal');
	}

	/** @test */
	function admin_user_can_get_to_admin_page(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/oko/'.$this->path);

		$this->seePageIs('/oko/'.$this->path);
	}

	/** @test */
	function it_shows_all_categories(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$section1 = ArticleSection::create([
			'code' => 'test',
			'name' => 'Тестовая категория',
		]);

		$section2 = ArticleSection::create([
			'code' => 'ololo',
			'name' => 'Ещё категория',
		]);

		$this->visit('/oko/'.$this->path);

		$this->see('Тестовая категория');
		$this->see('Ещё категория');
	}

	/** @test */
	function it_can_add_category(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$this->visit('/oko/article_sections/create');

		$this->submitForm('save', [
			'name'         => 'Тест',
			'code'         => 'test',
			'preview_text' => 'Текст анонса',
			'detail_text'  => 'Детальный текст',
		]);

		$this->visit('/oko/articles');

		$this->see('Тест');
		$this->see('test');
	}

	/** @test */
	function it_shows_articles_in_categories(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$section1 = ArticleSection::create([
			'code' => 'test',
			'name' => 'Тестовая категория',
		]);

		$element1 = Article::create([
			'section_id' => $section1->id,
			'code'       => 'ololo',
			'name'       => 'Трололошный',
		]);

		$this->visit('/oko/'.$this->path);

		$this->see('Тестовая категория');
		$this->dontSee('Трололошный');

		$this->visit('/oko/article_sections/'.$section1->id);

		$this->see('Тестовая категория');
		$this->see('Трололошный');
	}

	/** @test */
	function it_can_add_article(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$section1 = ArticleSection::create([
			'code' => 'test',
			'name' => 'Тестовая категория',
		]);

		$this->visit('/oko/articles/create');

		$this->submitForm('save', [
			'section_id'   => $section1->id,
			'name'         => 'Тестовый',
			'code'         => 'tester',
			'preview_text' => 'Текст анонса',
			'detail_text'  => 'Детальный текст',
		]);

		$this->visit('/oko/article_sections/'.$section1->id);

		$this->see('Тестовый');
		$this->see('tester');
	}

	/** @test */
	function it_can_substitute_category_id(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$section1 = ArticleSection::create([
			'code' => 'test',
			'name' => 'Тестовая категория',
		]);

		// со страницы категории
		$this->visit('/oko/article_sections/'.$section1->id);
		// переходим на страницу создания
		$this->visit('/oko/articles/create');

		$this->seeIsSelected('section_id', $section1->id);
	}

	/** @test */
	function it_can_delete_category(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$section1 = ArticleSection::create([
			'code' => 'test',
			'name' => 'Тестовая категория',
		]);

		$this->visit('/oko/'.$this->path);

		$this->see('Тестовая категория');

		$this->click('delete'.$section1->id);

		$this->dontSee('Тестовая категория');
	}

	/** @test */
	function it_can_delete_article(){
		$this->signIn(null, [
			'group_id' => $this->adminUserGroup
		]);

		$section1 = ArticleSection::create([
			'code' => 'test',
			'name' => 'Тестовая категория',
		]);

		$element1 = Article::create([
			'section_id' => $section1->id,
			'code'       => 'ololo',
			'name'       => 'Трололошный',
		]);

		$this->visit('/oko/article_sections/'.$section1->id);

		$this->see('Трололошный');

		$this->click('delete'.$element1->id);

		$this->dontSee('Трололошный');
	}

	// /** @test */ // todo
	// function it_can_add_article_with_file(){ }
	//
	// /** @test */ // todo
	// function it_can_add_file_to_existing_article(){ }
	//
	// /** @test */ // todo
	// function it_can_delete_file(){ }
}