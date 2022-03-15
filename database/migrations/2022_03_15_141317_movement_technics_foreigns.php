<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MovementTechnicsForeigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movement_technics', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('technic_id')->references('id')->on('technics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movement_technics', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['technic_id']);
        });
    }
}
