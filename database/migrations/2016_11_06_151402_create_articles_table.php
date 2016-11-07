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
			$table->integer('sort')->nullable();
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
