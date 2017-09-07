<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixUserFieldsTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_user_fields', function (Blueprint $table){
			$table->increments('id');
			$table->integer('module_id')->unsigned();
			$table->foreign('module_id')->references('id')->on('bitrixes')->onDelete('cascade');
			$table->string('user_type_id');
			$table->string('entity_id');
			$table->string('field_name');
			$table->string('xml_id');
			$table->string('sort');
			$table->boolean('multiple');
			$table->boolean('mandatory');
			$table->string('show_filter');
			$table->boolean('show_in_list');
			$table->boolean('edit_in_list');
			$table->boolean('is_searchable');
			$table->text('settings'); // это по идее массивы
			$table->text('edit_form_label'); // это по идее массивы
			$table->text('list_column_label'); // это по идее массивы
			$table->text('list_filter_label'); // это по идее массивы
			$table->text('error_message'); // это по идее массивы
			$table->text('help_message'); // это по идее массивы
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::dropIfExists('bitrix_user_fields');
	}
}
