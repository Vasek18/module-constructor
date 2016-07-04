<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixAdminMenuPagesTable extends Migration{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		Schema::create('bitrix_admin_menu_pages_items', function (Blueprint $table){
			$table->increments('id');
			$table->integer('module_id')->unsigned();
			$table->foreign('module_id')->references('id')->on('bitrixes')->onDelete('cascade');
			$table->string('name')->nullable();
			$table->string("code");
			$table->integer('sort')->unsigned()->default(500);
			$table->string("parent_menu");
			$table->string("icon")->nullable();
			$table->string("page_icon")->nullable();
			$table->string("text");
			$table->string("title")->nullable();
			$table->longText("php_code")->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		Schema::drop('bitrix_admin_menu_pages_items');
	}
}
