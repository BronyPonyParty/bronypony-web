<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MovementListsForeigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movement_lists', function (Blueprint $table) {
            $table->foreign('premise_id')->references('id')->on('premises');
            $table->foreign('movement_technic_id')->references('id')->on('movement_technics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movement_lists', function (Blueprint $table) {
            $table->dropForeign(['premise_id']);
            $table->dropForeign(['movement_technic_id']);
        });
    }
}
