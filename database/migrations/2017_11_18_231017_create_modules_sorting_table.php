<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesSortingTable extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('modules_sorting', function(Blueprint $table){
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('bitrixes')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('sort')->unsigned()->default(500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('modules_sorting');
    }
}
