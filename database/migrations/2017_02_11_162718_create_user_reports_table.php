<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserReportsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('user_reports', function (Blueprint $table){
			$table->increments('id');
			$table->integer('user_id')->nullable()->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('user_email')->nullable();
			$table->string('name')->nullable();
			$table->text('description')->nullable();
			$table->integer('priority_points')->unsigned()->nullable()->default(0);
			$table->boolean('is_duplicate')->nullable()->default(false);
			$table->integer('status_id')->unsigned()->nullable();
			$table->integer('type_id')->unsigned()->nullable();
			$table->integer('page_id')->unsigned()->nullable();
			$table->string('page_link')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::dropIfExists('user_reports');
	}
}
