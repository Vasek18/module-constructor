<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesClientsIssuesTable extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('modules_clients_issues', function(Blueprint $table){
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('bitrixes')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('solution_description')->nullable();
            $table->boolean('is_solved')->nullable()->default(false);
            $table->integer('appeals_count')->unsigned()->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('modules_clients_issues');
    }
}
