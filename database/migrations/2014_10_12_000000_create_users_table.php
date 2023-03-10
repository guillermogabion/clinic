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
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('birthdate');
            $table->string('age')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('user_type')->default(0);
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('medical')->default(0);
            $table->string('medical_record')->nullable();
            $table->boolean('dental')->default(0);
            $table->string('dental_record')->nullable();
            $table->rememberToken();
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
