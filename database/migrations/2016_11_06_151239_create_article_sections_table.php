<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleSectionsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('article_sections', function (Blueprint $table){
			$table->increments('id');
			$table->integer('section_id')->unsigned()->nullable();
			$table->foreign('section_id')->references('id')->on('article_sections');
			$table->boolean('active')->default(false);
			$table->integer('sort')->nullable()->default(500);
			$table->string('code');
			$table->string('name');
			$table->text('preview_text')->nullable();
			$table->text('detail_text')->nullable();
			$table->string('picture')->nullable();
			$table->string('seo_title')->nullable();
			$table->string('seo_keywords')->nullable();
			$table->string('seo_description')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('article_sections');
	}
}
