<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixComponentsClassPhpTemplatesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_components_class_php_templates', function (Blueprint $table){
			$table->increments('id');
			$table->integer('creator_id')->nullable()->unsigned();
			$table->foreign('creator_id')->references('id')->on('users');
			$table->string('name');
			$table->string('code')->nullable();
			$table->text('template')->nullable();
			$table->boolean('show_everyone')->nullable()->default(false);
			$table->boolean('need_edit')->nullable()->default(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_components_class_php_templates');
	}
}
