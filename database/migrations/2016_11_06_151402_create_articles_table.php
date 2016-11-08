<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('articles', function (Blueprint $table){
			$table->increments('id');
			$table->boolean('active')->default(false);
			$table->integer('sort')->nullable()->default(500);
			$table->integer('section_id')->unsigned()->nullable();
			$table->foreign('section_id')->references('id')->on('article_sections')->onDelete('cascade');
			$table->string('code');
			$table->string('name');
			$table->text('preview_text')->nullable();
			$table->longText('detail_text')->nullable();
			$table->string('picture')->nullable();
			$table->string('seo_title')->nullable();
			$table->string('seo_keywords')->nullable();
			$table->string('seo_description')->nullable();
			$table->timestamps();
		});

		DB::table('article_sections')->insert([
			'active' => true,
			'code'   => 'use_cases',
			'name'   => 'Примеры использования сервиса',
		]);
		$useCases = \App\Models\ArticleSection::where('code', 'use_cases')->first();

		DB::table('articles')->insert([
			'section_id' => $useCases->id,
			'active'     => false,
			'code'       => 'infoblock',
			'name'       => 'Свой инфоблок',
		]);

		DB::table('articles')->insert([
			'section_id' => $useCases->id,
			'active'     => false,
			'code'       => 'component',
			'name'       => 'Выложить компонент на Marketplace',
		]);

		DB::table('articles')->insert([
			'section_id' => $useCases->id,
			'active'     => false,
			'code'       => 'event_handler',
			'name'       => 'Привязать обработчик к событию',
		]);

		DB::table('articles')->insert([
			'section_id' => $useCases->id,
			'active'     => false,
			'code'       => 'svoya_biblioteka_v_formate_modulya',
			'name'       => 'Своя библиотека в формате модуля',
		]);

		DB::table('articles')->insert([
			'section_id' => $useCases->id,
			'active'     => false,
			'code'       => 'razrabotka_komponenta',
			'name'       => 'Создать компонент',
		]);

		DB::table('articles')->insert([
			'section_id' => $useCases->id,
			'active'     => false,
			'code'       => 'sozdanie_nastroek_modulya',
			'name'       => 'Создание настроек модуля',
		]);

		DB::table('articles')->insert([
			'section_id' => $useCases->id,
			'active'     => false,
			'code'       => 'punkt_administrativnogo_menyu',
			'name'       => 'Пункт административного меню',
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('articles');
	}
}
