<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesFilesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('articles_files', function (Blueprint $table){
			$table->increments('id');
			$table->integer('article_id')->unsigned()->nullable();
			$table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
			$table->string('path');
			$table->string('title');
			$table->string('alt');
			$table->string('extension');
			$table->string('original_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('articles_files');
	}
}
