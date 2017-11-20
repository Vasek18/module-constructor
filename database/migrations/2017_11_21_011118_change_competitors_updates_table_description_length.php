<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCompetitorsUpdatesTableDescriptionLength extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('modules_competitors_updates', function(Blueprint $table){
            DB::statement('ALTER TABLE modules_competitors_updates MODIFY description LONGTEXT;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('modules_competitors_updates', function(Blueprint $table){
            //
        });
    }
}
