<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('chcode')->unique();
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->string('phone')->unique();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullbale();
            $table->string('country')->nullable();
            $table->boolean('active')->default(true);
            $table->string('religion')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('token')->nullable();
            $table->string('nok_name')->nullable();
            $table->string('nok_phone')->nullable();
            $table->string('nok_email')->nullable();
            $table->string('nok_address')->nullable();
            $table->string('nok_city')->nullable();
            $table->string('nok_state')->nullable();
            $table->string('verifyToken');
            $table->boolean('status')->default(false);
            $table->string('nok_country')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
