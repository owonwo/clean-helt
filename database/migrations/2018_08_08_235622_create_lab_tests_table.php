<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('record_id');
            $table->integer('test_name')->nullable();
            $table->text('description')->nullable();
            $table->text('result')->nullable();
            $table->text('conclusion')->nullable();
            $table->boolean('status')->default(false);
            $table->string('taker')->nullable();
            $table->integer('diagnosis_id')->nullable();
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
        Schema::dropIfExists('lab_tests');
    }
}
