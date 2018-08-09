<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboratoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('chcode')->unique();
            $table->string('licence_no')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->uniuqe();
            $table->string('lhcode')->uniuqe();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('lab_owner')->nullable();
            $table->string('cac_reg')->nullbale();
            $table->string('fmoh_reg')->nullable();
            $table->boolean('active')->default(true);
            $table->string('avatar')->nullable();
            $table->text('offers');
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
        Schema::dropIfExists('laboratories');
    }
}
