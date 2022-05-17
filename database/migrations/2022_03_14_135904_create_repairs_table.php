<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('report_id');
            $table->foreign('report_id')->references('id')->on('reports');

            $table->unsignedInteger('repairman_id');
            $table->foreign('repairman_id')->references('id')->on('users');

            $table->string('description', 512)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repairs');
    }
}
