<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('record_id');
            $table->string("insurance_type");
            $table->string("company_name");
            $table->string("address");
            $table->string("city");
            $table->string("phone");
            $table->string("emergency_phone");
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
        Schema::dropIfExists('health_insurances');
    }
}
