<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunctionalSuggestionsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('functional_suggestions', function (Blueprint $table){
			$table->increments('id');
			$table->integer('creator_id')->nullable()->unsigned();
			$table->foreign('creator_id')->references('id')->on('users');
			$table->string('name');
			$table->text('description')->nullable();
			$table->integer('votes')->nullable()->unsigned()->default(0);
			$table->text('user_ids')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('functional_suggestions');
	}
}
