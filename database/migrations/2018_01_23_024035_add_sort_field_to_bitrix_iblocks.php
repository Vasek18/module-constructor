<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortFieldToBitrixIblocks extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table('bitrix_infoblocks', function(Blueprint $table){
            $table->integer('sort')->unsigned()->nullable()->default(500);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('bitrix_infoblocks', function(Blueprint $table){
            $table->dropColumn('sort')->nullable();
        });
    }
}
