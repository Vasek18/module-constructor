<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesCompetitorsTable extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('modules_competitors', function(Blueprint $table){
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('bitrixes')->onDelete('cascade');
            $table->string('name');
            $table->string('link');
            $table->integer('sort')->unsigned()->nullable()->default(500);
            $table->integer('price')->unsigned()->nullable()->default(0);
            $table->string('picture_src')->nullable();
            $table->text('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('modules_competitors');
    }
}
