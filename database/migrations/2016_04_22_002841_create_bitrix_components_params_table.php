<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitrixComponentsParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitrix_components_params', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('component_id')->unsigned();
			$table->foreign('component_id')->references('id')->on('bitrix_components')->onDelete('cascade');
			$table->integer('type_id')->unsigned();
			$table->foreign('type_id')->references('id')->on('bitrix_components_params_types');
			$table->integer('sort')->unsigned()->nullable()->default(500);
			$table->string('code');
			$table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bitrix_components_params');
    }
}
