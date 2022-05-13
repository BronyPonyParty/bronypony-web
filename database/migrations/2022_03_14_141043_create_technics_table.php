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
            $table->integer('number');
            $table->integer('date_purchase');
            $table->string('description', 1024)->nullable();
            $table->integer('provider_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->string('status', 32);
            $table->timestamps();
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
