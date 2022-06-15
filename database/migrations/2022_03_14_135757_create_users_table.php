<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('firstname', 32);

            $table->string('lastname', 32);

            $table->string('login', 32)->unique();

            $table->string('password', 128);

            $table->string('salt', 32);

            $table->string('phone_number', 16)->nullable()->unique();

            $table->string('mail', 64)->nullable()->unique();

            $table->string('avatar', 32)->nullable();

            $table->unsignedInteger('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations');

            $table->unsignedTinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
