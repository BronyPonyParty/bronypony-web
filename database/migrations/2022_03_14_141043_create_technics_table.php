<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->unsignedInteger('number');
            $table->unsignedInteger('date_purchase');
            $table->string('description', 1024)->nullable();
            $table->unsignedInteger('provider_id');
            $table->unsignedInteger('organization_id');
            $table->unsignedInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technics');
    }
}
