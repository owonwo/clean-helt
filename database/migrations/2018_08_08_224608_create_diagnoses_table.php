<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('record_id')->unsigned();
            $table->string('complaint_history');
            $table->string('complaint_relationship');
            $table->enum('patient_condition', [1, 2, 3])->comment('1 - Improved, 2 - Worsened, 3 - Unchanged');
            $table->text('symptoms')->nullable();
            $table->text('extras')->nullable();
            $table->text('comments');
            $table->timestamps();

            $table->foreign('record_id')->references('id')->on('medical_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnoses');
    }
}
