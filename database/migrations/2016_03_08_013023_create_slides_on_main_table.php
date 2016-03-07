<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesOnMainTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('slides_on_main', function (Blueprint $table){
			$table->increments('id');
			$table->integer('sort')->unsigned()->default(500);
			$table->string('image_path')->nullable();
			$table->text('body')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('slides_on_main');
	}
}
