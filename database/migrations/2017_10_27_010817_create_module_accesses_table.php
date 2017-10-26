<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleAccessesTable extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('modules_accesses', function(Blueprint $table){
            $table->increments('id');
            $table->string('user_email');
            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('bitrixes')->onDelete('cascade');
            $table->string('permission_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('module_accesses');
    }
}
