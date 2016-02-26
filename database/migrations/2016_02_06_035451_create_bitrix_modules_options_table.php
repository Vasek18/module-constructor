<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixModulesOptionsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_modules_options', function (Blueprint $table){
			$table->increments('id');
			$table->integer('module_id')->unsigned();
			$table->foreign('module_id')->references('id')->on('bitrixes')->onDelete('cascade');
			$table->integer('type_id')->unsigned();
			$table->string('code');
			$table->string('name');
			$table->integer('height')->nullable()->default(3);
			$table->integer('width')->nullable()->default(20);
			$table->string('spec_vals')->nullable();
			$table->string('spec_vals_args')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_modules_options');
	}
}
