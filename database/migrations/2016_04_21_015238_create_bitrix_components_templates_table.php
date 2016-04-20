<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixComponentsTemplatesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_components_templates', function (Blueprint $table){
			$table->increments('id');
			$table->integer('component_id')->unsigned();
			$table->foreign('component_id')->references('id')->on('bitrix_components')->onDelete('cascade');
			$table->string('code');
			$table->string('name');
			$table->text('template_php'); // todo я не уверен, что здесь его место
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_components_templates');
	}
}
