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
			$table->string('code');
			$table->string('name');
			$table->text('preview_text')->nullable();
			$table->text('detail_text')->nullable();
			$table->string('picture')->nullable();
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
