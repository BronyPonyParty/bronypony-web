<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TechnicsForeigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technics', function (Blueprint $table) {
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technics', function (Blueprint $table) {
            $table->dropForeign(['provider_id']);
            $table->dropForeign(['organization_id']);
        });
    }
}
