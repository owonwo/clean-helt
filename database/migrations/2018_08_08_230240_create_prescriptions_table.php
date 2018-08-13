<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('record_id')->unsigned();
            $table->foreign('record_id')->references('id')->on('medical_records')->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('frequency');
            $table->string('name');
            $table->integer('pharmacy_id')->nullable()->unsigned();
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('cascade');
            // Diagnosis ID at this level might not work
            $table->integer('diagnosis_id')->unsigned()->nullable();
            $table->foreign('diagnosis_id')->references('id')->on('diagnoses')->onDelete('cascade');
            $table->text('comment')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('prescriptions');
    }
}
