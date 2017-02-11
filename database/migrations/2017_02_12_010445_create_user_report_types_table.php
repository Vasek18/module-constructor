<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserReportTypesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('user_report_types', function (Blueprint $table){
			$table->increments('id');
			$table->string('code');
			$table->string('name')->nullable();
			$table->text('description')->nullable();
		});

		DB::table('user_report_types')->insert(
			array(
				'code' => 'error',
				'name' => 'Ошибка',
			)
		);
		DB::table('user_report_types')->insert(
			array(
				'code' => 'suggestion',
				'name' => 'Предложение',
			)
		);
		DB::table('user_report_types')->insert(
			array(
				'code' => 'lack',
				'name' => 'Недостаёт',
			)
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::dropIfExists('user_report_types');
	}
}
