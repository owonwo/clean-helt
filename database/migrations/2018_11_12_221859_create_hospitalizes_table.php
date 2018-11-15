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
            $table->string("hospitalization_type");
            $table->string("hospital");
            $table->string("doctor");
            $table->string("reason");
            $table->string("complications");
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
