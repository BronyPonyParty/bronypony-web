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
            $table->string('lastname', 64);
            $table->string('firstname', 64);
            $table->string('middlename', 64)->nullable();
            $table->string('login', 64)->unique();
            $table->string('password', 32);
            $table->string('phone_number', 16)->nullable()->unique();
            $table->string('mail', 64)->unique();
            $table->string('avatar', 32)->nullable();
            $table->integer('organization_id')->unsigned();
            $table->boolean('status');
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
        Schema::dropIfExists('users');
    }
}
