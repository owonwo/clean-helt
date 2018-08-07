<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctors_id')->unsigned();
            $table->foreign('doctors_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->boolean('mode_of_contact')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('kin_fullname')->nullable();
            $table->string('kin_address')->nullable();
            $table->string('kin_phone')->nullable();
            $table->string('kin_city')->nullable();
            $table->string('kin_state')->nullable();
            $table->string('kin_country')->nullable();
            $table->string('name_of_degree')->nullable();
            $table->string('institution')->nullable();
            $table->longText('additional_degree')->nullable();
            $table->integer('years_in_practice')->nullable();
            $table->boolean('active')->default(true);
            $table->string('avatar')->nullable();
            $table->text('disability')->nullable();
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
        Schema::dropIfExists('doctor_profiles');
    }
}
