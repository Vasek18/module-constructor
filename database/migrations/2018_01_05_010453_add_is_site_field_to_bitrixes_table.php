<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsSiteFieldToBitrixesTable extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('bitrixes', function(Blueprint $table){
            $table->boolean('is_site')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('bitrixes', function(Blueprint $table){
            $table->dropColumn('is_site')->nullable();
        });
    }
}
