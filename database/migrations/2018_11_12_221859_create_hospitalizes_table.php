<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('record_id');
            $table->string("hospitalization_type")->nullable();
            $table->string("hospital")->nullable();
            $table->string("doctor")->nullable();
            $table->string("reason")->nullable();
            $table->string("complications")->nullable();
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
        Schema::dropIfExists('hospitalizes');
    }
}
